<?php

/**
 * This is the model class for table "mailing_list_stat".
 *
 * The followings are the available columns in table 'mailing_list_stat':
 * @property string $id
 * @property string $mailing_list_id
 * @property string $client_id
 * @property integer $client_clicked
 * @property string $create_time
 * @property integer $status
 * @property string $created_by_id
 */
class MailingListStat extends CActiveRecord
{
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MailingListStat the static model class
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
		return 'mailing_list_stat';
	}
    
    public function behaviors() {
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
			array('mailing_list_id, client_id, create_time, created_by_id', 'required'),
			array('client_clicked, status', 'numerical', 'integerOnly'=>true),
			array('mailing_list_id, client_id', 'length', 'max'=>11),
			array('created_by_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mailing_list_id, client_id, client_clicked, create_time, status, created_by_id', 'safe', 'on'=>'search'),
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
			'mailing_list_id' => 'Mailing List',
			'client_id' => 'Client',
			'client_clicked' => 'Client Clicked',
			'create_time' => 'Create Time',
			'status' => 'Status',
			'created_by_id' => 'Created By',
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
		$criteria->compare('mailing_list_id',$this->mailing_list_id,true);
		$criteria->compare('client_id',$this->client_id,true);
		$criteria->compare('client_clicked',$this->client_clicked);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_by_id',$this->created_by_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    protected function beforeSave() {
        if (!parent::beforeSave())
            return false;

        if ($this->isNewRecord)
            $this->created_by_id = (Yii::app()->user->id) ? Yii::app()->user->id : 0;

        return true;

    }
    
}