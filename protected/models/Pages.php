<?php
class Pages extends CActiveRecord {

    public  $name;
    public  $is_blocked;
    public  $info;
    public  $weight;


    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'pages';
    }

    public function behaviors() {
        return array(
            'zii.behaviors.CTimestampBehavior',
        );
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('pages', 'Имя'),
            'info' => Yii::t('pages', 'Информация'),
            'weight' => Yii::t('pages', 'Позиция'),
        );
    }

    public function scopes() {
        return array(
            'notBlocked' => array(
                'condition' => 'is_blocked=0',
            ),
        );
    }

    public static function getPages() {
        $connection=Yii::app()->db;
        $sql = 'SELECT * FROM pages';
        return $connection->createCommand($sql)->queryAll();
    }

    public function rules() {
        return array(
            array('name', 'required', 'on' => 'insert,update'),
            array('info', 'required', 'on' => 'insert,update'),
            array('name,info,weight', 'safe', 'on' => 'search,insert,update'),
        );
        //$charset = Yii::app()->charset;
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


}
