<?php
class Joinus extends CActiveRecord {

    public  $_id;
    public  $name;
    public  $company;
    public  $url;
    public  $phone;
    public  $email;
    public  $text;



    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'join_us';
    }

    public function behaviors() {
        return array(
            'zii.behaviors.CTimestampBehavior',
        );
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('page', 'Ваше имя'),
            'company' => Yii::t('page', 'Название компании'),
            'url' => Yii::t('page', 'Ссылка на сайт магазина'),
            'phone' => Yii::t('page', 'Телефон для обратной связи'),
            'email'=> Yii::t('page', 'Емейл'),
            'text'=>Yii::t('page', 'Коментарии'),
        );
    }

    public function scopes() {
        return array(
            'notBlocked' => array(
                'condition' => 'is_blocked=0',
            ),
        );
    }

    public function getPages() {
        return self::model()->findAll();
    }

    public function rules() {
        return array(
            array('name', 'required', 'on' => 'insert,update'),
            array('company', 'required', 'on' => 'insert,update'),
            array('email', 'required', 'on' => 'insert,update,know_more,magazine'),
            array('url', 'required', 'on' => 'insert,update,magazine'),
            array('name,company,url,phone,email,text', 'safe', 'on' => 'search,insert,update,know_more'),
        );
        //$charset = Yii::app()->charset;
    }

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getCompany() {
        return $this->company;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getText() {
        return $this->text;
    }

}
