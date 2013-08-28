<?php
class ClientSizeController extends Controller
{
    /**
    * Actions used for admin module
    * block - block/unblock user
    * markAsDeleted sets user is_blocked db field value to '2' meaning
    * that the user is deleted but actually it remains in the database
    */
    function actions()
    {
        return array(
            'block' =>array(
                'class'=>'application.modules.admin.components.actions.BlockAction',
                'modelClass'=>'ClientSize',
                'message_block'=>Yii::t('infoMessages', 'Размер включен!'),
                'errorMessage_block'=>Yii::t('infoMessages', 'Произошла ошибка при включении размера!'),
                'message_unBlock'=>Yii::t('infoMessages', 'Размер выключен!'),
                'errorMessage_unBlock'=>Yii::t('infoMessages', 'Произошла ошибка при выключении размера!'),
            ),
            'markAsDeleted' =>array(
                'class'=>'application.modules.admin.components.actions.MarkAsDeletedAction',
                'modelClass'=>'ClientSize',
                'message_mark'=>Yii::t('infoMessages', 'Размер удален!'),
                'errorMessage_mark'=>Yii::t('infoMessages', 'Произошла ошибка при удалении размера!'),
            )            
        );
    }     
    
	public function actionIndex()
	{
		$search=new ClientSize('search');
		$search->unsetAttributes();

        if(!is_null(Yii::app()->request->getQuery('ClientSize')))
            $search->attributes=Yii::app()->request->getQuery('ClientSize');

		$criteria=new CDbCriteria;
		$criteria->compare('t.title',$search->title,true);
        $criteria->compare('t.is_blocked',array('0'=>0, '1'=>1));

		$dataProvider=new ActiveDataProvider('ClientSize',array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>array('create_time'=>true),
				'sortVar'=>'sort',
			),
            'pagination'=>array(
                'pageVar'=>'page',
                'sizeVar'=>'size',
                'pageSize'=>Yii::app()->params['defaultPageSize'],
                'sizeOptions'=>Yii::app()->params['sizeOptions'],
            ),
		));

        if(!is_null(Yii::app()->request->getQuery('ajax')))
		{
			$this->renderPartial('_grid',array(
				'dataProvider'=>$dataProvider,
				'search'=>$search,
			));
		}
		else
		{
			$this->render('index',array(
				'dataProvider'=>$dataProvider,
				'search'=>$search,
			));
		}
	}

	public function actionCreate()
	{
        $model=new ClientSize;
        $model->prepareTranslations();
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='create-clientSize-form')
            $this->performAjaxValidation($model);

        if(!is_null(Yii::app()->request->getPost('ClientSizeTranslation')))
        {
            $model->clientSizeTranslation = Yii::app()->request->getPost('ClientSizeTranslation');            
            
            $model->attributes=Yii::app()->request->getPost('ClientSize');

			if($model->save()) 
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Новый размер добавлен!'));
                $this->redirect(array('index'));                    
            }
		}

		$this->render('create',array(
            'model'=>$model
        ));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();
        $model->prepareTranslations();
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='update-clientSize-form') {
            $this->performAjaxValidation($model);
        }        
        
		if($model===null)
			throw new CHttpException(404);

        if(!is_null(Yii::app()->request->getPost('ClientSize')))
            $model->attributes = Yii::app()->request->getPost('ClientSize');

            
        if(!is_null(Yii::app()->request->getPost('ClientSizeTranslation'))) {
            $model->clientSizeTranslation = Yii::app()->request->getPost('ClientSizeTranslation');   
                		
		    if($model->save())
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Данные размера обновлены!'));
                $this->redirect(array('index'));
            }
        }

		$this->render('update',array(
            'model'=>$model, 
            'uid'=>$model->id
        ));
	}
    
    public function generateTranslationFieldsForTab($model, $form)
    {
        $tabs = array();
        foreach($model->translations as $language_id=>$translation)
        {
            if ($translation->scenario=='translation')
                $tabs[] = array('label'=>$translation->label, 'content'=>$this->renderPartial('_translate', array(
                    'translation'=>$translation, 'form'=>$form, 'language_id'=>$translation->language_id), true, false), 
                    'linkOptions'=>array('id'=>$translation->language_id, 'class'=>'langLink'), 'active'=>true);
            else
                $tabs[] = array('label'=>$translation->label, 'content'=>$this->renderPartial('_translate', array(
                    'translation'=>$translation, 'form'=>$form, 'language_id'=>$translation->language_id), true, false), 
                    'linkOptions'=>array('id'=>$translation->language_id, 'class'=>'langLink'));
        }
        
        return $tabs;         
    }     
}