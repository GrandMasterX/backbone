<?php

/**
 * This is the model class for table "log".
 *
 * The followings are the available columns in table 'log':
 * @property string $id
 * @property string $client_id
 * @property string $item_id
 * @property string $create_time
 * @property string $action
 * @property string $video_id
 * @property string $video_title
 * @property string $session_id
 * @property string client_ip
 * @property string device
 * @property string os
 * @property string browser
 * @property string browser_v
 * @property string email
 */
 
class Logging extends CActiveRecord
{
	const REGISTER = 1;
    const REGISTRATION_FAILED = 2;
    const LOGIN = 3;
    const LOGIN_FAILED = 4;
    const FIT = 5;
    const SIZE_REQUEST = 6;//additional size request
    const REGISTRATION_STEPS = 7;//every registration step
    const PASS_RECOVERY_REQUEST_SUCCESS = 8;
    const PASS_RECOVERY_REQUEST_ERROR = 9;
    const PASS_RECOVERY_REQUEST_WRONG_EMAIL = 10;    
    const PASS_RECOVERY_SUCCESS = 11;
    const PASS_RECOVERY_ERROR = 12;
    const PASS_RECOVERY_WRONG_EMAIL = 13;
    const FIT_FROM_EMAIL = 14; //подбор размеров переход с email
    const SUITABLE_ITEMS_PAGE = 15;        
    const FIT_FROM_EMAIL_BY_CLICK_ON_IMAGE = 16; //подбор размеров переход с email по клику на фото изделий, который подобраны по размеру
    const UNSUBSCRIBE = 17;
    const SUBSCRIBE = 18;
    const BUY = 19;
    const MY_CABINET = 20;//вход в кабинет
    const IDEAL_SIZE = 21;//идеальный размер
    public $client_search;
    public $clientByEmail_search;
    public $item_code_search;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Logging the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'syslog';
	}
    
    public function behaviors()
    {
        return array(
            'zii.behaviors.CTimestampBehavior',
        );
    }    

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_id, item_id, message, logtime', 'required'),   /// action, create_time
			array('client_id, item_id', 'length', 'max'=>11),
            array('video_id, video_title, session_id, comment, client_ip, country, city, device, os, browser, browser_v,email,error', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, client_id, item_id, message, logtime, client_search, comment, item_code_search, clientByEmail_search, os, error,device', 'safe', 'on'=>'search'),   ///email,
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
        return array(
            'client'=>array(self::BELONGS_TO,'User', 'client_id'),
            ///'clientByEmail'=>array(self::BELONGS_TO,'User', 'email'),
            'item'=>array(self::BELONGS_TO,'Item', 'item_id'),
            ///'item' => array(self::BELONGS_TO,'Item','','on'=>'t.item_id=item.id'),
            //////'as' => array(self::HAS_ONE,'authassignment','','on'=>'t.id=as.userid'),
            
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'code' => Yii::t('Logging', 'Код'),
			'client_id' => Yii::t('Logging', 'Клиент'),
			'item_id' => Yii::t('Logging', 'Изделие'),
            'level' => Yii::t('Logging', 'Уровень'),
			'message' => Yii::t('Logging', 'Действие'),     ///action
            'logtime' => Yii::t('Logging', 'Дата'),   //create_time
            'video_id' => Yii::t('Logging', 'id видео'),
            'video_title' => Yii::t('Logging', 'Название видео'),
            'comment' => Yii::t('Logging', 'Комментарий'),
            'client_ip' => Yii::t('Logging', 'IP адрес'),
            'country' => Yii::t('Logging', 'Страна'),
            'city' => Yii::t('Logging', 'Город'),
            'device' => Yii::t('Logging', 'Устройство'),
            'os' => Yii::t('Logging', 'ОС'),
            'browser' => Yii::t('Logging', 'Браузер'),
            'browser_v' => Yii::t('Logging', 'Версия браузера'),
            'client_search'=>Yii::t('Logging', 'Email клиента'),
            'clientByEmail_search'=>Yii::t('Logging', 'Email клиента'),
            'item_code_search'=>Yii::t('Logging', 'Код изделия'),
		);
	}
    
//    protected function beforeSave()
//    {
//        if(!parent::beforeSave())
//            return false;
//        return true;
//    }    

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('client_id',$this->client_id,true);
        $criteria->compare('client_ip',$this->client_ip,true);
        $criteria->compare('country',$this->country,true);
        $criteria->compare('city',$this->city,true);
		$criteria->compare('item_id',$this->item_id,true);
        $criteria->compare('device',$this->device,true);
		$criteria->compare('message',$this->message,true);
        $criteria->compare('logtime',$this->logtime,true);
        $criteria->compare('os',$this->os,true);
        $criteria->compare('browser',$this->browser,true);
        $criteria->compare('browser_v',$this->browser_v,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'client_search'=>array(
                        'asc'=>'client.email',
                        'desc'=>'client.email DESC',
                    ),
                    '*',
                ),
            ),            
		));
	}
    
    public static function logActivity($model=false, $type=1, $item_id=false, $data=array()) {
        
        $logging = new stdClass();
        
        $detect = new Mobile_Detect;        //check device type
        if($detect->isMobile()) {
            $logging->device=($detect->isTablet()) ? 'tablet' : 'phone';        //check OS
            
            if($detect->isAndroidOS())   $logging->os='AndroidOS';
            elseIf($detect->isiOS())     $logging->os='iOS';
            elseIf($detect->isWindowsMobileOS()) $logging->os='WindowsMobileOS';                
            elseIf($detect->isWindowsMobileOS()) $logging->os='WindowsPhoneOS';                                
            elseIf($detect->isMeeGoOS()) $logging->os='MeeGoOS';
            else   $logging->os='Not detected';

            //check browser
            if($detect->isChrome())      $logging->browser='Chrome';
            elseIf($detect->isSafari())  $logging->browser='Safari';
            elseIf($detect->isIE())      $logging->browser='IE';
            elseIf($detect->isFirefox()) $logging->browser='Firefox';
            elseIf($detect->isOpera())   $logging->browser='Opera';                
            else   $logging->browser='Not detected';        
        } else {//this is a computer
            $browser=Helper::getBrowser();
            $logging->browser=$browser['name'];
            $logging->browser_v=$browser['version'];
            
            $logging->os=Helper::getOS();
            $logging->device='computer';
        }
        
        if($model) {$logging->client_id=$model->id;}
        if($item_id) {$logging->item_id=$item_id;}
            
        $logging->client_ip=Helper::getClientIP();
        $location = Helper::LocateByIp( $logging->client_ip );
        $logging->country = $location['country'];
        $logging->city = $location['city'];
        
        switch ($type) {
            case self::REGISTER:
                $logging->action=Yii::t('logging', 'Регистрация успешна');
                $logging->session_id=$data['session_id'];
                $logging->email=$data['email'];
                $logging->workstage= (isset(Yii::app()->request->cookies['workstage']->value)) ? (Yii::app()->request->cookies['workstage']->value + 9): 0;
                break;
            case self::REGISTRATION_STEPS:
                $logging->action=($data['message']=='null') ? Yii::t('logging','Этап регистрации') : $data['message'];
                $logging->video_id=$data['video_id'];
                $logging->video_title=$data['video_title'];
                $logging->session_id=$data['session_id'];
                $logging->email=(isset($data['email']) && !empty($data['email']))? $data['email'] : '';
                $logging->workstage= isset($data['workstage'])? $data['workstage'] : 0;
                break;                
            case self::REGISTRATION_FAILED:
                $logging->action=Yii::t('logging', 'Неудачная регистрация');
                break;                
            case self::LOGIN:
                $logging->action=Yii::t('logging', 'Авторизация');
                $logging->email=$data['email'];
                break;
            case self::LOGIN_FAILED:
                $logging->action=Yii::t('logging', 'Неудачная авторизация');
                $logging->email=$data['email'];
                break;                
            case self::FIT:
                $logging->action=Yii::t('logging', 'Подбор размеров');
                $logging->email = @$data['email'];
                break;
            case self::SIZE_REQUEST:
                $logging->action=Yii::t('logging', 'Отбор дополнительных размеров');
                $logging->email = @$data['email'];
                break;                
            case self::PASS_RECOVERY_REQUEST_SUCCESS:
                $logging->action=Yii::t('logging', 'Запрос на восстановление пароля  - email отправлен успешно');
                $logging->email=$data['email'];
                break;
            case self::PASS_RECOVERY_REQUEST_ERROR:
                $logging->action=Yii::t('logging', 'Запрос на восстановление пароля - ошибка при отправке email');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::PASS_RECOVERY_REQUEST_WRONG_EMAIL:
                $logging->action=Yii::t('logging', 'Запрос на восстановление пароля - некорректный email');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;                
            case self::PASS_RECOVERY_SUCCESS:
                $logging->action=Yii::t('logging', 'Восстановление пароля - успешное');
                $logging->email=$data['email'];
                break; 
            case self::PASS_RECOVERY_ERROR:
                $logging->action=Yii::t('logging', 'Восстановление пароля - ошибка');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::PASS_RECOVERY_WRONG_EMAIL:
                $logging->action=Yii::t('logging', 'Восстановление пароля - некорректный email');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::FIT_FROM_EMAIL:
                $logging->action=Yii::t('logging', 'Подбор размеров -  Вы интересовались вот этим платьем');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::SUITABLE_ITEMS_PAGE:
                $logging->action=Yii::t('logging', 'Клик на массовый подбор');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::FIT_FROM_EMAIL_BY_CLICK_ON_IMAGE:
                $logging->action=Yii::t('logging', 'Клик на фото изделия подобранного по размеру');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::UNSUBSCRIBE:
                $logging->action=Yii::t('logging', 'Пользователь отписался от рассылки');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;                
            case self::SUBSCRIBE:
                $logging->action=Yii::t('logging', 'Пользователь подписался на рассылку');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::BUY:
                $logging->action=Yii::t('logging', 'Нажата кнопка купить');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::MY_CABINET:
                $logging->action=Yii::t('logging', 'Вход в личный кабинет');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::IDEAL_SIZE:
                $logging->action=Yii::t('logging', 'Нажата кнопка "Идеальный размер"');
                $logging->email=$data['email'];
                //$logging->error=$model->getError('email');
                break;
        }        
       
       $level = self::getlogLevel($type);
       $category = self::getlogCategory($type);

       SysLogger::log( $logging->action, $level, $category, (array)$logging );     /// return $logging->save(false);
       //SysLogger::getLogger()->flush(true);               /// Yii::getLogger()->flush(true);
    }

    public static function getlogCategory($type) {
       $category = "user";

       if (in_array( $type, array( self::REGISTER, self::REGISTRATION_STEPS, self::REGISTRATION_FAILED) )) {
           $category = "register.$category";
       } elseif (in_array( $type, array( self::LOGIN, self::LOGIN_FAILED) )) {
           $category = "login.$category";
       } elseif (in_array( $type, array( self::PASS_RECOVERY_REQUEST_SUCCESS, self::PASS_RECOVERY_REQUEST_ERROR, self::PASS_RECOVERY_REQUEST_WRONG_EMAIL) )) {
           $category = "request.pass_recovery.$category";
       } elseif(in_array( $type, array( self::PASS_RECOVERY_SUCCESS, self::PASS_RECOVERY_ERROR, self::PASS_RECOVERY_WRONG_EMAIL) )) {
           $category = "pass_recovery.$category";
       } elseif(in_array( $type, array( self::FIT, self::SIZE_REQUEST) )) {
           $category = "fit.$category";
       } elseif(in_array( $type, array( self::FIT, self::IDEAL_SIZE) )) {
           $category = "ideal_size.fit.$category";
       } elseif(in_array( $type, array( self::FIT_FROM_EMAIL, self::FIT_FROM_EMAIL_BY_CLICK_ON_IMAGE) )) {
           $category = "email.fit.$category";
       } elseif(in_array( $type, array( self::SUBSCRIBE, self::UNSUBSCRIBE) )) {
           $category = "subscribe.$category";
       } elseif($type==self::SUITABLE_ITEMS_PAGE) {
           $category = "suitable_items.$category";
       } elseif($type==self::BUY) {
           $category = "buy.$category";
       } elseif($type==self::MY_CABINET) {
           $category = "cabinet.$category";
       }

       return $category;
    }

    public static function getlogLevel($type) {
       $level = 'info';
       if(in_array( $type, array( self::REGISTRATION_FAILED, self::LOGIN_FAILED, self::PASS_RECOVERY_REQUEST_ERROR, self::PASS_RECOVERY_ERROR) )) {
           $level = 'warning';
       }
       return $level;
    }

    //logging
    public static function _old_logActivity($model=false, $type=1, $item_id=false, $data=array()) {

        //loging process
        $logging=new Logging;

        $detect = new Mobile_Detect; 
        //check device type
        
        if($detect->isMobile()) {
            $logging->device=($detect->isTablet()) ? 'tablet' : 'phone';
            //check OS
            if($detect->isAndroidOS()) 
                $logging->os='AndroidOS';
            elseIf($detect->isiOS())
                $logging->os='iOS';
            elseIf($detect->isWindowsMobileOS())
                $logging->os='isWindowsMobileOS';                
            elseIf($detect->isWindowsMobileOS())
                $logging->os='isWindowsPhoneOS';                                
            elseIf($detect->isMeeGoOS())
                $logging->os='isMeeGoOS';
            else 
                $logging->os='Not detected';                                

            //check browser
            if($detect->isChrome())
                $logging->browser='Chrome';
            elseIf($detect->isSafari())
                $logging->browser='isSafari';
            elseIf($detect->isIE())
                $logging->browser='IE';
            elseIf($detect->isFirefox())
                $logging->browser='isFirefox';
            elseIf($detect->isOpera())
                $logging->browser='isOpera';                
            else
                $logging->browser='Not detected';
        } 
        else 
        {//this is a computer
            $browser=Helper::getBrowser();
            $logging->browser=$browser['name'];
            $logging->browser_v=$browser['version'];
            
            $logging->os=Helper::getOS();
            $logging->device='computer';
        }
        
        if($model)
            $logging->client_id=$model->id;    

        if($item_id) 
            $logging->item_id=$item_id;    
            
        $logging->client_ip=Helper::getClientIP();
        $location = Helper::LocateByIp( $logging->client_ip );
        $logging->country = $location['country'];
        $logging->city = $location['city'];
        
        switch ($type) {
            case self::REGISTER:
                $logging->action=Yii::t('logging', 'Регистрация');
                $logging->session_id=$data['session_id'];
                $logging->email=$data['email'];
                break;
            case self::REGISTRATION_STEPS:
                $logging->action=($data['message']=='null') ? Yii::t('logging','Этап регистрации') : $data['message'];
                $logging->video_id=$data['video_id'];
                $logging->video_title=$data['video_title'];
                $logging->session_id=$data['session_id'];
                $logging->email=(isset($data['email']) && !empty($data['email']))? $data['email'] : '';
                break;                
            case self::REGISTRATION_FAILED:
                $logging->action=Yii::t('logging', 'Неудачная регистрация');
                break;                
            case self::LOGIN:
                $logging->action=Yii::t('logging', 'Авторизация');
                $logging->email=$data['email'];
                break;
            case self::LOGIN_FAILED:
                $logging->action=Yii::t('logging', 'Неудачная авторизация');
                $logging->email=$data['email'];
                break;                
            case self::FIT:
                $logging->action=Yii::t('logging', 'Подбор размеров');
                break;
            case self::SIZE_REQUEST:
                $logging->action=Yii::t('logging', 'Отбор дополнительных размеров');
                break;                
            case self::PASS_RECOVERY_REQUEST_SUCCESS:
                $logging->action=Yii::t('logging', 'Запрос на восстановление пароля  - email отправлен успешно');
                $logging->email=$data['email'];
                break;
            case self::PASS_RECOVERY_REQUEST_ERROR:
                $logging->action=Yii::t('logging', 'Запрос на восстановление пароля - ошибка при отправке email');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::PASS_RECOVERY_REQUEST_WRONG_EMAIL:
                $logging->action=Yii::t('logging', 'Запрос на восстановление пароля - некорректный email');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;                
            case self::PASS_RECOVERY_SUCCESS:
                $logging->action=Yii::t('logging', 'Восстановление пароля - успешное');
                $logging->email=$data['email'];
                break; 
            case self::PASS_RECOVERY_ERROR:
                $logging->action=Yii::t('logging', 'Восстановление пароля - ошибка');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::PASS_RECOVERY_WRONG_EMAIL:
                $logging->action=Yii::t('logging', 'Восстановление пароля - некорректный email');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::FIT_FROM_EMAIL:
                $logging->action=Yii::t('logging', 'Подбор размеров -  Вы интересовались вот этим платьем');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::SUITABLE_ITEMS_PAGE:
                $logging->action=Yii::t('logging', 'Клик на массовый подбор');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::FIT_FROM_EMAIL_BY_CLICK_ON_IMAGE:
                $logging->action=Yii::t('logging', 'Клик на фото изделия подобранного по размеру');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::UNSUBSCRIBE:
                $logging->action=Yii::t('logging', 'Пользователь отписался от рассылки');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;                
            case self::SUBSCRIBE:
                $logging->action=Yii::t('logging', 'Пользователь подписался на рассылку');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::BUY:
                $logging->action=Yii::t('logging', 'Нажата кнопка купить');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
            case self::MY_CABINET:
                $logging->action=Yii::t('logging', 'Вход в личный кабинет');
                $logging->email=$data['email'];
                $logging->error=$model->getError('email');
                break;
        }        
        
        return $logging->save(false);            
    }
    
    public static function filterDataToArray($level = 0)
    {
        $sql="SELECT message FROM syslog";      ///'SELECT action FROM log';
        if ($level) {$sql.=" WHERE level='$level'";}
        $data=Yii::app()->db->createCommand($sql)->queryAll();        
        
        $list=array();
        foreach($data as $item)
        {
            $list[$item['message']]=$item['message'];
        }
        return array_unique($list);        
    }

    public static function osToArray()
    {
        $list=array();
        $models=Logging::model()->findAll();
        foreach($models as $model)
        {
            $list[$model->os]=$model->os;
        }
        return array_unique($list);        
    }     
    
    public static function browserToArray()
    {
        $list=array();
        $models=Logging::model()->findAll();
        foreach($models as $model)
        {
            $list[$model->browser]=$model->browser;
        }
        return array_unique($list);        
    }
    
    public static function actionToArray()
    {
        $list=array();
        $models=Logging::model()->findAll();
        foreach($models as $model)
        {
            $list[$model->action]=$model->action;
        }
        return array_unique($list);        
    }
    
    public static function deviceToArray()
    {
        $list=array();
        $models=Logging::model()->findAll();
        foreach($models as $model)
        {
            $list[$model->device]=$model->device;
        }
        return array_unique($list);        
    }              
    
}