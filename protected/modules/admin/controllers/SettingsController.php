<?php
class SettingsController extends Controller
{
	private $param;
    
    public function init()
    {
        Yii::app()->session['param'] = false;
        if(!is_null(Yii::app()->request->getQuery('param')))
            Yii::app()->session['param'] = Yii::app()->request->getQuery('param');

        parent::init();
    }    
    
    public function actionIndex()
	{
        $search=new Settings('search');
		$search->unsetAttributes();

        if(!is_null(Yii::app()->request->getQuery('Settings')))
            $search->attributes=Yii::app()->request->getQuery('Settings');

		$criteria=new CDbCriteria;
		$criteria->compare('t.title',$search->title,true);
        
        if(Yii::app()->session['param'])
            $criteria->compare('t.is_param',array('1'=>1));
        else
            $criteria->compare('t.is_param',array('0'=>0));
            

		$dataProvider=new ActiveDataProvider('Settings',array(
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
        $model=new Settings;
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='create-settings-form')
            $this->performAjaxValidation($model);

		if(!is_null(Yii::app()->request->getPost('Settings')))
		{
            $model->attributes=Yii::app()->request->getPost('Settings');

			if($model->save()) 
            {
                $this->setFlashSuccess(((Yii::app()->session['param'])) ? Yii::t('infoMessages', 'Новый параметр добавлен!') : Yii::t('infoMessages', 'Новая настройка добавлена!'));
                (Yii::app()->session['param']) ? $this->redirect(array('index', 'param'=>Yii::app()->session['param'])) : $this->redirect(array('index'));
            }
		}
		$this->render('create',array(
            'model'=>$model,
        ));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='update-settings-form') {
            $this->performAjaxValidation($model);
        }        
        
		if($model===null)
			throw new CHttpException(404);
            
		if(!is_null(Yii::app()->request->getPost('Settings')))
		{
			$model->attributes=Yii::app()->request->getPost('Settings');

			if($model->save())
            {
                $this->setFlashSuccess((Yii::app()->session['param']) ? Yii::t('infoMessages', 'Значение параметра обновлено!') : Yii::t('infoMessages', 'Значение настройки обновлено!'));
                (Yii::app()->session['param']) ? $this->redirect(array('index', 'param'=>Yii::app()->session['param'])) : $this->redirect(array('index'));
            }
 		}

		$this->render('update',array(
            'model'=>$model, 
            'uid'=>$model->id,
        ));
	}
    
}