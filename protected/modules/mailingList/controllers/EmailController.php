<?php
class EmailController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + LoadSizeList, mailingListUsersRemove, SendEmailViaAjax',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'roles' => array('manage_email_sending'),
            ),
            array('allow',
                //'roles' => array('client'),
                'actions'=>array('unsubscribe', 'subscribe'),
                'users'=>array('@'),
            ),
            array('deny'),
        );
    }        
    
    /**
    * Actions used for admin module
    * block - block/unblock MailingList items
    * markAsDeleted sets MailingList item is_blocked db field value to '2' meaning
    * that the MailingList item is deleted but actually it remains in the database
    */
    function actions()
    {
        return array(
            'markAsDeleted' =>array(
                'class'=>'application.modules.mailingList.components.actions.MarkAsDeletedAction',
                'modelClass'=>'MailingList',
                'message_mark'=>Yii::t('infoMessages', 'Рассылка удалена!'),
                'errorMessage_mark'=>Yii::t('infoMessages', 'Произошла ошибка при удалении рассылки!'),
            )            
        );
    }
  
	public function actionIndex()
	{
		$search=new MailingList('search');
		$search->unsetAttributes();

        if(!is_null(Yii::app()->request->getQuery('MailingList')))
            $search->attributes=Yii::app()->request->getQuery('MailingList');

		$criteria=new CDbCriteria;
		$criteria->compare('t.title',$search->title,true);
        $criteria->compare('t.status',$search->status,true);
        $criteria->compare('t.is_blocked',array('0'=>0, '1'=>1));

		$dataProvider=new ActiveDataProvider('MailingList',array(
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
        $model=new MailingList;
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='create-mailingList-form')
            $this->performAjaxValidation($model);
            
        if(!is_null(Yii::app()->request->getPost('MailingList')))
		{
			$model->attributes=Yii::app()->request->getPost('MailingList');
            
			if($model->save()) 
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Новая рассылка добавлена!'));
                if(!is_null(Yii::app()->request->getPost('movoToUsers'))) 
                    $this->redirect(Yii::app()->createUrl('mailingList/email/mailingListUsers',array('id'=>$model->id)));
                else
                    $this->redirect(array('index'));
            }
            else {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Произошла ошибка при добавлении новой рассылки!'));
                $this->redirect(array('index'));  
            }
		}

		$this->render('create',array(
            'model'=>$model,
        ));
	}
    
    public function actionMailingListUsers()
    {
//        $search = new User('search');
//        $search->unsetAttributes();
//        if (!is_null(Yii::app()->request->getQuery('User')))
//            $search->attributes = Yii::app()->request->getQuery('User');

            //SELECT t1.id,t1.email,IFNULL(t2.user_id,0) AS userID FROM user as t1 LEFT JOIN mailing_list_user as t2 ON t1.id=t2.user_id;
            //SELECT t1.id,t1.email,CASE WHEN t2.user_id IS NULL THEN 0 ELSE t2.user_id END AS userID FROM user as t1 LEFT JOIN mailing_list_user as t2 ON t1.id=t2.user_id;            
//            
//        $criteria = new CDbCriteria;
//        $criteria->compare('t.name', $search->name, true);
//        $criteria->compare('t.email', $search->email, true);
//        $criteria->compare('t.is_blocked', array('0' => 0, '1' => 1));
//        $criteria->compare('t.is_backend_user', array('1' => 1));

//        $dataProvider = new ActiveDataProvider('User', array(
            //'criteria' => $criteria,
//            'sort' => array(
//                'defaultOrder' => array('create_time' => true),
//                'sortVar' => 'sort',
//            ),
//            'pagination' => array(
                //'pageVar' => 'page',
                //'sizeVar' => 'size',
                //'pageSize' => Yii::app()->params['defaultPageSize'],
//                'pageSize' => 100,
                //'sizeOptions' => Yii::app()->params['sizeOptions'],
//            ),
//        ));
        
        
///SQL START
        $filtersForm=new FiltersForm;
        if (isset($_GET['FiltersForm']))
            $filtersForm->filters=$_GET['FiltersForm'];        

        $count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM user WHERE is_client=1 AND is_blocked=0')->queryScalar();
        $sql='SELECT t1.id,t1.name,t1.create_time,t1.email,t1.promo_code,last_item_id,IFNULL(t2.user_id,0) AS userID,IFNULL(t3.status,2) AS status, t3.create_time AS stat_date_create, t3.update_time AS stat_date_update
              FROM user as t1 
              LEFT JOIN mailing_list_user AS t2 ON t1.id=t2.user_id AND t2.mailing_list_id=:m_id 
              LEFT JOIN mailing_list_stat AS t3 ON t1.id=t3.client_id AND t3.mailing_list_id=:m_id   
              WHERE is_client=1 AND is_blocked=0 AND mailing=1';
        $command=Yii::app()->db->createCommand($sql);
        $command->bindParam(":m_id",Yii::app()->request->getQuery('id'),PDO::PARAM_STR);
        $data=$command->queryAll();

//        echo CJavaScript::encode(array(
//            'data'=>Helper::myPrint_r($data),
//        ));
//        Yii::app()->end();
        
        $filteredData=$filtersForm->filter($data);
        
        $dataProvider=new CArrayDataProvider($filteredData, array(
            'totalItemCount'=>$count,
            'sort'=>array(
            'defaultOrder'=>array('create_time'=>true),
                'attributes'=>array(
                     'email','name','create_time'
                ),
            ),
            'pagination'=>array(
                'pageSize'=>100,
            ),
        )); 
///SQl END        
        
            
        $ids=Yii::app()->request->getQuery('ids');
        if(!is_null($ids))
        {
            $result=true;
            foreach($ids as $id) {
                $mailing_list_user=new MailingListUser;
                $mailing_list_user->user_id=$id;
                $mailing_list_user->mailing_list_id=Yii::app()->request->getQuery('mlid');
                $result=$mailing_list_user->save() && $result;
            }
            
            if($result) {
                echo CJavaScript::encode(array(
                    'status'=>'success',
                    'ids'=>Yii::app()->request->getQuery('ids'),
                ));
            }
            else 
            {
                echo CJavaScript::encode(array(
                    'status'=>'error',
                    'ids'=>Yii::app()->request->getQuery('ids'),
                ));
            }                

            Yii::app()->end();
        }

        $this->setFlashSuccess(Yii::t('infoMessages', 'Новая рассылка добавлена! Далее необходимо добавить получателей'));
        $this->render('add_user',array(
            'filtersForm' => $filtersForm,
            'users'=>$dataProvider,
            'mlid'=>Yii::app()->request->getQuery('id'),
        ));
    }
    
    public function actionMailingListUsersRemove()
    {
        $ids=Yii::app()->request->getQuery('ids');
        if(!is_null($ids))
        {
            $result=true;
            foreach($ids as $id) {
                $model=MailingListUser::model()->find('user_id=:user_id AND mailing_list_id=:m_id' , array(
                    ':user_id'=>$id,':m_id'=>Yii::app()->request->getQuery('mlid')));
                if ($model === null)
                    continue;
                
                $result=$model->delete() && $result;
                //$res=MailingListUser::model()->findAll('user_id=:id AND mailing_list_id=:m_id' , array(
                    //':id'=>$id,':m_id'=>Yii::app()->request->getQuery('mlid')));
            }
            
            if($result)
                $status='success';
            else
                $status='error';

        }
            
            $status='No ids given!';
            echo CJavaScript::encode(array('status'=>$status));
            Yii::app()->end();                
    }
    
    public function actionSendEmailViaAjax()
    {
        //SELECT t3.item_id FROM log AS t3 WHERE client_id=7 ORDER BY create_time DESC LIMIT 1;
        
//        $sql='SELECT t1.id,t1.name,t1.create_time,t1.email,t3.item_id 
//              FROM user as t1 
//              JOIN mailing_list_user as t2 ON t1.id=t2.user_id AND t2.mailing_list_id=:m_id 
//              JOIN log as t3 ON t1.id=t3.client_id AND  
//              WHERE is_client=1 AND is_blocked=0';


//        $sql='SELECT t1.id,t1.name,t1.create_time,t1.email,
//              (SELECT t3.item_id AS last FROM log AS t3 WHERE client_id=t1.id ORDER BY create_time DESC LIMIT 1) AS last_item_id 
//              FROM user AS t1 
//              JOIN mailing_list_user AS t2 ON t1.id=t2.user_id AND t2.mailing_list_id=:m_id 
//              WHERE is_client=1 AND is_blocked=0;';
              
        //(SELECT t3.item_id AS last FROM log AS t3 WHERE client_id=t1.id ORDER BY create_time DESC LIMIT 1) AS last_item_id
        //!!! UPDATE user SET last_item_id=(SELECT item_id FROM log WHERE client_id=user.id AND item_id IS NOT NULL ORDER BY create_time DESC LIMIT 1);

        set_time_limit(0);
        $mailingList=$this->loadModel('MailingList');
        if($mailingList) {
            
            $sql='SELECT t1.id,t1.name,t1.create_time,t1.email,t1.promo_code,t1.email_hash, IFNULL(t1.last_item_id,0) AS last_item_id';
            $sql.=' FROM user AS t1';
            $sql.=' JOIN mailing_list_user AS t2 ON t1.id=t2.user_id AND t2.mailing_list_id=:m_id';

            if(!is_null(Yii::app()->request->getQuery('notSentOnly')))
                $sql.=' JOIN mailing_list_stat AS t3 ON t1.id=t3.client_id AND t3.mailing_list_id=:m_id AND t3.status=0';

            $sql.=' WHERE is_client=1 AND is_blocked=0 AND mailing=1;';

            $command=Yii::app()->db->createCommand($sql);
            $command->bindParam(":m_id",Yii::app()->request->getQuery('id'),PDO::PARAM_STR);
            $data=$command->queryAll();

            $status=false;
            if($data) {
                foreach($data as $user) {
                    //generate email hash if email_hash is null
                    if(is_null($user['email_hash'])) 
                    {
                        $res=false;
                        $model=User::model()->findByPk($user['id']);
                        $model->email_hash=Helper::createHash();
                        $res=$model->save(false,'email_hash');
                        if($res)
                            $user['email_hash']=$model->email_hash;
                        else
                            Yii::log(Yii::t('errorLog','Не удалось создать email_hash для пользователя: ') . $user['id']);
                    }
                    
                    
                    ///EVALUATE START
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
                                 t3.name as image,
                                 t3.thumbnail as th')
                                ->from('item as t1')
                                ->join('item_translation AS t2', 't2.id=t1.id AND t2.language_id=:lang', array(':lang' => $lang))
                                ->join('item_image AS t3', 't3.item_id=t1.id AND t3.main=1')
                                ->where('t1.parent_id=:parent_id AND t1.is_blocked=0 AND t1.ready=1 AND unavailable !=1', array(':parent_id' => 4))
                                ->order('t1.create_time DESC')
                                //->limit(100)
                                //->offset(Yii::app()->request->getPost('offset'))
                                ->queryAll();

                        $evaluated = array();
                        $i = 1;
                        foreach ($item_result as $result) {
                            /**
                             * TODO: teh Evaluate model should be initiated only once.
                             * itemType properties and clientProperties should be loaded once since they are equal for all items
                             * withing the current itemType and user
                             */
                            //3 for template 1
                            //6 for template 2
                            if ($i <= 6) {
                                $ev = new Evaluate($result['id'], $result['type_id'], $user['id']);
                                $evData = $ev->evaluateSize();
                                if ($evData['status']['result'] == 1) {
                                    $evaluated[$i] = array(
                                        'id' => $result['id'],
                                        'code' => $result['code'],
                                        'sizeF' => $evData['status']['fitF'],
                                        'sizeFitting' => substr($evData['status']['sizeFitting'], 0, 2),
                                        'image' => $result['image'],
                                        'img_url' => Yii::app()->baseUrl
                                        . DIRECTORY_SEPARATOR
                                        . Item::GALLERY_IMAGES_DIR
                                        . DIRECTORY_SEPARATOR
                                        . $result['id']
                                        . DIRECTORY_SEPARATOR
                                        . $result['th'],
                                    );
                                    $i++;
                                }
                            }
                        }
                    ///EVALUATE END

                    //load item images
                    $item=Item::model()->findByPk($user['last_item_id']);
                    $result=false;
                    if($item !== null) {
                        $message = new YiiMailMessage;
                        $message->subject=$mailingList->subject; //'❤ Ваше платье от MustHave ';
                        $message->view = $mailingList->template->view_file;
                        $message->setBody(array('user'=>$user, 'item'=>$item,'evaluated'=>$evaluated), 'text/html','utf-8');
                         
                        $message->addTo($user['email']);
                        $message->from = Yii::app()->params['adminEmail'];
                        $result=Yii::app()->mail->send($message);
                    }

                    $stat=MailingListStat::model()
                            ->find('mailing_list_id=:ml_id AND client_id=:cl_id',array(':ml_id'=>$mailingList->id,':cl_id'=>$user['id']));

                    if($stat === null)
                        $stat=new MailingListStat;

                    $stat->mailing_list_id=$mailingList->id;
                    $stat->client_id=$user['id'];
                    $stat->status=($result) ? 1 : 0;
                    if(!$stat->save(false))
                        Yii::log(Yii::t('errorLog','Не удалось сохранить статистику по email рассылке для пльзователя/рассылки: ') . $mailingList->id.'/'.$user['id']);

                    $status=($result) ? 'success' : 'error';
                }
            }
            
            $mailingList->last_sent_time=Helper::getCurrentTime();
            $mailingList->save(false,'last_sent_time');
            MailingList::model()->updateCounters(array('sent_count' => 1), 'id = ?', array($mailingList->id));
            
        }

        set_time_limit(30);
        //echo CJavaScript::encode(array('status'=>$status));
        Yii::app()->end();
                
    }            

	public function actionUpdate()
	{
        $model=$this->loadModel('MailingList');
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='update-mailingList-form') {
            $this->performAjaxValidation($model);
        }        
        
		if($model===null)
			throw new CHttpException(404);
        
		if(!is_null(Yii::app()->request->getPost('MailingList')))
		{
			$model->attributes=Yii::app()->request->getPost('MailingList');

            if($model->save()) 
            {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Данные рассылки обновлены!'));
                if(!is_null(Yii::app()->request->getPost('movoToUsers'))) 
                    $this->redirect(Yii::app()->createUrl('mailingList/email/mailingListUsers',array('id'=>$model->id)));
                else
                    $this->redirect(array('index'));                
            }
            else {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Произошла ошибка при обновлении данных рассылки!'));
                $this->redirect(array('index'));  
            }
 		}

		$this->render('update',array(
            'model'=>$model, 
        ));
	}

    public function actionUnsubscribe() 
    {
        //authenticate user without asking login and pass by hash
        $this->authenticateOnLoginByHash();        
        $this->logFromEmailActivity(17);

        $result=false;
        $this->layout = '//layouts/main';
        $id=Yii::app()->request->getQuery('id');
        $ucode=Yii::app()->request->getQuery('ucode');
        Yii::app()->errorHandler->errorAction='site/error';

        if(empty($id) || is_null($id))
            throw new CHttpException(500,Yii::t('errors','Пользователь с таким id не найден'));

        if(empty($ucode) || is_null($ucode))
            throw new CHttpException(500,Yii::t('errors','Неверный запрос'));

        if(!empty($id) && !empty($ucode))
        {
            $user=User::model()->findByPk(array('id'=>':id', ':id'=>$id));
            if($user === NULL)
                throw new CHttpException(500,Yii::t('errors','Пользователь с таким id не найден'));

            if($user !== null && $user->email_hash == $ucode)
            {
                $user->mailing=0;
                $result=$user->save(false,'mailing');
                
                if(!$result)
                    Yii::log(Yii::t('errorLog','Не удалось отписаться от рассылки пользователю: ') . $user->id);
            }
        }
        $this->render('unsubscribe',array(
            'result'=>$result,
            'id'=>$user->id,
            'ucode'=>$ucode,
            )
        );
    }
    
    public function actionSubscribe() 
    {
        //authenticate user without asking login and pass by hash
        $this->authenticateOnLoginByHash();        
        $this->logFromEmailActivity(18);

        $result=false;
        $this->layout = '//layouts/main';
        $id=Yii::app()->request->getQuery('id');
        $ucode=Yii::app()->request->getQuery('ucode');
        Yii::app()->errorHandler->errorAction='site/error';

        if(empty($id) || is_null($id))
            throw new CHttpException(500,Yii::t('errors','Пользователь с таким id не найден'));

        if(empty($ucode) || is_null($ucode))
            throw new CHttpException(500,Yii::t('errors','Неверный запрос'));

        if(!empty($id) && !empty($ucode))
        {
            $user=User::model()->findByPk(array('id'=>':id', ':id'=>$id));
            if($user === NULL)
                throw new CHttpException(500,Yii::t('errors','Пользователь с таким id не найден'));

            if($user !== null && $user->email_hash == $ucode)
            {
                $result=false;
                $user->mailing=1;
                $result=$user->save(false,'mailing');
                
                if(!$result)
                    Yii::log(Yii::t('errorLog','Не удалось подписать пользователя на рассылку: ') . $user->id);
            }
        }
        $this->render('subscribe',array(
            'result'=>$result,
            'id'=>$user->id,
            'ucode'=>$ucode,
            )
        );
    }    
}