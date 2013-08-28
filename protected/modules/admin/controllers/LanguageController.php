<?php
class LanguageController extends Controller
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
                'modelClass'=>'Language',
                'message_block'=>Yii::t('infoMessages', 'Язык включен!'),
                'errorMessage_block'=>Yii::t('infoMessages', 'Произошла ошибка при включении языка!'),
                'message_unBlock'=>Yii::t('infoMessages', 'Язык выключен!'),
                'errorMessage_unBlock'=>Yii::t('infoMessages', 'Произошла ошибка при выключении языка!'),
            ),
            'markAsDeleted' =>array(
                'class'=>'application.modules.admin.components.actions.MarkAsDeletedAction',
                'modelClass'=>'Language',
                'message_mark'=>Yii::t('infoMessages', 'Язык удален!'),
                'errorMessage_mark'=>Yii::t('infoMessages', 'Произошла ошибка при удалении языка!'),
            )            
        );
    }     
    
	public function actionIndex()
	{
		$search=new Language('search');
		$search->unsetAttributes();

        if(!is_null(Yii::app()->request->getQuery('Language')))
            $search->attributes=Yii::app()->request->getQuery('Language');

		$criteria=new CDbCriteria;
		$criteria->compare('t.title',$search->title,true);
        $criteria->compare('t.is_blocked',array('0'=>0, '1'=>1));

		$dataProvider=new ActiveDataProvider('Language',array(
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
        $model=new Language;
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='create-language-form')
            $this->performAjaxValidation($model);

		if(!is_null(Yii::app()->request->getPost('Language')))
		{
            $model->attributes=Yii::app()->request->getPost('Language');

			if($model->save()) 
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Новый язык добавлен!'));
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
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='update-language-form') {
            $this->performAjaxValidation($model);
        }        
        
		if($model===null)
			throw new CHttpException(404);
            
		if(!is_null(Yii::app()->request->getPost('Language')))
		{
			$model->attributes=Yii::app()->request->getPost('Language');

			if($model->save())
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Данные языка обновлены!'));
                $this->redirect(array('index'));
            }
 		}

		$this->render('update',array(
            'model'=>$model, 
            'uid'=>$model->id
        ));
	}
    
}