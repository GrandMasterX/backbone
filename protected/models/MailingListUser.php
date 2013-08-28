<?php

/**
 * This is the model class for table "mailing_list_user".
 *
 * The followings are the available columns in table 'mailing_list_user':
 * @property string $mailing_list_id
 * @property string $user_id
 */
class MailingListUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MailingListUser the static model class
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
		return 'mailing_list_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mailing_list_id, user_id', 'required'),
			array('mailing_list_id, user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mailing_list_id, user_id', 'safe', 'on'=>'search'),
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
			'mailing_list_id' => 'Mailing List',
			'user_id' => 'User',
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

		$criteria->compare('mailing_list_id',$this->mailing_list_id,true);
		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    protected function afterSave()
    {
        parent::afterSave();
        
        MailingList::model()->updateCounters(array('user_count' => 1), 'id = ?', array($this->mailing_list_id));
        
    }
    
    protected function afterDelete()
    {
        parent::afterDelete();
        
        MailingList::model()->updateCounters(array('user_count' => -1), 'id = ?', array($this->mailing_list_id));
    }        
}