<?php

/**
 * This is the model class for table "sourcemessage".
 *
 * The followings are the available columns in table 'sourcemessage':
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * The followings are the available model relations:
 * @property Message[] $messages
 */
class SourceMessage extends CActiveRecord
{
	
    public $translation;
    public $translation_id;
    public $language;
    
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sourcemessage the static model class
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
		return 'sourceMessage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category', 'length', 'max'=>32),
            array('message', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category, message', 'safe', 'on'=>'search'),
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
			'messages' => array(self::HAS_MANY, 'Message', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category' => Yii::t('sourceMessage', 'Категория'),
			'message' => Yii::t('sourceMessage', 'Текст оригинала'),
            'translation' => Yii::t('sourceMessage', 'Перевод'),
		);
	}

    /**
    * Populates translation_id and translation properties with corresponding translations.
    * @property translation_id used to load a Message model on update in update link
    * @property translation is shown in a CGridView
    */
    
    protected function afterFind()
    {
        $translation = $this->getTranslationByLanguage();
        $this->translation_id = (!empty($translation)) ? $translation[0]->id : null;
        $this->translation = (!empty($translation)) ? $translation[0]->translation : null;
        $this->language = (!empty($translation)) ? $translation[0]->language : $this->getLanguage();
        return parent::afterFind();
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
		$criteria->compare('category',$this->category,true);
		$criteria->compare('message',$this->message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    protected function getTranslationByLanguage()
    {
        return $translation = $this->messages(array('condition'=>'id=:id AND language=:lng',
                      'params' => array(':id' => $this->id, ':lng' => "{$this->getLanguage()}")));
    }
    
    protected function getLanguage()
    {
        return (!is_null(Yii::app()->request->getQuery('languageTab'))) 
            ? Yii::app()->request->getQuery('languageTab') : Yii::app()->user->language;
    }
}