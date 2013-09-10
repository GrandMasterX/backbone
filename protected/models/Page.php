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
            'type'=>Yii::t('page','Тип контента'),
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
            array('name,info,body,weight,type,pages_id', 'safe', 'on' => 'search,insert,update'),
        );
        //$charset = Yii::app()->charset;
    }

    public static function getSteps() {
        $connection=Yii::app()->db;
        $sql = 'SELECT * FROM page where type='."'steps'".' order by weight ASC';
        return $connection->createCommand($sql)->queryAll();
    }

    public static function getSlider() {
        $connection=Yii::app()->db;
        $sql = 'SELECT * FROM page where type='."'slider'".' order by weight ASC';
        return $connection->createCommand($sql)->queryAll();
    }

    public static function getService() {
        $connection=Yii::app()->db;
        $sql = 'SELECT * FROM page where type='."'service'".' order by weight ASC';
        return $connection->createCommand($sql)->queryAll();
    }

    public static function getHowitworks() {
        $connection=Yii::app()->db;
        $sql = 'SELECT * FROM page where type='."'howitworks'".' order by weight ASC';
        return $connection->createCommand($sql)->queryAll();
    }

    public static function getPartners() {
        $connection=Yii::app()->db;
        $sql = 'SELECT * FROM page where type='."'partners'".' order by weight ASC';
        return $connection->createCommand($sql)->queryAll();
    }

    public static function getContacts() {
        $connection=Yii::app()->db;
        $sql = 'SELECT * FROM page where type='."'contacts'".' order by weight ASC';
        return $connection->createCommand($sql)->queryAll();
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
