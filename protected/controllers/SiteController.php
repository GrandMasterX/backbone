<?php

class SiteController extends Controller {

    public function filters() {
        return array(
            'accessControl',
            'ajaxOnly + RestorePassword, LogSteps',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'roles' => array('client','superadmin','admin'),
                'actions' => array('myData'),
            ),
            array('deny',
                'roles' => array('guest'),
                'actions' => array('myData'),
            ),
//            array('deny',
//                'actions' => array('myData'),
//                'users' => array('?'),
//                'expression' => 'is_null(Yii::app()->request->getQuery(\'ucode\'))',
//            ),
            //array('deny'),
        );
    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    public function actionIndex() {
        $this->render('index', array('data' => 'Index page'));
    }

    public function actionService() {
        $this->render('service', array('data' => 'Index page'));
    }

    public function actionHowitworks() {
        $this->render('howitworks', array('data' => 'Index page'));
    }

    public function actionGetSize() {
        $this->render('getSize', array('data' => 'Index page'));
    }

    public function actionAbout() {
        $this->render('about', array('data' => 'about page'));
    }

    public function actionContact() {
        $this->render('contact', array('data' => 'about page'));
    }

    public function actionShopList() {
        $this->render('shopList', array('data' => 'about page'));
    }

    public function actionSuitableItems() {
        $this->layout = '//layouts/main-result';

//DEBUG////////////////////////////////DEBUG
//        $parent_type=Item::getParentTypeId(Yii::app()->request->getQuery('type_id'));
//        $lang=Yii::app()->language;
//        $item_result = Yii::app()->db->createCommand()
//            ->select(
//                't1.id, 
//                 t1.colour, 
//                 t1.type_id, 
//                 t1.stretch, 
//                 t1.weight, 
//                 t1.code, 
//                 t2.title, 
//                 t3.thumbnail as image')
//            ->from('item as t1')
//            ->join('item_translation AS t2','t2.id=t1.id AND t2.language_id=:lang',array(':lang'=>$lang))
//            ->join('item_image AS t3','t3.item_id=t1.id AND t3.main=1')
//            ->where('t1.parent_id=:parent_id AND t1.is_blocked=0 AND t1.ready=1', array(':parent_id'=>$parent_type))
//            ->order('t1.id ASC')
//            ->queryAll();
//        
//        $evaluated=array();
//        foreach($item_result as $result)
//        {
//            /**
//            * itemType properties and clientProperties should be loaded once since they are equal for all items
//            * withing the current itemType and user
//            */
//            $ev=new Evaluate($result['id'],$result['type_id'],Yii::app()->user->id);
//            $evData=$ev->evaluateSize();
//            if($evData['status']['result']==1) {
//                $evaluated[]=array(
//                    'id'=>$result['id'],
//                    'code'=>$result['code'],
//                    'sizeF'=>$evData['status']['fitF'],
//                    'sizeFitting'=>$evData['status']['sizeFitting'],
//                    'img_url'=>Yii::app()->baseUrl 
//                        . DIRECTORY_SEPARATOR
//                        . Item::GALLERY_IMAGES_DIR
//                        . DIRECTORY_SEPARATOR
//                        . $result['id'] 
//                        . DIRECTORY_SEPARATOR
//                        . $result['image'],
//                );
//            }
//        }
        //Helper::myPrint_r($evaluated,true);
//        echo 'finish!';
//        die;
//DEBUG///////////////////////////////DEBUG        

        //authenticate user without asking login and pass by hash
        $this->authenticateOnLoginByHash();
        //log from email activity
        $this->logFromEmailActivity(15);

        $mass=Yii::app()->request->getQuery('mass');
        if(!empty($mass) && $mass==1) {
            $data['email']=Yii::app()->user->identity->email;
            Logging::logActivity(Yii::app()->user->identity, Logging::IDEAL_SIZE, false, $data);
        }

        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()
                            ->controller
                            ->createUrl('/register/index', array(
                                'code' => Item::getRandomItemCode(),
                                'mass' => $mass,
                                    )
                            )
            );
        }

        if (is_null(Yii::app()->request->getQuery('parent_id')))
            throw new CHttpException(500, 'parent_id required!');

        $dbCommand = Yii::app()->db->createCommand("
           SELECT id,COUNT(*) as item FROM `item` WHERE parent_id=:parent_id AND ready=1 AND unavailable !=1 AND is_blocked=0 GROUP BY `id`
        ");

        $dbCommand->bindParam(":parent_id", Yii::app()->request->getQuery('parent_id'), PDO::PARAM_STR);
        $item_result = $dbCommand->queryAll();

        $this->render('suitableItems', array('itemCount' => count($item_result)));
    }

    public function actionSuitableItemsViaAjax() {
        if (is_null(Yii::app()->request->getPost('parent_id')))
            throw new CHttpException(500, 'parent_id required!');

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
                $ev = new Evaluate($result['id'], $result['type_id'], Yii::app()->user->id);
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

        $result['html'] = $this->renderPartial('_img_fit', array('data' => $evaluated), true, false);
        $result['processed'] = count($item_result);
        $result['fitting'] = count($evaluated);
        $lastItemId = end($evaluated);
        $result['lastItemId'] = $lastItemId['id'];
        $result['i'] = $i;

        echo CJavaScript::jsonEncode($result);
        Yii::app()->end();
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    public static function Logging() {
//        $this->actionLogin();
    }
    public function actionLogin() {
        $this->layout = '//layouts/main-temp';
        $model = new User('login');

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            $this->performAjaxValidation($model);
        }

        if (isset($_POST['User'])) {
            //$data['email']=$model->email;
            $model->attributes = $_POST['User'];

            if ($model->validate() && $model->authenticate()) {
                Yii::app()->user->login($model, Yii::app()->params['loginDuration']);

                //Logging
                //Logging::logActivity($model,3,false,$data);
                //TODO: get user role
                if(Yii::app()->user->checkAccess('superadmin') || Yii::app()->user->checkAccess('admin'))
                    $this->redirect(Yii::app()->controller->createUrl('admin/user/index'));
                elseif(Yii::app()->user->checkAccess('consultant'))
                    $this->redirect(Yii::app()->controller->createUrl('admin/consultant/index'));
            } else {
                //Logging
                //Logging::logActivity($model,4,false,$data);
            }
        }

        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
        $code = Yii::app()->request->getQuery('code');
        //if no code passed, we select one randomly
        if (is_null($code) || empty($code)) {
            $code = Item::getRandomItemCode();
        }

        if (Helper::isAdminUrl())
            $redirect = Yii::app()->controller->createUrl('site/login');
        else
            $redirect = Yii::app()->controller->createUrl('register/index', array('code' => $code, 'page' => 'login'));

        Yii::app()->user->logout();
        $this->redirect($redirect);
    }

    public function actionSetPassword() {
        $id = Yii::app()->request->getQuery('id');
        $hash = Yii::app()->request->getQuery('hash');
        $type = Yii::app()->request->getQuery('type');

        if ($type == 1)
            $this->layout = '//layouts/main';
        else
            $this->layout = '//layouts/main-temp';

        $model = User::model()->findByPk(array('id' => ':id', ':id' => $id));
        if ($model->hash != $hash)
            $this->render('setPassword', array('set' => false));

        $model->password = '';
        $model->scenario = 'setPassword';

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $data['email'] = $model->email;

            if ($model->validate()) {
                $model->hash = '';
                if ($model->save(true, array('password', 'hash'))) {
                    Logging::logActivity($model, 11, false, $data);
                    $this->redirect(array('setPasswordResult', 'result' => true, 'type' => $type));
                } else {
                    Logging::logActivity($model, 12, false, $data);
                    $this->redirect(array('setPasswordResult', 'result' => false, 'type' => $type));
                }
            } else {
                Logging::logActivity($model, 13, false, $data);
            }
        }

        $this->render('setPassword', array('model' => $model, 'set' => true));
    }

    public function actionSetPasswordResult($result, $type) {
        if ($type == 1)
            $this->layout = '//layouts/main';
        else
            $this->layout = '//layouts/main-temp';
        $this->render('setPasswordResult', array('result' => $result, 'type' => $type));
    }

    public function actionRestorePassword() {
        $this->layout = '//layouts/main-temp';
        if (!Yii::app()->request->isPostRequest)
            throw new CHttpException(400);

        $model = new User('restorePassword');

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'restore-pass-form') {
            $this->performAjaxValidation($model);
        }

        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            if (isset($_POST['User'])) {
                $model->attributes = $_POST['User'];
                $data['email'] = $model->email;

                if ($model->validate() && $model->ifEmailExists()) {
                    $user = User::model()->findByAttributes(array('email' => $model->email));
                    $user->hash = Helper::createHash();
                    $user->save(true, array('hash'));

                    if (User::emailPassword($model)) {
                        $data['message'] = Yii::t('restorePassForm', 'На ваш email было выслано письмо с ссылкой на восстановление пароля.');
                        Logging::logActivity($model, 8, false, $data);
                    } else {
                        $data['message'] = Yii::t('restorePassForm', 'Возникла ошибка при отправке email.');
                        Logging::logActivity($model, 9, false, $data);
                    }

                    echo $this->renderPartial('restorePasswordSuccess', $data, false, true);
                    Yii::app()->end();
                } else {
                    Logging::logActivity($model, 10, false, $data);
                }
            }

            $data['model'] = $model;
            echo $this->renderPartial('restorePassword', $data, false, true);
            Yii::app()->end();
        }
    }

    public function actionMyData() {
        //authenticate user without asking login and pass by hash
        $this->authenticateOnLoginByHash();
        //log from email activity        
        $this->logFromEmailActivity(20);        
        
        $model = User::model()->findByPk(array('id' => ':id', ':id' => Yii::app()->user->id));

        if($model===null)
            throw new CHttpException(404,Yii::t('errors','Пользователь с таким id не найден'));

        $model->scenario = 'clientPrivateDataUpdate';
        $model->password = null;

        $language = Yii::app()->language;
        $user_id = Yii::app()->user->id;
        //TODO: this query retreives all the user sizes and populates with values those, that have been created before
        //SELECT t1.id, t1.weight, t2.id, t2.size_id, t2.value
        //FROM clientsize AS t1 
        //LEFT JOIN client_size AS t2 ON t1.id=t2.size_id AND t2.client_id=289 AND t2.is_locked=0;

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
        //Helper::myPrint_r($result,true);
        //check from where user comes
        $returnToModel = Helper::CheckUrl('/site/result');

        $listOfClientSizeModelsForUpdate = ItemType::getListOfSizeModelsByItemTypeId($result);
        
        foreach($listOfClientSizeModelsForUpdate as $item)
        {
            $validateModels[]=$item['model'];
        }
        
        //$listOfClientSizeModelsForUpdate = $model->getListOfClientSizeModels(true);
        if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'client-size-form') {
            $model->scenario = 'clientPrivateDataUpdateSize';
            $this->performMultipleModelAjaxValidation($validateModels);
        }

        if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'client-data-form') {
            $model->scenario = 'clientPrivateDataUpdateData';
            $this->performAjaxValidationOnError($model);
        }

        if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'client-password-form') {
            $model->scenario = 'clientPrivateDataUpdatePass';
            $model->password = null;
            $this->performAjaxValidationOnError($model);
        }

        if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'client-options-form') {
            $model->scenario = 'updateOptions';
        }

        if ($model === null)
            throw new CHttpException(404);

        //change private data and password
        if (!is_null(Yii::app()->request->getPost('User'))) {
            $model->attributes = Yii::app()->request->getPost('User');
            if ($model->validate()) {
                if ($model->save()) {
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'message' => Yii::t('cabinet', 'Изменения сохранены!'),
                    ));
                    Yii::app()->end();
                }
            }
        }

        //populate size data
        $clientHasSize = Yii::app()->request->getPost('ClientHasSize');
        $errorsArray = array();
        if (!is_null($clientHasSize)) {
            $clientSizeSave=true;
            $modifiedCount=0;
            foreach ($listOfClientSizeModelsForUpdate as $key => $item) {
                //find and create records only for those item sizes whose values have been changed
                if($item['model']->value != $clientHasSize[$key]['value']) {
                    //record with old value remains for the history. For this purpose we change by modifying is_locked value from 0 to 1
                    Yii::app()->db->createCommand()->update('client_size', array(
                        'is_locked'=>'1',
                     ), 'id=:id', array(':id'=>$key));                
                    
                    $item['model']->value = $clientHasSize[$key]['value'];
                    $clientSizeSave=$item['model']->save(false) && $clientSizeSave;
                    $modifiedCount++;
                }
            }
            
            if($modifiedCount==0)
                Yii::app()->end();
                
            if ($clientSizeSave) {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'message' => Yii::t('cabinet', 'Изменения размеров сохранены!'),
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'error',
                    'message' => Yii::t('cabinet', 'Произошла ошибка!'),
                ));
            }
            Yii::app()->end();
        }

        $this->render('myData', array(
            'model' => $model,
            'uid' => $model->id,
            'returnToModel' => $returnToModel,
            'listOfClientSizeModelsForUpdate' => $listOfClientSizeModelsForUpdate,
                )
        );
    }

/////////////////
    /**
     * Changes password for user via ajax.
     * Uses changePassword scenario
     */
    public function actionChangePassword() {
        if (!Yii::app()->request->isPostRequest)
            throw new CHttpException(400);

        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $model = User::model()->findByPk(array('id' => ':id', ':id' => Yii::app()->user->id));
            $model->scenario = 'changePassword';
            $model->password = null;

            if (!is_null(Yii::app()->request->getPost('User'))) {
                $model->attributes = Yii::app()->request->getPost('User');

                if ($model->validate() && $model->checkPass()) {
                    if ($model->save(true, array('password'))) {
                        $data['message'] = Yii::t('infoMessages', 'Пароль успешно изменен!');
                        $html = $this->renderPartial('/layouts/messages/_message_success', $data, true, false);

                        echo CJSON::encode(array(
                            'status' => 'success',
                            'html' => $html
                        ));
                        Yii::app()->end();
                    }
                }
            }

            $data['model'] = $model;
            $html = $this->renderPartial('change_pass_form', $data, true, false);

            echo CJSON::encode(array(
                'status' => 'render',
                'html' => $html
            ));

            Yii::app()->end();
        }
    }

////////////////    



    public function actionResult() {
        $this->layout = '//layouts/main-result';
        $sizeList = array();
        $propToJs = array();

        $item_id = (!is_null(Yii::app()->request->getQuery('item_id'))) 
            ? Yii::app()->request->getQuery('item_id')
            : Yii::app()->request->getPost('item_id');
        
        //auth user on page load without asking login/pass
        $this->authenticateOnLoginByHash();
        //log from email activity
        if(!is_null(Yii::app()->request->getQuery('seen')))
            $this->logFromEmailActivity(14);
        else 
            $this->logFromEmailActivity(16);

        if (is_null($item_id) && !Yii::app()->request->isPostRequest) {
            $query = 'SELECT id, type_id FROM item WHERE code=:code AND is_blocked=0';
            $command = Yii::app()->db->createCommand($query);
            $command->bindParam(":code", Yii::app()->request->getQuery('code'), PDO::PARAM_STR);
            $result = $command->queryAll();

            $item_id = ($result[0]['id']) ? $result[0]['id'] : 0;
            $type_id = ($result[0]['type_id']) ? $result[0]['type_id'] : 0;
            
            if($item_id==0)
                throw new CHttpException(404, Yii::t('result', 'Изделие не найдено!'));    
            
        }

        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()
                            ->controller
                            ->createUrl('/register/index', array(
                                //'item_id'=>$item_id,
                                //'type_id'=>$type_id,
                                'code' => Yii::app()->request->getQuery('code'),
                                    )
                            )
            );
        }
/////////////////////////////////////// get additional measures  ///////////////////////////////////////
        //get item type id
        $query = 'SELECT type_id
                FROM item
                WHERE id=:item_id';

        $command = Yii::app()->db->createCommand($query);
        $command->bindParam(":item_id", $item_id, PDO::PARAM_STR);
        $result = $command->queryAll();
        $type_id = $result[0]['type_id'];

        //here we check if there is all necessary user size params to evaluate an item
        //get item size params into array
        $query = 'SELECT size_id AS id
                FROM itemtype_size
                WHERE itemtype_id=:itemType_id';

        $command = Yii::app()->db->createCommand($query);
        $command->bindParam(":itemType_id", $type_id, PDO::PARAM_STR);
        $result = $command->queryAll();
        $resultSize = array();
        foreach ($result as $item) {
            $resultSize[] = $item['id'];
        }

        //get user params
        $client_id = Yii::app()->user->id;
        $query = 'SELECT size_id, value  
                FROM client_size
                WHERE client_id=:client_id AND value != 0 AND is_locked=0
                ORDER BY weight ASC';

        $command = Yii::app()->db->createCommand($query);
        $command->bindParam(":client_id", $client_id, PDO::PARAM_STR);
        $result = $command->queryAll();

        $resultClientSize = array();
        foreach ($result as $item) {
            $resultClientSize[] = $item['size_id'];
        }

        if (!empty($resultSize) && !empty($resultClientSize))
            $diff_result = array_diff($resultSize, $resultClientSize);

        //get item size params to aks for
        if (isset($diff_result) && count($diff_result) > 0) {

            $language = Yii::app()->language;
            $query = 'SELECT t1.size_id AS id, t3.title, t3.video_url, t3.video_text  
                    FROM itemtype_size as t1 
                    JOIN clientsize AS t2 ON t1.size_id=t2.id JOIN clientsize_translation AS t3 ON t2.id=t3.id 
                    WHERE t1.size_id IN (' . implode(",", $diff_result) . ')
                    AND t1.itemtype_id=:itemType_id 
                    AND t3.language_id=:lang
                    ORDER BY weight ASC';

            $command = Yii::app()->db->createCommand($query);
            $command->bindParam(":lang", $language, PDO::PARAM_STR);
            $command->bindParam(":itemType_id", $type_id, PDO::PARAM_STR);
            $result = $command->queryAll();

            $sizeList = ItemType::getListOfSizeModelsByItemTypeId($result);

            $user = User::model()->findByPk($client_id);
            //$user->scenario='requestSizeData';

            //validate requested params
            if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'registration') {
                foreach ($sizeList as $key => $item) {
                    if (isset($_POST['ClientHasSize'][$key])) {
                        $item['model']->attributes = $_POST['ClientHasSize'][$key];
                        $validateModels[$key] = $item['model'];
                    }
                    $validateModels[0] = $user;// do not validate user on requesting additional data
                }
                $this->performMultipleModelAjaxValidation($validateModels);
            }

            //save requested params            
            $clientHasSize = Yii::app()->request->getPost('ClientHasSize');
            if (isset($clientHasSize) && !is_null($clientHasSize)) {
                foreach ($sizeList as $key => $item) {
                    $item['model']->client_id = $user->id;
                    $item['model']->attributes = $clientHasSize[$key];
                    $clientSizeSave = $item['model']->save();
                }

                //Logging
                Logging::logActivity($user, 6);
                $this->redirect(Yii::app()->controller->createUrl('/site/result', array('item_id' => $item_id, 'type_id' => $type_id, 'code' => Yii::app()->request->getQuery('code'))));
            }

            $intro = Settings::model()->findByAttributes(array('code' => 'intro_' . Yii::app()->language));
            $first = current($sizeList);

            $this->render('getSize', array(
                'sizeList' => $sizeList,
                'user' => $user,
                'code' => Yii::app()->request->getQuery('code'),
                'intro' => $intro->value,
                'first_video' => $first,
                'item_id' => $item_id,
            )
            );
/////////////////////////////////////// get additional measures END  ///////////////////////////////////////               
        } else {
            //load item by id
            $query = 'SELECT t1.id, t1.colour, t1.type_id, t1.stretch, t1.weight, t1.code, t1.parent_id, t2.title, t3.name as image, t3.thumbnail as thumbnail, t4.company_title, t4.www as www
                    FROM item as t1 
                    JOIN item_translation AS t2 ON t2.id=t1.id AND t2.language_id=:lang
                    LEFT JOIN item_image AS t3 ON t3.item_id=t1.id AND t3.main=1
                    LEFT JOIN user AS t4 ON t1.partner_id=t4.id
                    WHERE t1.id=:item_id AND t1.is_blocked=0 
                    ORDER BY weight ASC';

            $lang = Yii::app()->language;
            $command = Yii::app()->db->createCommand($query);
            $command->bindParam(":lang", $lang, PDO::PARAM_STR);
            $command->bindParam(":item_id", $item_id, PDO::PARAM_STR);
            $item_result = $command->queryAll();

            $model = User::model()->findByPk(Yii::app()->user->id);
            //Logging
            Logging::logActivity($model, 5, $item_id);

/////////////////evaluate size on server side/////////////////
            //$itemID=264,$itemTypeId=48, $clientId=6   
            if(empty($item_result))
                throw new CHttpException(404, Yii::t('result', 'Изделие не найдено!'));
                      
            $lastuserid=Yii::app()->request->getQuery('lastuserid');
            if (is_null($lastuserid) || empty($lastuserid))
                $user_id=Yii::app()->user->id;
            else
                $user_id=Yii::app()->request->getQuery('lastuserid');

            $ev = new Evaluate($item_result[0]['id'], $type_id, $user_id);
            $evResult = $ev->evaluateSize();
            $data = Yii::app()->db->createCommand()
                    ->select('t1.type,t2.user_title, t3.range')
                    ->from('formula as t1')
                    ->leftJoin('resformulatitle_translation as t2', 't2.id=t1.title AND t2.language_id=:lang', array(':lang' => Yii::app()->language))
                    ->leftJoin('resformulatitle as t3', 't3.id=t1.title')
                    ->where('t1.type_id=:item_type_id AND t1.type=2', array(':item_type_id' => $type_id))
                    ->order('t1.weight ASC')
                    ->queryAll();
/////////////////evaluate size on server side END/////////////////            
            //Helper::myPrint_r($item_result);
            
            //update last evaluated item id
            $field=($evResult['status']['result']==1)
                ? array('last_item_id'=>$item_result[0]['id'])
                : array('last_nf_item_id'=>$item_result[0]['id']);
                           
            Yii::app()->db->createCommand()->update('user',$field,'id=:id', array(':id'=>Yii::app()->user->id));
            
            $this->render('result', array(
                'item' => $item_result,
//                'type_id'=>$type_id,
                'evaluation' => json_encode($evResult),
                'evResult' => $evResult,
                'code' => Yii::app()->request->getQuery('code'),
                'rangef' => $data,
                    )
            );
        }
    }

    //depricated
    public function actionLoadDataForResultFormulas() {

        $sizeList = array();
        $propToJs = array();

        //load range by item type_id
        $filePath = Yii::app()->runtimePath . '/formulaRangeList_' . Yii::app()->request->getPost('type_id');

        if (!file_exists($filePath))
            throw new CHttpException(400, 'No range file found!');

        $rangeData = unserialize(file_get_contents($filePath));

        //load item size list
        $query = 'SELECT t1.*, t2.stretch
                FROM itemsize t1 
                JOIN item AS t2 ON t2.id=item_id
                WHERE t1.item_id=:item_id
                AND t1.is_blocked=0 
                ORDER BY weight ASC';

        $command = Yii::app()->db->createCommand($query);
        $command->bindParam(":item_id", Yii::app()->request->getPost('item_id'), PDO::PARAM_STR);
        $item_size_result = $command->queryAll();

        foreach ($item_size_result as $row) {
            $sizeList[$row['title']] = array(
                'iwcb' => array(
                    'title' => 'iwcb',
                    'abr' => Yii::t('itemSize', 'Р’Рї'),
                    'value' => (is_null($row['iwcb']) || $row['iwcb'] == 0) ? null : $row['iwcb'],
                ),
                'il' => array(
                    'title' => 'il',
                    'abr' => Yii::t('itemSize', 'Р”Р'),
                    'value' => (is_null($row['il']) || $row['il'] == 0) ? null : $row['il'],
                ),
                'iwss' => array(
                    'title' => 'iwss',
                    'abr' => Yii::t('itemSize', 'Р”Р±С€'),
                    'value' => (is_null($row['iwss']) || $row['iwss'] == 0) ? null : $row['iwss'],
                ),
                'bw' => array(
                    'title' => 'bw',
                    'abr' => Yii::t('itemSize', 'РЁСЃ'),
                    'value' => (is_null($row['bw']) || $row['bw'] == 0) ? null : $row['bw'],
                ),
                'iwp' => array(
                    'title' => 'iwp',
                    'abr' => Yii::t('itemSize', 'РЁР“'),
                    'value' => (is_null($row['iwp']) || $row['iwp'] == 0) ? null : $row['iwp'],
                ),
                'iwa' => array(
                    'title' => 'iwa',
                    'abr' => Yii::t('itemSize', 'РЁРЈР“'),
                    'value' => (is_null($row['iwa']) || $row['iwa'] == 0) ? null : $row['iwa'],
                ),
                'iww' => array(
                    'title' => 'iww',
                    'abr' => Yii::t('itemSize', 'РЁРЈРў'),
                    'value' => (is_null($row['iww']) || $row['iww'] == 0) ? null : $row['iww'],
                ),
                'iwt' => array(
                    'title' => 'iwt',
                    'abr' => Yii::t('itemSize', 'РЁРЈР‘'),
                    'value' => (is_null($row['iwt']) || $row['iwt'] == 0) ? null : $row['iwt'],
                ),
                'ils' => array(
                    'title' => 'ils',
                    'abr' => Yii::t('itemSize', 'Р”Р '),
                    'value' => (is_null($row['ils']) || $row['ils'] == 0) ? null : $row['ils'],
                ),
                'iws' => array(
                    'title' => 'iws',
                    'abr' => Yii::t('itemSize', 'РЁР '),
                    'value' => (is_null($row['iws']) || $row['iws'] == 0) ? null : $row['iws'],
                ),
                'vpr' => array(
                    'title' => 'vpr',
                    'abr' => Yii::t('itemSize', 'Р’РїСЂ'),
                    'value' => (is_null($row['vpr']) || $row['vpr'] == 0) ? null : $row['vpr'],
                ),
                'rpli' => array(
                    'title' => 'rpli',
                    'abr' => Yii::t('itemSize', 'Р РїР»Р'),
                    'value' => (is_null($row['rpli']) || $row['rpli'] == 0) ? null : $row['rpli'],
                ),
                'stretch' => array(
                    'title' => 'stretch',
                    'abr' => Yii::t('itemSize', 'РњРќРў'),
                    'value' => (is_null($row['stretch']) || $row['stretch'] == 0) ? null : $row['stretch'],
                ),
                'iwar' => array(
                    'title' => 'iwar',
                    'abr' => Yii::t('itemSize', 'РЁРЈР“СЂ'),
                    'value' => (is_null($row['iwar']) || $row['iwar'] == 0) ? null : $row['iwar'],
                ),
                'iwwr' => array(
                    'title' => 'iwwr',
                    'abr' => Yii::t('itemSize', 'РЁРЈРўСЂ'),
                    'value' => (is_null($row['iwwr']) || $row['iwwr'] == 0) ? null : $row['iwwr'],
                ),
            );
        }

        if (isset($sizeList)) {
            foreach ($sizeList as $key => $sizeItems) {
                foreach ($sizeItems as $key_s => $sizeItem) {
                    if ($sizeItem['value'] == null) {
                        unset($sizeList[$key][$key_s]);
                    } else {
                        $propToJs['prop']['{' . $key . '_' . $sizeItem['abr'] . '}'] = $sizeItem['value'];
                        $propToJs['size'][$key] = $key;
                    }
                }
            }
        }

        //load formula for a type_id
        $html = null;
        $models = Formula::model()->unlocked()->noParent()->findAll(array(
            'condition' => 'type_id=:type_id', 'params' => array(':type_id' => Yii::app()->request->getPost('type_id'))));

        $item = Item::model()->findByPk(Yii::app()->request->getPost('item_id'));

        $html = $this->renderPartial('_formula', array('models' => $models, 'sizeList' => ($item) ? $item->sizeList : null), true, false);

        //load client size properties
        $client_id = Yii::app()->user->id;

        $models = ClientHasSize::model()->visible()->findAll(array(
            'condition' => 'client_id=:client_id', 'params' => array(':client_id' => $client_id)));

        $data = (!empty($client_id) && count($models) == 0) ? array('empty' => 1) : array();

        foreach ($models as $model) {
            //$info=$model->size->translations[Yii::app()->language]->title . " ({$model->value})";
            $info = null;
            //$info= str_replace(" ","&#32;",$info);
            //$short_title=$model->size->translations[Yii::app()->language]->short_title;
            $short_title = null;
            //$short_title=str_replace(array('(', ')'),array('{', '}'),$short_title);
            $vst = $vk = $vzu = $dts = $dr = false;
            if ($model->size_id == 7) {
                $vst = $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title' => Yii::t('imemSize', '{Р’С€С‚}'), 'info' => str_replace(" ", "&#32;", Yii::t('imemSize', 'Р’С‹СЃРѕС‚Р° С€РµР№РЅРѕР№ С‚РѕС‡РєРё (Р’С€С‚- ' . $model->vst . ')'))), true, false);
                $vk = $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title' => Yii::t('imemSize', '{Р’Рє}'), 'info' => str_replace(" ", "&#32;", Yii::t('imemSize', 'Р’С‹СЃРѕС‚Р° РєРѕР»РµРЅР° (Р’Рє- ' . $model->vk . ')'))), true, false);
                $vzu = $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title' => Yii::t('imemSize', '{Р’Р—РЈ}'), 'info' => str_replace(" ", "&#32;", Yii::t('imemSize', 'Р’С‹СЃРѕС‚Р° Р·Р°РґРЅРµРіРѕ СѓРіР»Р° РїРѕРґРјС‹С€РµС‡РЅРѕР№ РІРїР°РґРёРЅС‹ (Р’Р—РЈ- ' . $model->vzu . ')'))), true, false);
                $dts = $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title' => Yii::t('imemSize', '{Р”РўРЎ}'), 'info' => str_replace(" ", "&#32;", Yii::t('imemSize', 'Р”Р»РёРЅР° СЃРїРёРЅРєРё РґРѕ С‚Р°Р»РёРё (Р”РўРЎ- ' . $model->dts . ')'))), true, false);
                $dr = $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title' => Yii::t('imemSize', '{Р”СЂ}'), 'info' => str_replace(" ", "&#32;", Yii::t('imemSize', 'Р”Р»РёРЅР° СЂСѓРєР°РІР° (Р”СЂ- ' . $model->dr . ')'))), true, false);
            }
            $data[] = array(
                'abr' => str_replace(array('(', ')'), array('', ''), $model->size->translations[Yii::app()->language]->short_title),
                'value' => $model->value,
                'vstvalue' => $model->vst,
                'vkvalue' => $model->vk,
                'vzuvalue' => $model->vzu,
                'dtsvalue' => $model->dts,
                'drvalue' => $model->dr,
                'vst' => ($vst) ? $vst : null,
                'vk' => ($vk) ? $vk : null,
                'vzu' => ($vzu) ? $vzu : null,
                'dts' => ($dts) ? $dts : null,
                'dr' => ($dr) ? $dr : null,
                'link' => $this->renderPartial('application.modules.admin.views.formula._itemSizeHolder', array(
                    'title' => $short_title, 'info' => $info), true, false),
            );
        }

        //remove elements with value==null
        $clientPropToJs = array();
        if (isset($data) && count($models) != 0) {
            foreach ($data as $key => $value) {
                if ($data[$key]['value'] == null) {
                    unset($data[$key]);
                } else {
                    $clientPropToJs['{' . $data[$key]['abr'] . '}'] = $data[$key]['value'];

                    if ($data[$key]['vst'] != null)
                        $clientPropToJs['{Р’С€С‚}'] = $data[$key]['vstvalue'];

                    if ($data[$key]['vk'] != null)
                        $clientPropToJs['{Р’Рє}'] = $data[$key]['vkvalue'];

                    if ($data[$key]['vzu'] != null)
                        $clientPropToJs['{Р’Р—РЈ}'] = $data[$key]['vzuvalue'];

                    if ($data[$key]['dts'] != null)
                        $clientPropToJs['{Р”РўРЎ}'] = $data[$key]['dtsvalue'];

                    if ($data[$key]['dr'] != null)
                        $clientPropToJs['{Р”СЂ}'] = $data[$key]['drvalue'];
                }
            }
        }


        $result_data = array(
            'propToJs' => $propToJs,
            'rangeData' => $this->convertToJS($rangeData),
            'clientPropToJs' => $clientPropToJs,
            'html' => $html,
        );

        echo json_encode($result_data);
        Yii::app()->end();
    }

    public function convertToJS($data) {
        $dataToJs = array();
        foreach ($data as $item) {
            $name = '{' . $item['title'] . '_min}';
            $dataToJs[$name] = $item['min'];
            $name = '{' . $item['title'] . '_minr}';
            $dataToJs[$name] = $item['minr'];
            $name = '{' . $item['title'] . '_maxr}';
            $dataToJs[$name] = $item['maxr'];
            $name = '{' . $item['title'] . '_max}';
            $dataToJs[$name] = $item['max'];
        }
        return $dataToJs;
    }

    /**
     * Sets the current language according to selection.
     * @param _lang contains language identifier.
     */
    public function actionChangeLanguage() {
        if(!is_null(Yii::app()->request->getQuery('language')))
        {
            Yii::app()->user->language = Yii::app()->request->getQuery('language');
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    public function actionLogSteps() {
        $data = array(
            'video_id' => Yii::app()->request->getQuery('video_id'),
            'video_title' => Yii::app()->request->getQuery('video_title'),
            'session_id' => Yii::app()->request->getQuery('session_id'),
            'message' => Yii::app()->request->getQuery('message'),
        );
        Logging::logActivity(false, 7, false, $data);
        Yii::app()->end();
    }
    
    public function actionMoveOn() {

        $code=Yii::app()->request->getQuery('code');
        $this->authenticateOnLoginByHash();
        //log from email activity        
        $this->logFromEmailActivity(19);
        //redirect to partner page
        $this->redirect("http://www.musthave.ua/search?search={$code}");
    }    

}