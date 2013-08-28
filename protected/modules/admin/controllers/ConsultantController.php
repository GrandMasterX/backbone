<?php
class ConsultantController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
            //'ajaxOnly + SuitableItems',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'roles' => array('consultant'),
            ),
            array('deny'),
        );
    }

    public function init()
    {
        $this->layout='/layouts/consult';
        parent::init();
    }
    
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
                'message_block'=>Yii::t('infoMessages', 'Клиент разблокирован!'),
                'errorMessage_block'=>Yii::t('infoMessages', 'Произошла ошибка при разблокировании клиента!'),
                'message_unBlock'=>Yii::t('infoMessages', 'Клиент заблокирован!'),
                'errorMessage_unBlock'=>Yii::t('infoMessages', 'Произошла ошибка при блокировании клиента!'),                
            ),
            'markAsDeleted' =>array(
                'class'=>'application.modules.admin.components.actions.MarkAsDeletedAction',
                'modelClass'=>'User',
                'message_mark'=>Yii::t('infoMessages', 'Клиент удален!'),
                'errorMessage_mark'=>Yii::t('infoMessages', 'Произошла ошибка при удалении клиента!'),
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
        $criteria->compare('t.created_by_id',Yii::app()->user->id);
        $criteria->compare('t.is_blocked',array('0'=>0, '1'=>1));
        $criteria->compare('t.is_client',array('1'=>1));

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
        $modelSave = false;
        $clientSizeSave = false;
        
        $model=new User('consultant');
        $listOfNewClientSizeModels = $model->getListOfClientSizeModels();
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='create-client-form')
        {
            foreach($listOfNewClientSizeModels as $key=>$item)
            {   
                 if(isset($_POST['ClientHasSize'][$key]))
                 {
                    $item['model']->attributes=$_POST['ClientHasSize'][$key];
                    $validateModels[$key] = $item['model'];
                 }
                 $validateModels[0] = $model;
            }
            $this->performMultipleModelAjaxValidation($validateModels);
        }
            
		$clientHasSize=Yii::app()->request->getPost('ClientHasSize');
        if(!is_null(Yii::app()->request->getPost('User')) && !is_null($clientHasSize))
		{
			$model->attributes=Yii::app()->request->getPost('User');
            $model->is_client = 1;
            //TODO: the partner shop should be selected from partner list in consultant user update mode
            $model->shop_id = 4;
            $model->unhashed_password=$model->password;
            $model->hash=Helper::createHash();
            
            $modelSave=$model->save();
            //save client role for user
            Yii::app()->authManager->assign('client', $model->id);
            $model->emailGreetingsAndPassword($model);
            $clientSizeSave=true;
            foreach($listOfNewClientSizeModels as $key=>$item)
            {
                //if($item['model']->value != $clientHasSize[$key]['value']) {
                    $item['model']->client_id = $model->id;
                    $item['model']->value = $clientHasSize[$key]['value'];
                    $clientSizeSave=$item['model']->save(false) && $clientSizeSave;
                //}
            }
            
			if($modelSave && $clientSizeSave) 
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Новый клиент добавлен!'));
                $this->redirect($this->createUrl('index',array('lastuserid'=>$model->id)));
            }
		}

		$this->render('create',array(
            'model'=>$model,
            'listOfNewClientSizeModels'=>$listOfNewClientSizeModels,
        ));
	}

	public function actionUpdate()
	{
        //todo: refactor tabualar update
        $modelSave = false;

        $model=$this->loadModel('User');
        $model->scenario='clientUpdateByAdmin';

        $language = Yii::app()->language;
        $user_id = $model->id;
        $query = 'SELECT t1.id, t1.size_id, t1.value, t2.weight, t3.title, t3.video_url, t3.video_text
                  FROM client_size as t1
                  JOIN clientsize AS t2 ON t1.size_id=t2.id AND t2.is_blocked=0
                  JOIN clientsize_translation AS t3 ON t2.id=t3.id AND t3.language_id=:lang
                  WHERE client_id=:client_id AND t1.is_blocked=0
                  AND t1.is_locked = 0';

        $command = Yii::app()->db->createCommand($query);
        $command->bindParam(":lang", $language, PDO::PARAM_STR);
        $command->bindParam(":client_id", $user_id, PDO::PARAM_STR);
        $result = $command->queryAll();


        //$listOfClientSizeModelsForUpdate = $model->getListOfClientSizeModels(true);
        $listOfClientSizeModelsForUpdate = ItemType::getListOfSizeModelsByItemTypeId($result);

        foreach($listOfClientSizeModelsForUpdate as $key=>$item)
        {
            $validateModels[$key]=$item['model'];
            array_push($validateModels, $model);
        }
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='update-client-form') {
            //$this->performAjaxValidation($model);
            $this->performMultipleModelAjaxValidation($validateModels);
        }        
        
		if($model===null)
			throw new CHttpException(404);
        
        $clientHasSize=Yii::app()->request->getPost('ClientHasSize');        
		if(!is_null(Yii::app()->request->getPost('User')) && !is_null($clientHasSize))
		{
			$model->attributes=Yii::app()->request->getPost('User');

            $modelSave=$model->save();
            $clientSizeSave=true;
            foreach($listOfClientSizeModelsForUpdate as $key=>$item)
            {
                if($item['model']->value != $clientHasSize[$key]['value'])
                {
                    //record with old value remains for the history. For this purpose we change by modifying is_locked value from 0 to 1
                    Yii::app()->db->createCommand()->update('client_size', array(
                        'is_locked'=>'1',
                    ), 'id=:id', array(':id'=>$key));

                    $item['model']->client_id = $model->id;
                    $item['model']->value = $clientHasSize[$key]['value'];
                    $clientSizeSave=$item['model']->save(false) && $clientSizeSave;
                }
//
//                $item['model']->client_id = $model->id;
//                $item['model']->attributes=$clientHasSize[$key];
//
//                if (empty($clientHasSize[$key]['value']) && !$item['model']->isNewRecord)
//                    $item['model']->delete();
//
//                if (!empty($clientHasSize[$key]['value']))
//                    $clientSizeSave=$item['model']->save();
                 
            }

            if($modelSave && $clientSizeSave)
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Данные клиента обновлены!'));
                $this->redirect($this->createUrl('index',array('lastuserid'=>$model->id)));
            }
 		}

		$this->render('update',array(
            'model'=>$model, 
            'uid'=>$model->id,
            'listOfClientSizeModelsForUpdate'=>$listOfClientSizeModelsForUpdate,
        ));
	}

    public function actionSuitableItems() {
        $this->layout='/layouts/consultant';
        if (is_null(Yii::app()->request->getQuery('parent_id')))
            throw new CHttpException(500, 'parent_id required!');

        if (is_null(Yii::app()->request->getQuery('lastuserid')))
            throw new CHttpException(500, 'last created/edited user id required!');

        $dbCommand = Yii::app()->db->createCommand(
            "SELECT id,COUNT(*) as item FROM `item` WHERE parent_id=:parent_id AND ready=1 AND unavailable !=1 AND is_blocked=0 GROUP BY `id`"
        );

        $dbCommand->bindParam(":parent_id", Yii::app()->request->getQuery('parent_id'), PDO::PARAM_STR);
        $item_result = $dbCommand->queryAll();

        $this->render('suitableItems', array('itemCount' => count($item_result),'lastuserid'=>Yii::app()->request->getQuery('lastuserid')));
    }

    public function actionSuitableItemsViaAjax() {
        $this->layout='/layouts/consultant';
        if (is_null(Yii::app()->request->getPost('parent_id')))
            throw new CHttpException(500, 'parent_id required!');

        if (is_null(Yii::app()->request->getPost('lastuserid')))
            throw new CHttpException(500, 'last created/edited user id required!');

        $lang = Yii::app()->language;
        $item_result = Yii::app()->db->createCommand()
            ->select(
                't1.id,
                 t1.colour,
                 t1.type_id,
                 t1.stretch,
                 t1.weight,
                 t1.code,
                 t2.title,
                 t3.thumbnail as image')
            ->from('item as t1')
            ->join('item_translation AS t2', 't2.id=t1.id AND t2.language_id=:lang', array(':lang' => $lang))
            ->join('item_image AS t3', 't3.item_id=t1.id AND t3.main=1')
            ->where('t1.parent_id=:parent_id AND t1.is_blocked=0 AND t1.ready=1 AND unavailable !=1', array(':parent_id' => Yii::app()->request->getPost('parent_id')))
            ->order('t1.create_time DESC')
            ->limit(10)
            ->offset(Yii::app()->request->getPost('offset'))
            ->queryAll();

        $evaluated = array();
        $i = 1;
        foreach ($item_result as $result) {
            /**
             * TODO: the Evaluate model should be initiated only once.
             * itemType properties and clientProperties should be loaded once since they are equal for all items
             * withing the current itemType and user
             */
            if ($i <= 5) {
                $ev = new Evaluate($result['id'], $result['type_id'], Yii::app()->request->getPost('lastuserid'));
                $evData = $ev->evaluateSize();
                if ($evData['status']['result'] == 1) {
                    $evaluated[] = array(
                        'id' => $result['id'],
                        'code' => $result['code'],
                        'sizeF' => $evData['status']['fitF'],
                        'sizeFitting' => $evData['status']['sizeFitting'],
                        'img_url' => Yii::app()->baseUrl
                        . DIRECTORY_SEPARATOR
                        . Item::GALLERY_IMAGES_DIR
                        . DIRECTORY_SEPARATOR
                        . $result['id']
                        . DIRECTORY_SEPARATOR
                        . $result['image'],
                    );
                }
                $i++;
            }
        }

        $result['html'] = $this->renderPartial('_img_fit', array('data' => $evaluated,'lastuserid'=>Yii::app()->request->getPost('lastuserid')), true, false);
        $result['processed'] = count($item_result);
        $result['fitting'] = count($evaluated);
        $lastItemId = end($evaluated);
        $result['lastItemId'] = $lastItemId['id'];
        $result['i'] = $i;

        echo CJavaScript::jsonEncode($result);
        Yii::app()->end();
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
}