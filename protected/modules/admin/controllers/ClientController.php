<?php
class ClientController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + LoadSizeList',
        );
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
        
        $model=new User;
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
            //echo Helper::myPrint_r($validateModels);
            //Yii::app()->end();
            $this->performMultipleModelAjaxValidation($validateModels);
        }
            
		$clientHasSize=Yii::app()->request->getPost('ClientHasSize');
        if(!is_null(Yii::app()->request->getPost('User')) && !is_null($clientHasSize))
		{
			$model->attributes=Yii::app()->request->getPost('User');
            $model->is_client = 1;
            
            $modelSave=$model->save();
            //save client role for user
            Yii::app()->authManager->assign('client', $model->id);
            $clientSizeSave=true;
            foreach($listOfNewClientSizeModels as $key=>$item)
            {
                if($item['model']->value != $clientHasSize[$key]['value']) {
                    $item['model']->client_id = $model->id;
                    $item['model']->value = $clientHasSize[$key]['value'];
                    $clientSizeSave=$item['model']->save(false) && $clientSizeSave;
                }
            }
            
			if($modelSave && $clientSizeSave) 
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Новый клиент добавлен!'));
                $this->redirect(array('index'));                    
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
                $this->redirect(array('index'));
            }
 		}

		$this->render('update',array(
            'model'=>$model, 
            'uid'=>$model->id,
            'listOfClientSizeModelsForUpdate'=>$listOfClientSizeModelsForUpdate,
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
    
    public function actionLoadSizeList()
    {
        $client_id=Yii::app()->request->getPost('client_id');
        
        $models=ClientHasSize::model()->visible()->active()->findAll(array(
            'condition'=>'client_id=:client_id', 'params'=>array(':client_id'=>$client_id)));
        
        $data=(!empty($client_id) && count($models)==0) ? array('empty'=>1) : array();
        
        foreach($models as $model)
        {
            $info=$model->size->translations[Yii::app()->language]->title . " ({$model->value})";
            $info= str_replace(" ","&#32;",$info);
            $short_title=$model->size->translations[Yii::app()->language]->short_title;
            $short_title=str_replace(array('(', ')'),array('{', '}'),$short_title);
            $vst=$vk=$vzu=$dts=$dr=$vpl=$vlok=$vprch=$drvnch=false;
            if($model->size_id==7) {
                $vst=$this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title'=>Yii::t('imemSize', '{Вшт}'),'info'=>str_replace(" ","&#32;",Yii::t('imemSize', 'Высота шейной точки (Вшт- '.$model->vst.')'))), true, false);
                $vk=$this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title'=>Yii::t('imemSize', '{Вк}'),'info'=>str_replace(" ","&#32;",Yii::t('imemSize', 'Высота колена (Вк- '.$model->vk.')'))), true, false);
                $vzu=$this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title'=>Yii::t('imemSize', '{ВЗУ}'),'info'=>str_replace(" ","&#32;",Yii::t('imemSize', 'Высота заднего угла подмышечной впадины (ВЗУ- '.$model->vzu.')'))), true, false);                                        
                $dts=$this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title'=>Yii::t('imemSize', '{ДТС}'),'info'=>str_replace(" ","&#32;",Yii::t('imemSize', 'Длина спинки до талии (ДТС- '.$model->dts.')'))), true, false);                                                            
                $dr=$this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title'=>Yii::t('imemSize', '{Дрз}'),'info'=>str_replace(" ","&#32;",Yii::t('imemSize', 'Длина рукава (Дрз- '.$model->dr.')'))), true, false);
                $vpl=$this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title'=>Yii::t('imemSize', '{Впл}'),'info'=>str_replace(" ","&#32;",Yii::t('imemSize', 'Высота плечевой точки (Впл- '.$model->vpl.')'))), true, false);
                $vlok=$this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title'=>Yii::t('imemSize', '{Влок}'),'info'=>str_replace(" ","&#32;",Yii::t('imemSize', 'Высота локтя (Влок- '.$model->vlok.')'))), true, false);
                $vprch=$this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title'=>Yii::t('imemSize', '{ВпрЧ}'),'info'=>str_replace(" ","&#32;",Yii::t('imemSize', 'Высота проймы человека (ВпрЧ- '.$model->vprch.')'))), true, false);
                $drvnch=$this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title'=>Yii::t('imemSize', '{ДРвнЧ}'),'info'=>str_replace(" ","&#32;",Yii::t('imemSize', 'Длина руки человека внутренняя (ДРвнЧ- '.$model->drvnch.')'))), true, false);


            }                    
            $data[]=array(
                'abr'=>str_replace(array('(', ')'),array('', ''),$model->size->translations[Yii::app()->language]->short_title),
                'value'=>$model->value,
                'vstvalue'=>$model->vst,
                'vkvalue'=>$model->vk,
                'vzuvalue'=>$model->vzu,
                'dtsvalue'=>$model->dts,
                'drvalue'=>$model->dr,
                'vplvalue'=>$model->vpl,
                'vlokvalue'=>$model->vlok,
                'vprchvalue'=>$model->vprch,
                'drvnchvalue'=>$model->drvnch,
                'vst'=>($vst) ? $vst : null,
                'vk'=>($vk) ? $vk : null,
                'vzu'=>($vzu) ? $vzu : null,                
                'dts'=>($dts) ? $dts : null,                                
                'dr'=>($dr) ? $dr : null,
                'vpl'=>($vpl) ? $vpl : null,
                'vlok'=>($vpl) ? $vlok : null,
                'vprch'=>($vpl) ? $vprch : null,
                'drvnch'=>($vpl) ? $drvnch : null,

                'link'=>$this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title'=>$short_title,'info'=>$info), true, false),
            );    
        }

        //remove elements with value==null
        $clientPropToJs=array();
        if(isset($data) && count($models)!=0) {
            foreach($data as $key=>$value)
            {
                if($data[$key]['value']==null) {
                    unset($data[$key]);
                }
                else
                {
                    $clientPropToJs['{'.$data[$key]['abr'].'}']=$data[$key]['value'];
                
                    if($data[$key]['vst'] != null) 
                        $clientPropToJs['{Вшт}']=$data[$key]['vstvalue'];

                    if($data[$key]['vk'] != null) 
                        $clientPropToJs['{Вк}']=$data[$key]['vkvalue'];
                        
                    if($data[$key]['vzu'] != null) 
                        $clientPropToJs['{ВЗУ}']=$data[$key]['vzuvalue'];
                        
                    if($data[$key]['dts'] != null) 
                        $clientPropToJs['{ДТС}']=$data[$key]['dtsvalue'];

                    if($data[$key]['dr'] != null) 
                        $clientPropToJs['{Дрз}']=$data[$key]['drvalue'];

                    if($data[$key]['vpl'] != null)
                        $clientPropToJs['{Впл}']=$data[$key]['vplvalue'];

                    if($data[$key]['vlok'] != null)
                        $clientPropToJs['{Влок}']=$data[$key]['vlokvalue'];

                    if($data[$key]['vprch'] != null)
                        $clientPropToJs['{ВпрЧ}']=$data[$key]['vprchvalue'];

                    if($data[$key]['drvnch'] != null)
                        $clientPropToJs['{ДРвнЧ}']=$data[$key]['drvnchvalue'];
                }
            }
        }
        
        $res=array(
            'html'=>$this->renderPartial('/formula/_clientProperty', array('data'=>$data), true, false),
            'clientPropToJs'=>$clientPropToJs,
        );                
            
        echo json_encode($res); 
        Yii::app()->end();
    
    }    
}