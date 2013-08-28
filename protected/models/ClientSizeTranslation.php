<?php

/**
 * This is the model class for table "clientsize_translation".
 *
 * The followings are the available columns in table 'clientsize_translation':
 * @property string $id
 * @property string $language_id
 * @property string $title
 * @property string $short_title
 * @property string video_url
 * @property string video_text
 *
 * The followings are the available model relations:
 * @property Clientsize $id0
 */
class ClientSizeTranslation extends CActiveRecord
{
	public $label;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ClientsizeTranslation the static model class
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
		return 'clientsize_translation';
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
			array('id, language_id, short_title', 'length', 'max'=>10),
			array('title', 'length', 'max'=>255),
            array('video_url, video_text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, language_id, title, short_title, video_url, video_text', 'safe', 'on'=>'search'),
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
			'id0' => array(self::BELONGS_TO, 'Clientsize', 'id'),
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
            'title' => Yii::t('clientSize', 'Наименование'),
			'short_title' => Yii::t('clientSize', 'Аббревиатура'),
            'video_url' => Yii::t('clientSize', 'Код видео'),
            'video_text' => Yii::t('clientSize', 'Подпись видео'),            
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
		$criteria->compare('short_title',$this->short_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}