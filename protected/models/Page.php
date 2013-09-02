<?php
class Page extends CActiveRecord {

    public  $_id;
    public  $name;
    public  $is_blocked;
    public  $info;
    public  $weight;
    public  $body;
    public  $pages_id;



    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'page';
    }

    public function behaviors() {
        return array(
            'zii.behaviors.CTimestampBehavior',
        );
    }

    public function attributeLabels() {
        return array(
            'title' => Yii::t('page', 'Имя'),
            'info' => Yii::t('page', 'Информация'),
            'body' => Yii::t('page', 'Контент'),
            'weight' => Yii::t('page', 'Позиция'),
            'pages_id'=> Yii::t('page', 'Где отображать'),
            'create_time'=>Yii::t('page', 'Дата создания'),
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
            array('title', 'required', 'on' => 'insert,update'),
            array('info', 'required', 'on' => 'insert,update'),
            //array('pages_id', 'required', 'on' => 'insert,update'),
            array('weight', 'required', 'on' => 'insert,update'),
            array('body', 'required', 'on' => 'insert,update'),
            array('name,info,body,weight', 'safe', 'on' => 'search,insert,update'),
        );
        //$charset = Yii::app()->charset;
    }

    public function getId() {
        return $this->_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getIsBlocked() {
        return $this->is_blocked;
    }

    public function getInfo() {
        return $this->info;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function getBody() {
        return $this->body;
    }

    public function getPagesId() {
        return $this->pages_id;
    }

}
