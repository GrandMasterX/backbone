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
                'actions' => array('myData','modal'),
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
        $slider = self::actionGetslider();
        $steps = self::actionGetsteps();
        $this->render('main', array('data' => 'Index page','slider'=>$slider,'steps'=>$steps));
    }

    public function actionModal() {
        $data = $this->getInputAsJson();
        $model = new Joinus();
        if(empty($data['name']) || empty($data['email']))
        {
            $this->sendResponse(401, 'There was an error while sending data');
        } else {
            $model->attributes = $data;
            if($model->validate()) {
                $model->save();
                $this->sendResponse(200, 'Email was sended successfull');
            }
        }
    }

    public function actionKnowmore() {
        $data = $this->getInputAsJson();
        $model = new Joinus();
        $model->scenario = 'know_more';
        if(empty($data['email']))
        {
            $this->sendResponse(401, Yii::t('promo','Не заполнено поле емейл!'));
        } else {
            $model->attributes = $data;
            if($model->validate()) {
                $model->save();
                $this->sendResponse(200, Yii::t('promo','Спасибо за подписку!'));
            }
        }
    }

    public function actionAdvisemagazine() {
        $data = $this->getInputAsJson();
        $model = new Joinus();
        $model->scenario = 'magazine';
        if(empty($data['email']) || empty($data['url']))
        {
            $this->sendResponse(401, Yii::t('promo','Не заполнено из полей!'));
        } else {
            $model->attributes = $data;
            if($model->validate()) {
                $model->save();
                $this->sendResponse(200, Yii::t('promo','Спасибо за совет!'));
            }
        }
    }

    public function actionService(){
        $this->render('service',array());
    }

    public function actionHowitworks(){
        $this->render('howitworks',array());
    }

    public function actionPartners(){
        $this->render('partners',array());
    }
    public function actionContacts(){
        $this->render('contacts',array());
    }

    public function actionGetmenu() {
        echo json_encode(Pages::getPages());
    }

    public function actionGetslider() {
        //echo json_encode(Page::getSlider());
        return Page::getSlider();
    }

    public function actionGetsteps() {
        //echo json_encode(Page::getSteps());
        return Page::getSteps();
    }


    public function actionGetservice() {
        echo json_encode(Page::getService());
    }

    public function actionGethowitworks() {
        echo json_encode(Page::getHowitworks());
    }

    public function actionGetpartners() {
        //$text = array();
        $brands_list = Page::getPartners();
        $brands_list = self::pushToEndOfSubarrays($brands_list,Yii::t('page','смотреть сервис на сайте'));
        echo json_encode($brands_list);
    }

    public function pushToEndOfSubarrays($array, $item) {
        $ret = array();

        foreach ($array as $key => $subarray) {
            $subarray['look_service'] = $item;
            $ret[$key] = $subarray;
        }

        return $ret;
    }

    public function actionGetcontacts() {
        echo json_encode(Page::getContacts());
    }

    public function actionGetpartnerslike() {
        echo json_encode(Page::getPartnerslike());
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

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
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