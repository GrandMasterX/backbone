<?php
class PartnerController extends Controller
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
                'modelClass'=>'User',
                'message_block'=>Yii::t('infoMessages', 'Партнер разблокирован!'),
                'errorMessage_block'=>Yii::t('infoMessages', 'Произошла ошибка при разблокировании партнера!'),
                'message_unBlock'=>Yii::t('infoMessages', 'Партнер заблокирован!'),
                'errorMessage_unBlock'=>Yii::t('infoMessages', 'Произошла ошибка при блокировании партнера!'),                
            ),
            'markAsDeleted' =>array(
                'class'=>'application.modules.admin.components.actions.MarkAsDeletedAction',
                'modelClass'=>'User',
                'message_mark'=>Yii::t('infoMessages', 'Партнер удален!'),
                'errorMessage_mark'=>Yii::t('infoMessages', 'Произошла ошибка при удалении партнера!'),
            )            
        );
    }
  
	public function actionIndex()
	{
		
        $search=new User('search');
		$search->unsetAttributes();

        if(!is_null(Yii::app()->request->getQuery('User')))
            $search->attributes=Yii::app()->request->getQuery('User');

		$criteria=new CDbCriteria;
		$criteria->compare('t.name',$search->name,true);
		$criteria->compare('t.email',$search->email,true);
        $criteria->compare('t.is_blocked',array('0'=>0, '1'=>1));
        $criteria->compare('t.is_partner',array('1'=>1));

		$dataProvider=new ActiveDataProvider('User',array(
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
        $model=new User;
        $model->setScenario('partner');
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='create-partner-form')
            $this->performAjaxValidation($model);

		if(!is_null(Yii::app()->request->getPost('User')))
		{
			$model->attributes=Yii::app()->request->getPost('User');
            $model->is_partner = 1;

			if($model->save()) 
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Новый партнер добавлен!'));
                $this->redirect(array('index'));                    
            }
		}

		$this->render('create',array(
            'model'=>$model
        ));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel('User');
        $model->setScenario('partner');
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='update-partner-form') {
            $this->performAjaxValidation($model);
        }        
        
		if($model===null)
			throw new CHttpException(404);
            
		if(!is_null(Yii::app()->request->getPost('User')))
		{
			$model->attributes=Yii::app()->request->getPost('User');

			if($model->save())
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Данные партнера обновлены!'));
                $this->redirect(array('index'));
            }
 		}

		$this->render('update',array(
            'model'=>$model, 
            'uid'=>$model->id
        ));
	}

    /**
    * Generates random password combinations
    * @return random password combinations 
    */
    public function actionGeneratePassword()
    {
        if(!Yii::app()->request->isPostRequest)
            throw new CHttpException(400);

        if(Yii::app()->request->isAjaxRequest)    
            echo Helper::randomPassword();
    }
    
    /**
    * Changes password for user via ajax.
    * Uses changePassword scenario
    */
    public function actionChangePassword()
    {
        if(!Yii::app()->request->isPostRequest)
            throw new CHttpException(400);
        
        if(Yii::app()->request->isAjaxRequest){  
            $data=array();
            $model=User::model()->findByPk(array('id'=>':id', ':id'=>Yii::app()->user->id));
            $model->scenario='changePassword';
            $model->password = null;

            if(!is_null(Yii::app()->request->getPost('User')))
            { 
                $model->attributes=Yii::app()->request->getPost('User');

                if($model->validate() && $model->checkPass())
                {
                    if ($model->save(true, array('password'))){
                        $data['message'] = Yii::t('infoMessages', 'Пароль успешно изменен!');   
                        $html = $this->renderPartial('/layouts/messages/_message_success', $data, true, false);
                        
                        echo CJSON::encode(array(
                            'status'=>'success', 
                            'html'=>$html
                        ));
                        
                        Yii::app()->end();
                    }
                }
            }

            $data['model'] = $model;
            $html = $this->renderPartial('change_pass_form', $data, true, false);
            
            echo CJSON::encode(array(
                'status'=>'render', 
                'html'=>$html
            ));
            
            Yii::app()->end(); 
        }
    }    
    
    /**
    * Sends email with a link for setting password
    */
    public function actionEmailPassword()
    {
        if(!Yii::app()->request->isPostRequest)
            throw new CHttpException(400);

        $model = $this->loadModel('User');
        $model->hash = Helper::createHash();
        $model->save(true, array('hash'));
        
        if(Yii::app()->request->isAjaxRequest){    
            $data['message'] = Yii::t('infoMessages', 'Email для создания пароля успешно отправлен!');
            $data['errorMessage'] = Yii::t('infoMessages', 'Возникла ошибка при отправке Email для создания пароля!');

            if (User::emailPassword($model))
                $this->renderPartial('/layouts/messages/_message_success', $data, false, true);
            else
                $this->renderPartial('/layouts/messages/_message_error', $data, false, true);
        }
    }

    public function actionImportItems()
    {
        //if(file_exists(Yii::app()->runtimePath.'/import')
            //|| file_exists(Yii::app()->runtimePath.'/imageImport'))
            //throw new CHttpException(400);
        $id=Yii::app()->request->getQuery('id');
        $res=shell_exec(Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR.'yiic itemsImport 4 >/dev/null &');
        touch(Yii::app()->runtimePath.'/import');

        //$this->redirect(array('index'));
        if($res)
        {
            echo $res;
            Yii::app()->end();            
        }

    }
    //Todo: move to console application
    public function actionImportImagesForItems()
    {
        $models= ItemImageImport::model()->findAll();

        foreach($models as $model)
        {
            $imageModel=new ItemImage();
            $imageModel->item_id=$model->item_id;
            $imageModel->main=$model->main;
            $imageModel->name=basename($model->path);
            $imageModel->ext=(string)substr($model->path,strrpos($model->path,'.')+1);
            
            Helper::createDir(Item::GALLERY_IMAGES_DIR."/{$model->item_id}"); 
            $imageModel->save(false);
            
            $image = file_get_contents($model->path);
            if(file_put_contents(Item::GALLERY_IMAGES_DIR."/{$model->item_id}/{$imageModel->name}", $image))
            
            $model->delete();
        }        
    }             
    
}