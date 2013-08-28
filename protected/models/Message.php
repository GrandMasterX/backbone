<?php

/**
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property integer $id
 * @property string $language
 * @property string $translation
 *
 * The followings are the available model relations:
 * @property Sourcemessage $id0
 */
class Message extends CActiveRecord
{
    public $category;
	public $message;
    
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Message the static model class
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
		return 'message';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('translation', 'required', 'on'=>'insert, update'),
			array('language', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, language, translation', 'safe', 'on'=>'search'),
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
			'sourceMessage' => array(self::BELONGS_TO, 'SourceMessage', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'language' => Yii::t('message', 'Язык'),
			'translation' => Yii::t('message', 'Перевод'),
            'category' => Yii::t('message', 'Категория'),
            'message' => Yii::t('message', 'Текст оригинала'),
		);
	}

    /**
    * Populates category and message properties with corresponding values from SourceMessage model.
    * @property message and @property category are displayed in create/update form as desabled
    */

    public function populateData()
    {
        $sourceMessage = $this->loadSourceMessage();
        $this->category = $sourceMessage->category;
        $this->message = $sourceMessage->message;        
        $this->language = Yii::app()->request->getQuery('language');
        
        if($this->isNewRecord)
            $this->id = Yii::app()->request->getQuery('id');        
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

		$criteria->compare('id',$this->id);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('translation',$this->translation,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    protected function loadSourceMessage()
    {
        if (is_null(Yii::app()->request->getQuery('id')))
            throw new CHttpException(404, Yii::t('error', 'Страница не найдена'));  
            
        $sourceMessage = SourceMessage::model()->findByPk(array('id'=>':id', ':id'=>Yii::app()->request->getQuery('id')));
        
        if($sourceMessage===null)
            throw new CHttpException(404, Yii::t('error', 'Страница не найдена'));
        
        return $sourceMessage;    
    }
}