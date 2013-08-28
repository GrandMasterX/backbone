<?php
class ResFormulaTitleController extends Controller
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
                'modelClass'=>'ResFormulaTitle',
                'message_block'=>Yii::t('infoMessages', 'Наименование оценочной формулы включено!'),
                'errorMessage_block'=>Yii::t('infoMessages', 'Произошла ошибка при включении наименования оценочной формулы!'),
                'message_unBlock'=>Yii::t('infoMessages', 'Наименование оценочной формулы выключено!'),
                'errorMessage_unBlock'=>Yii::t('infoMessages', 'Произошла ошибка при выключении наименования оценочной формулы!'),
            ),
            'markAsDeleted' =>array(
                'class'=>'application.modules.admin.components.actions.MarkAsDeletedAction',
                'modelClass'=>'ResFormulaTitle',
                'message_mark'=>Yii::t('infoMessages', 'Наименование оценочной формулы удалено!'),
                'errorMessage_mark'=>Yii::t('infoMessages', 'Произошла ошибка при удалении наименования оценочной формулы!'),
            )            
        );
    }     
    
	public function actionIndex()
	{
		$search=new ResFormulaTitle('search');
		$search->unsetAttributes();

        if(!is_null(Yii::app()->request->getQuery('ResFormulaTitle')))
            $search->attributes=Yii::app()->request->getQuery('ResFormulaTitle');

		$criteria=new CDbCriteria;
        $criteria->compare('t.is_blocked',array('0'=>0, '1'=>1));

		$dataProvider=new ActiveDataProvider('ResFormulaTitle',array(
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
        $model=new ResFormulaTitle;
        $model->prepareTranslations();
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='create-resFormulaTitle-form')
            $this->performAjaxValidation($model);

        if(!is_null(Yii::app()->request->getPost('ResFormulaTitleTranslation')))
        {
            $model->resFormulaTitleTranslation = Yii::app()->request->getPost('ResFormulaTitleTranslation');            
            
            $model->attributes=Yii::app()->request->getPost('ResFormulaTitle');

			if($model->save()) 
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Новое наименование оценочной формулы добавлено!'));
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
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='update-resFormulaTitle-form') {
            $this->performAjaxValidation($model);
        }        
        
		if($model===null)
			throw new CHttpException(404);
            
        if(!is_null(Yii::app()->request->getPost('ResFormulaTitleTranslation'))) {
            $model->resFormulaTitleTranslation = Yii::app()->request->getPost('ResFormulaTitleTranslation');   
            
            if(!is_null(Yii::app()->request->getPost('ResFormulaTitle')))
                $model->attributes = Yii::app()->request->getPost('ResFormulaTitle');
                		
		    if($model->save())
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Данные наименования оценочной формулы обновлены!'));
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