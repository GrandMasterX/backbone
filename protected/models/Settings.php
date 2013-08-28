<?php

/**
 * This is the model class for table "settings".
 *
 * The followings are the available columns in table 'settings':
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property string $value
 * @property string $updated_by_id
 * @property string $info
 */
class Settings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Settings the static model class
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
		return 'settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, code, value, info','required','on'=>'insert,update'),
            array('title, value', 'length', 'max'=>255),
			array('code', 'length', 'max'=>32),
			array('updated_by_id', 'length', 'max'=>10),
			array('info', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, code, value, updated_by_id, info', 'safe', 'on'=>'search'),
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
			'title' => Yii::t('settings', 'Наименование'),
			'code' => Yii::t('settings', 'Код'),
			'value' => Yii::t('settings', 'Значение'),
			'updated_by_id' => Yii::t('settings', 'Дата обновления'),
			'info' => Yii::t('settings', 'Описание'),
		);
	}
    
    protected function beforeSave()
    {
        if(!parent::beforeSave())
            return false;

        if($this->isNewRecord)
        { 
            $this->created_by_id=Yii::app()->user->id;
            
            if(!Yii::app()->session['param'])
                $this->is_param = 0;
        }
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

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('updated_by_id',$this->updated_by_id,true);
		$criteria->compare('info',$this->info,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public static function getProperUrlForSettings($action)
    {   
        if(!is_null(Yii::app()->request->getQuery('param')))   
            return Yii::app()->controller->createUrl($action, array('param'=>Yii::app()->request->getQuery('param')));

            return Yii::app()->controller->createUrl($action);
    }
    
    public static function getProperUrlForSettingsUpdate($action, $id)
    {   
        if(!is_null(Yii::app()->request->getQuery('param')))   
            return Yii::app()->controller->createUrl($action, array('param'=>Yii::app()->request->getQuery('param'), 'id'=>$id));

            return Yii::app()->controller->createUrl($action, array('id'=>$id));
    }    
    
   
}