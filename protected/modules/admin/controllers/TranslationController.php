<?php
class TranslationController extends Controller
{
	private $languageTab;
    
    public function actionIndex()
	{
        $this->languageTab = (!is_null(Yii::app()->request->getQuery('languageTab')) 
            ? Yii::app()->request->getQuery('languageTab') : Yii::app()->user->language);
                
        $search=new SourceMessage('search');
		$search->unsetAttributes();

        if(!is_null(Yii::app()->request->getQuery('SourceMessage')))
            $search->attributes=Yii::app()->request->getQuery('SourceMessage');
        
		$criteria=new CDbCriteria;
		$criteria->compare('t.message',$search->message,true);

		$dataProvider=new ActiveDataProvider('SourceMessage',array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>array('category'=>true),
				'sortVar'=>'sort',
			),
            'pagination'=>array(
                'pageVar'=>'page',
                'sizeVar'=>'size',
                'pageSize'=>Yii::app()->params['defaultPageSize'],
                'sizeOptions'=>Yii::app()->params['sizeOptions'],
            ),
		));
        
        $tabs = array();
        $languages = Language::model()->visible()->findAll();
        foreach ($languages as $language)
        {
            if ($this->languageTab == $language->code)
                $tabs[] = array('label'=>$language->title, 'content'=>$this->renderPartial('_grid', array('dataProvider'=>$dataProvider,'search'=>$search), true, false), 'linkOptions'=>array('id'=>$language->code, 'class'=>'langLink'), 'active'=>true);
            else 
                $tabs[] = array('label'=>$language->title, 'content'=>'<div id="c_load" class="ajax-loader"><img src="'.Yii::app()->baseUrl.'/static/img/ajax-loader.gif" /></div>', 'linkOptions'=>array('id'=>$language->code, 'class'=>'langLink'));
        }        

        if(!is_null(Yii::app()->request->getQuery('ajax')))
		{
			$this->renderPartial('_grid',array(
                'dataProvider'=>$dataProvider,
                'search'=>$search,
			));
		}
		elseif(!is_null(Yii::app()->request->getQuery('ajaxTabReload')))
        {
            $this->renderPartial('_tabs',array(
                'tabs'=>$tabs,
            ));            
            
        }
        else 
		{
			$this->render('index',array(
                'tabs'=>$tabs,
			));
		}
	}

    public function actionCreate()
    {
        $model=new Message();
        $model->populateData();
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='update-translation-grid') {
            $this->performAjaxValidation($model);
        }        
        
        if($model===null)
            throw new CHttpException(404);
            
        if(!is_null(Yii::app()->request->getPost('Message')))
        {
            $model->attributes=Yii::app()->request->getPost('Message');

            if($model->save())
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Перевод добавлен!'));
                $this->redirect(array('index', 'languageTab'=>$model->language));
            }
         }

        $this->render('create',array(
            'model'=>$model, 
        ));
    }

	public function actionUpdate()
	{
        if (!is_null(Yii::app()->request->getQuery('id')))
            $id = Yii::app()->request->getQuery('id');        
            
        if (!is_null(Yii::app()->request->getQuery('language')))
            $language = Yii::app()->request->getQuery('language');              
        
        $model=Message::model()->find(array(
            'condition'=>'id=:id AND language=:language',
            'params'=>array(':id'=>$id, ':language'=>$language),
        ));
        
        $model->populateData();  
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='update-translation-grid') {
            $this->performAjaxValidation($model);
        }        
        
		if($model===null)
			throw new CHttpException(404);
            
		if(!is_null(Yii::app()->request->getPost('Message')))
		{
			$model->attributes=Yii::app()->request->getPost('Message');

			if($model->save())
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Перевод обновлен!'));
                $this->redirect(array('index', 'languageTab'=>$model->language));
            }
 		}

		$this->render('update',array(
            'model'=>$model, 
        ));
	}
    
}