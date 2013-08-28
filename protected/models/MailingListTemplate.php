<?php

/**
 * This is the model class for table "mailing_list_template".
 *
 * The followings are the available columns in table 'mailing_list_template':
 * @property integer $id
 * @property string $title
 * @property string $view_file
 * @property integer $is_blocked
 * @property integer $is_locked
 */
class MailingListTemplate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MailingListTemplate the static model class
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
		return 'mailing_list_template';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, view_file', 'required'),
			array('is_blocked, is_locked', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('view_file', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, view_file, is_blocked, is_locked', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'view_file' => 'View File',
			'is_blocked' => 'Is Blocked',
			'is_locked' => 'Is Locked',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('view_file',$this->view_file,true);
		$criteria->compare('is_blocked',$this->is_blocked);
		$criteria->compare('is_locked',$this->is_locked);

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