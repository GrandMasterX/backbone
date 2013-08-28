<?php

/**
 * This is the model class for table "item_translation".
 *
 * The followings are the available columns in table 'item_translation':
 * @property string $id
 * @property string $language_id
 * @property string $title
 * @property string $desc
 */
class ItemTranslation extends CActiveRecord
{
     public $label;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ItemTranslation the static model class
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
		return 'item_translation';
	}
        
        public function scopes() {
            return array(
                'byLanguage' => array(
                    'condition' => 'language_id='.'"'.Yii::app()->language.'"'
,
                )
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
			array('title', 'required', 'on'=>'translation'),
            array('title, desc', 'safe'),
			array('id,language_id', 'length', 'max'=>10),
			array('title', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, language_id, title, material', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'language_id' => 'Language',
			'title' => Yii::t('item', 'Наименование'),
			'desc' => Yii::t('item', 'Состав'),
		);
	}

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
		$criteria->compare('language_id',$this->language_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('material',$this->material,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function GetListOfItemsWithNoId() {
            $arrayOfModels = array();
            $criteria = new CDbCriteria;
            $items = self::model()->byLanguage()->findAll();
            
            return Html::makeTreeDataFromArray($items, 'id', 'title');
        }
}