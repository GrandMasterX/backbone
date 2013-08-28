<?php
class RegisterController extends Controller
{

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + RestorePassword, LogSteps',
        );
    }    
    
    public function init()
    {
        $this->layout='//layouts/main-register';
        parent::init();
    }
    
    public function actions()
    {
        return array(
            'oauth' => array(
              // the list of additional properties of this action is below
              'class'=>'ext.hoauth.HOAuthAction',
              // Yii alias for your user's model, or simply class name, when it already on yii's import path
              // default value of this property is: User
              'model' => 'User', 
              // map model attributes to attributes of user's social profile
              // model attribute => profile attribute
              // the list of avaible attributes is below
              'attributes' => array(
                'email' => 'email',
                'fname' => 'firstName',
                'lname' => 'lastName',
                'gender' => 'genderShort',
                'birthday' => 'birthDate',
                // you can also specify additional values, 
                // that will be applied to your model (eg. account activation status)
                'acc_status' => 1,
              ),
            ),
        );
    }

    public function actionIndex()
    {
        $code=Yii::app()->request->getQuery('code');
        if(!isset($code) || is_null($code))
            $this->redirect(Yii::app()->controller->createUrl('/site/shopList'));            
        
        $query='SELECT id, type_id FROM item WHERE code=:code AND is_blocked=0';
        $command = Yii::app()->db->createCommand($query);
        $command->bindParam(":code",$code,PDO::PARAM_STR);
        $result = $command->queryAll();        
        
        if(!isset($result) || empty($result))
            $this->redirect(Yii::app()->controller->createUrl('/site/shopList'));                    
        
        $item_id=($result[0]['id']) ? $result[0]['id'] : 0;
        $type_id=($result[0]['type_id']) ? $result[0]['type_id'] : 0;

        if(!Yii::app()->user->isGuest) {
            if(isset($item_id) && !is_null($item_id))
                $this->redirect(Yii::app()->controller->createUrl('/site/result',array('item_id'=>$item_id, 'code'=>$code)));
            else
                $this->redirect(Yii::app()->controller->createUrl('/site/index',array('item_id'=>$item_id, 'type_id'=>$type_id)));
        }

        $model=new User('login');

        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
            $this->performAjaxValidation($model);
        }         
        
        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];
            $data['email']=$model->email;

            if($model->validate() && $model->authenticate())
            {
                Yii::app()->user->login($model,Yii::app()->params['loginDuration']);
                //Logging
                Logging::logActivity($model,3,false,$data);
                //if a suitableItems link was clicked
                $mass=Yii::app()->request->getQuery('mass');
                if(!empty($mass) && $mass==1) {
                    //Logging::logActivity($model, Logging::IDEAL_SIZE, false, $data);
                    $this->redirect(Yii::app()->controller->createUrl('/site/suitableItems',array('parent_id'=>4,'mass'=>1)));
                }
                else
                    $this->redirect(Yii::app()->controller->createUrl('/site/result',array('code'=>$code,'item_id'=>$item_id)));
            } else {
                //Logging
                Logging::logActivity($model,4,false,$data);                
            }
        }	    
        
        $this->render('index', array('model'=>$model,'item_id'=>$item_id,'type_id'=>$type_id));
	}
    
    public function actionLogin() {
        SiteController::Logging();
    }
    
    public function actionSetsession(){
        $session = Yii::app()->session;
        $data = Yii::app()->request->getPost('size');
        if(count($session['sizeTours'])>3)
            //unset($session['sizeTours']);
        if (!isset($session['sizeTours']) || count($session['sizeTours'])==0) 
        {
            $session['sizeTours'] = array($data);
        }
        else {
           $myarr = $session['sizeTours'];
           $myarr[] = $data;
           $session['sizeTours'] = $myarr;
        }
        return true;
    }    
        
    public function actionSizeTour()
    {
        $itemType_id=Yii::app()->request->getQuery('type_id');
        $item_id=Yii::app()->request->getQuery('item_id');
        
        if(!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->controller->createUrl('/site/index',array('item_id'=>$item_id)));
        $user=new User('userRegister');
        
        $language=Yii::app()->language;
        $query='SELECT t1.size_id AS id, t3.title, t3.video_url, t3.video_text  
                FROM itemtype_size as t1 
                JOIN clientsize AS t2 ON t1.size_id=t2.id JOIN clientsize_translation AS t3 ON t2.id=t3.id 
                AND t1.itemtype_id=:itemType_id 
                AND t3.language_id=:lang
                ORDER BY weight ASC';
                
        $command = Yii::app()->db->createCommand($query);
        $command->bindParam(":lang",$language,PDO::PARAM_STR);
        $command->bindParam(":itemType_id",$itemType_id,PDO::PARAM_STR);
        $result = $command->queryAll();
        $sizeList=ItemType::getListOfSizeModelsByItemTypeId($result);        
        
        if(!is_null(Yii::app()->request->getPost('ajax')) && Yii::app()->request->getPost('ajax')==='registration') {
            foreach($sizeList as $key=>$item)
            {   
                 if(isset($_POST['ClientHasSize'][$key]))
                 {
                    $item['model']->attributes=$_POST['ClientHasSize'][$key];
                    $validateModels[$key] = $item['model'];
                 }
                 $validateModels[0] = $user;
            }
            $this->performMultipleModelAjaxValidation($validateModels);            
        }
        
        $clientHasSize=Yii::app()->request->getPost('ClientHasSize');
        
        if(!is_null($clientHasSize) && !is_null(Yii::app()->request->getPost('User')))
        {
            //Helper::myPrint_r($clientHasSize,true);
            $user->attributes=Yii::app()->request->getPost('User');
            
            $data=array(
                'session_id'=>Yii::app()->request->getPost('session_id'),
                'email'=>$user->email,
            );             
            
            
            //save the shop id the user comes from
            $query='SELECT partner_id FROM item WHERE id=:id';
            $command = Yii::app()->db->createCommand($query);
            $command->bindParam(":id",$item_id,PDO::PARAM_STR);
            $result=$command->queryAll();             
            
            $user->name=Helper::randomCode();
            $user->unhashed_password=$user->password;
            $user->is_client=1;
            $user->hash=Helper::createHash();
            $user->shop_id=(isset($result[0]['partner_id'])) ? $result[0]['partner_id'] : 0;

            if($user->save()){
                //save client role for user
                Yii::app()->authManager->assign('client', $user->id);
                //Yii::app()->authManager->save();
                if($user->authenticateOnRegistration())
                    Yii::app()->user->login($user,Yii::app()->params['loginDuration']);                
                
                //$user->emailGreetingsAndPassword($user);
                
                foreach($sizeList as $key=>$item)
                {
                    $item['model']->client_id=$user->id;
                    $item['model']->attributes=$clientHasSize[$key];
                    $clientSizeSave=$item['model']->save();
                }
                
//                $data=$item_id;
//                echo CJavaScript::encode($data);
                
                //Logging
                Logging::logActivity($user,1, false, $data);
                $this->redirect(Yii::app()->controller->createUrl('/site/result',array('item_id'=>$item_id)));
            } else {
                //Logging
                Logging::logActivity($user,2, false, $data);                
            }
        }
        
        $intro=Settings::model()->findByAttributes(array('code'=>'intro_'.Yii::app()->language));
        $this->render('sizeTour', array('sizeList'=>$sizeList, 'user'=>$user, 'intro'=>$intro->value, 'session_id'=>Helper::randomCode(7)));
    }
    
    public function actionRestorePassword()
    {
        $this->layout='//layouts/main-temp';
        if(!Yii::app()->request->isPostRequest)
            throw new CHttpException(400);
        
        $model= new User('restorePassword');
            
        if(isset($_POST['ajax']) && $_POST['ajax']==='restore-pass-form') {
            $this->performAjaxValidation($model);
        }               

        if(Yii::app()->request->isAjaxRequest){  
            $data = array();  
            if(isset($_POST['User']))
            { 
                $model->attributes=$_POST['User'];
                $data['email']=$model->email;

                if($model->validate())
                {
                    $user=User::model()->findByAttributes(array('email'=>$model->email));
                    $user->hash = Helper::createHash();
                    $user->save(true, array('hash'));

                    if (User::emailPassword($user)) {                       
                        $data['message'] = Yii::t('restorePassForm','На ваш email было выслано письмо с ссылкой на восстановление пароля.');    
                        Logging::logActivity($model,8, false, $data);
                    }    
                    else {
                        $data['message'] = Yii::t('restorePassForm','Возникла ошибка при отправке email.');
                        Logging::logActivity($model,9, false, $data);
                    }    

                    echo $this->renderPartial('restorePasswordSuccess', $data, false, true);
                    Yii::app()->end();
                } else {
                    Logging::logActivity($model,10, false, $data);                    
                }
            }

            $data['user'] = $model;        
            echo $this->renderPartial('restorePassword', $data, false, true);
            Yii::app()->end();         
        
        }
    }

    public function actionLogSteps() {
        $session_id = Yii::app()->request->getQuery('session_id');
        if(isset($session_id)) {
            $workstage = Yii::app()->request->getQuery('stage');
            
            $cookie = 0;
            if($workstage!=1) {
                $cookie = (isset(Yii::app()->request->cookies['workstage']->value)) ? Yii::app()->request->cookies['workstage']->value : 0;
            }

            if(!$cookie) {
                $cookie=Yii::app()->db->createCommand('SELECT 10*(1+FLOOR(MAX(workstage)/10)) FROM syslog')->queryScalar();
                Yii::app()->request->cookies['workstage'] = new CHttpCookie('workstage', $cookie);
            }
        }

        $data=array(
            'video_id'=>Yii::app()->request->getQuery('video_id'),
            'video_title'=>Yii::app()->request->getQuery('video_title'),
            'session_id'=>$session_id,
            'message'=>Yii::app()->request->getQuery('message'),
            'workstage'=>(isset($session_id) && ($cookie!=0))?($cookie + $workstage):0,
        );
        Logging::logActivity(false,7,false,$data);
        Yii::app()->end();         
    }
    
    public function actionShowChain()
    {
        $id = Yii::app()->request->getQuery('id');
        $row = Yii::app()->db->createCommand("SELECT * FROM syslog WHERE id=$id")->queryRow();
        if ($row['country']=='' || $row['country']=='UNKNOWN') {
            $location = Helper::LocateByIp( $row['client_ip'], 5);    
            $row['country'] = $location['country'];
            $row['city'] = $location['city'];
            $command = Yii::app()->db->createCommand(); //"UPDATE syslog SET country=:country, city=:city WHERE id=:id";
            $command->update('syslog', array( 'country'=> $row['country'], 'city'=>$row['city']), 'id=:id', array(':id'=>$row['id']));
        }
        ///echo "<pre>";  print_r($row); die;

        $this->renderPartial('_showChain', array(
            'row' => $row,      ///  'id' => $id,  'session_id' => $row['session_id'],
            'gridDataProvider' => $this->getGridDataProvider($row),
            'gridColumns' => $this->getGridColumns()
        ));
    }
        
    public function actionSaveComment() {
        $r = Yii::app()->getRequest();
        $name = $r->getParam('name');
        $comment = $r->getParam('value');

        // we can check whether is comming from a specific grid id too
        if($name==='comment') {     
            $id = $r->getParam('pk');
            $command = Yii::app()->db->createCommand();
            $command->update('syslog', array( 'comment'=>"$comment"), 'id=:id', array(':id'=>$id));
            Yii::app()->end();
        }
    }
    
    public function getGridDataProvider($row) {
        //echo "ID $id"; die;
        $id = $row['id'];
        $session_id = $row['session_id'];///Yii::app()->db->createCommand("SELECT session_id FROM syslog WHERE id=$id")->queryScalar();
        
        if (!empty($session_id)) {
            $condition = "session_id = '$session_id'";
        } else {
            $condition = "t1.id = $id";
        }
            
        $sql="
            SELECT t1.logtime, t1.message, t1.item_id, t1.client_ip, t1.country, t1.city, t1.device, t1.os, t1.browser, t1.browser_v, t2.code, t2.id, t3.email 
            FROM syslog t1
            LEFT JOIN item as t2 ON t1.item_id=t2.id 
            LEFT JOIN user as t3 ON t1.client_id=t3.id
            WHERE $condition
            ORDER BY logtime DESC
        ";      ///NO! SHOW ALL ////////////////HAVING logtime BETWEEN '2013-08-15 15:28:40' AND '2013-08-15 15:48:40'
        
        $data=Yii::app()->db->createCommand($sql)->queryAll();
        $count= count($data);
        /////$filteredData=$filtersForm->filter($data);

        ///echo "<pre>";  print_r($data); die;
        
        $dataProvider=new CArrayDataProvider( $data, array(     ///$filteredData
            'totalItemCount'=>$count,
            'sort'=>array(
            'defaultOrder'=>array('logtime'=>true),
                'attributes'=>array(
                     'logtime', 'message', 'client_ip', 'country', 'city', 'device', 'os', 'browser','browser_v', 'email', 'code',
                ),
            ),
            /*'pagination'=>array(
                'pageSize'=>20,
            ),*/
        ));
        
        return $dataProvider;
    }
    
    private function getGridColumns() {
        $columns = array(
            array(
                'name'=>'code',
                'value'=>'($data["code"]) ? $data["code"] : Yii::t("logging", "Нет данных")',
                'htmlOptions'=>array('width'=>'50px'),
            ),        
            array(
                'name'=>'email',
                'value'=>'($data["email"]) ? $data["email"] : Yii::t("logging", "Нет данных")',
                'htmlOptions'=>array('width'=>'130px'),
            ),
            array(
                'name' => 'message',
                ///'htmlOptions' => array('class'=>'tbrelational-column'),
                //'value'=> '"test-subgrid"',
                'filter' =>Logging::filterDataToArray(),
            ),        
            array(
                'name'=>'client_ip',
                'htmlOptions'=>array('width'=>'80px'),  //100
            ),
/*            array(
                'name'=>'country',
                'htmlOptions'=>array('width'=>'40px'),
            ),
            array(
                'name'=>'city',
                'htmlOptions'=>array('width'=>'60px'),
            ),*/
            array(
                'name'=>'device',
                //'filter' =>Logging::deviceToArray(),
                'htmlOptions'=>array('width'=>'60px'),    ///100
            ),                        
            array(
                'name'=>'os',
                //'filter' =>Logging::osToArray(),
                'htmlOptions'=>array('width'=>'100px'),
            ),                                
            array(
                'name'=>'browser',
                //'filter' =>Logging::browserToArray(),
                'htmlOptions'=>array('width'=>'100px'),
            ),                                
            array(
                'name'=>'browser_v',
                'htmlOptions'=>array('width'=>'50px'),  //100
            ),
            array(
                'name'=>'logtime',
                'value'=>function($data)
                {
                    return $data['logtime']!==null ? Yii::app()->dateFormatter->formatDateTime($data['logtime'],'short','short') : null;
                },
                'filter'=>false,
                'htmlOptions'=>array('width'=>'110px'),
            ),    
        );
        
        return $columns;
        
    }
        
}