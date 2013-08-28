<?php

class UserController extends Controller {

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + block, markAsDeleted, emailPassword',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'roles' => array('manage_admin'),//this is a role containing all tasks and operations
            ),
            array('allow',
                'roles' => array('view_admin'),//allows to view admin list
                'actions' => array('index'),
            ),
            array('allow',
                'roles' => array('create_admin'),//allows to create an admin
                'actions' => array('create'),
            ),
            array('allow',
                'roles' => array('update_admin'),//allows to update an admin
                'actions' => array('update'),
            ),
            array('allow',
                'roles' => array('mark_as_deleted_admin'),//allows to markAsDeleted an admin
                'actions' => array('markAsDeleted'),
            ),
            array('allow',
                'roles' => array('block_admin'),//allows to block an admin
                'actions' => array('block'),
            ),
            array('allow',
                'roles' => array('generate_password_admin'),//allows to generate password for admin
                'actions' => array('generatePassword'),
            ),
            array('allow',
                'roles' => array('change_password_admin'),//allows to change password for admin
                'actions' => array('changePassword'),
            ),
            array('allow',
                'roles' => array('email_password_admin'),//allows to email password for admin
                'actions' => array('emailPassword'),
            ),
            array('deny'),
        );
    }

    /**
     * Actions used for admin module
     * block - block/unblock user
     * markAsDeleted sets user is_blocked db field value to '2' meaning
     * that the user is deleted but actually it remains in the database
     */
    function actions() {
        return array(
            'block' => array(
                'class' => 'application.modules.admin.components.actions.BlockAction',
                'modelClass' => 'User',
                'message_block' => Yii::t('infoMessages', 'Пользователь разблокирован!'),
                'errorMessage_block' => Yii::t('infoMessages', 'Произошла ошибка при разблокировании пользователя!'),
                'message_unBlock' => Yii::t('infoMessages', 'Пользователь заблокирован!'),
                'errorMessage_unBlock' => Yii::t('infoMessages', 'Произошла ошибка при блокировании пользователя!'),
            ),
            'markAsDeleted' => array(
                'class' => 'application.modules.admin.components.actions.MarkAsDeletedAction',
                'modelClass' => 'User',
                'message_mark' => Yii::t('infoMessages', 'Пользователь удален!'),
                'errorMessage_mark' => Yii::t('infoMessages', 'Произошла ошибка при удалении пользователя!'),
            )
        );
    }

    public function actionIndex() {
        $search = new User('search');
        $search->unsetAttributes();
        if (!is_null(Yii::app()->request->getQuery('User')))
            $search->attributes = Yii::app()->request->getQuery('User');

        $criteria = new CDbCriteria;
        $criteria->compare('t.name', $search->name, true);
        $criteria->compare('t.email', $search->email, true);
        $criteria->compare('t.is_blocked', array('0' => 0, '1' => 1));
        $criteria->compare('t.is_backend_user', array('1' => 1));

        $dataProvider = new ActiveDataProvider('User', array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => array('create_time' => true),
                'sortVar' => 'sort',
            ),
            'pagination' => array(
                'pageVar' => 'page',
                'sizeVar' => 'size',
                'pageSize' => Yii::app()->params['defaultPageSize'],
                'sizeOptions' => Yii::app()->params['sizeOptions'],
            ),
        ));

        if (!is_null(Yii::app()->request->getQuery('ajax'))) {
            $this->renderPartial('_grid', array(
                'dataProvider' => $dataProvider,
                'search' => $search,
            ));
        } else {
            $this->render('index', array(
                'dataProvider' => $dataProvider,
                'search' => $search,
            ));
        }
    }

    public function actionCreate() {
        $model = new User;

        if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'create-user-form')
            $this->performAjaxValidation($model);

        if (!is_null(Yii::app()->request->getPost('User'))) {
            $model->attributes = Yii::app()->request->getPost('User');
            $model->is_backend_user = 1;
            $model->is_admin = 1;

            if ($model->save()) {
                //save client role for user
                Yii::app()->authManager->assign('superadmin', $model->id);
                $this->setFlashSuccess(Yii::t('infoMessages', 'Новый пользователь добавлен!'));
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model
        ));
    }

    public function actionUpdate() {
        $model = $this->loadModel();

        if (!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax') === 'update-user-form') {
            $this->performAjaxValidation($model);
        }

        if ($model === null)
            throw new CHttpException(404);

        if (!is_null(Yii::app()->request->getPost('User'))) {
            $model->attributes = Yii::app()->request->getPost('User');

            if ($model->save()) {
                $this->setFlashSuccess(Yii::t('infoMessages', 'Данные пользователя обновлены!'));
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'uid' => $model->id
        ));
    }

    /**
     * Generates random password combinations
     * @return random password combinations 
     */
    public function actionGeneratePassword() {
        if (!Yii::app()->request->isPostRequest)
            throw new CHttpException(400);

        if (Yii::app()->request->isAjaxRequest)
            echo Helper::randomPassword();
    }

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

    /**
     * Sends email with a link for setting password
     */
    public function actionEmailPassword() {
        if (!Yii::app()->request->isPostRequest)
            throw new CHttpException(400);

        $model = $this->loadModel();
        $model->hash = Helper::createHash();
        $model->save(true, array('hash'));

        if (Yii::app()->request->isAjaxRequest) {
            $data['message'] = Yii::t('infoMessages', 'Email для создания пароля успешно отправлен!');
            $data['errorMessage'] = Yii::t('infoMessages', 'Возникла ошибка при отправке Email для создания пароля!');

            if (User::emailPassword($model))
                $this->renderPartial('/layouts/messages/_message_success', $data, false, true);
            else
                $this->renderPartial('/layouts/messages/_message_error', $data, false, true);
        }
    }
    
    public function geoTargeting() {
        if(!is_null(Yii::app()->request->getPost('id'))) {

             $id = Yii::app()->request->getPost('id');
             $ip = Yii::app()->request->getPost('ip');
                    
             $curlopt_useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)';
             $url = 'http://ipinfodb.com/ip_locator.php?ip=' . urlencode($ip);
             $ch = curl_init();
             
             $curl_opt = array(
                CURLOPT_FOLLOWLOCATION => 0,
                CURLOPT_HEADER => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_USERAGENT => $curlopt_useragent,
                CURLOPT_URL => $url,
                CURLOPT_TIMEOUT => 1,
                CURLOPT_REFERER => 'http://' . $_SERVER['HTTP_HOST'],
             );
             
             curl_setopt_array($ch, $curl_opt);
             $content = curl_exec($ch);
             ///if (!is_null($curl_info)) { $curl_info = curl_getinfo($ch); }
             curl_close($ch);

             if ( preg_match('{<li>Country : (\\w*)\\b}i', $content, $regs) ) { $ret['country'] = $regs[1]; }
             if ( preg_match('{<li>City : ([^<]*)</li>}i', $content, $regs) ) { $ret['city'] = $regs[1]; }
             if ( preg_match('{<li>State/Province : ([^<]*)</li>}i', $content, $regs) ) { $ret['state'] = $regs[1]; }
             
             ///  str_replace( '/img', 'http://ipinfodb.com/img',
         } 

        echo json_encode($ret);
        Yii::app()->end();
    }
                
                

}