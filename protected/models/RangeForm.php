<?php
  class RangeForm extends CFormModel
  {
      public $key;
      public $title;
      public $min;
      public $minr;
      public $maxr;
      public $max;
      public $type_id;//used to store type_id of ItemType having the range
  
    public function rules()
    {
        return array(
            array('title,min','required','on'=>'insert,update'),
            array('title', 'length', 'max'=>3), 
            array('key,min,mid,max','numerical', 'integerOnly'=>true),
            array('minr, maxr, max', 'safe'),
            array('title,min,mid,max', 'safe', 'on'=>'search'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'title'=>Yii::t('range','Назв.'),
            'min'=>Yii::t('range','от'),
            'mid'=>Yii::t('range','сред.'),
            'max'=>Yii::t('range','макс.'),
        );
    }
  }
?>
