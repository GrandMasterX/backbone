<?php

/**
 * This is the model class for table "languages".
 *
 * The followings are the available columns in table 'languages':
 * @property string $id
 * @property string $title
 * @property string $code
 * @property integer $weight
 */
class Language extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Languages the static model class
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
		return 'languages';
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
            array('title, code','required','on'=>'insert,update'),
            array('title', 'length', 'max'=>100),
			array('code', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, code', 'safe', 'on'=>'search'),
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
			'title' => Yii::t('languages', 'Наименование'),
			'code' => Yii::t('languages', 'Код'),
		);
	}
    
    protected function beforeSave()
    {
        if(!parent::beforeSave())
            return false;

        if($this->isNewRecord) 
            $this->created_by_id=Yii::app()->user->id;
        else
            $this->updated_by_id=Yii::app()->user->id;

        return true;
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('code',$this->code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function scopes()
    {
        return array(
            'visible'=>array(
                'condition'=>'is_blocked=0',
            ),
            'weighted'=>array(
                'order'=>'weight ASC',
            ),
        );
    }    
    
}