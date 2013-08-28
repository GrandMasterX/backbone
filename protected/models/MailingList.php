<?php

/**
 * This is the model class for table "mailing_list".
 *
 * The followings are the available columns in table 'mailing_list':
 * @property string $id
 * @property string $title
 * @property string $lang
 * @property integer $is_blocked
 * @property integer $is_locked
 * @property integer $status
 * @property string $created_by_id
 * @property string $updated_by_id
 * @property integer $template_id
 * @property integer $weight
 * @property integer $sent_count
 */
class MailingList extends CActiveRecord
{
	
    public $user_count;
    public $current_sending_state;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MailingList the static model class
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
		return 'mailing_list';
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
			array('title,subject,template_id', 'required'),
			array('is_blocked, is_locked, status, weight', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>64),
			array('lang', 'length', 'max'=>2),
			array('created_by_id, updated_by_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, lang, is_blocked, is_locked, status, created_by_id, updated_by_id, template_id, weight, sent_count', 'safe', 'on'=>'search'),
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
		    'template'=>array(self::BELONGS_TO,'MailingListTemplate', 'template_id'),
            'sentCount' => array(self::STAT, 'MailingListStat', 'mailing_list_id','condition'=>'t.status=1'),
            'notSentCount' => array(self::STAT, 'MailingListStat', 'mailing_list_id','condition'=>'t.status=0'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'id' => 'ID',
            'title'=>Yii::t('mailingList','Название'),
            'user_count'=>Yii::t('mailingList','Кол. подписчиков'),
            'sent_count'=>Yii::t('mailingList','Кол.отправок'),
			//'lang' => 'Lang',
			//'is_blocked' => 'Is Blocked',
			//'is_locked' => 'Is Locked',
			'status' =>Yii::t('mailingList','Статус'),
            'current_sending_state'=>Yii::t('mailingList','Отпр./не отпр.'),
			//'created_by_id' => 'Created By',
			//'updated_by_id' => 'Updated By',
			'template_id' =>Yii::t('mailingList','Шаблон'),
            'create_time' =>Yii::t('mailingList','Дата создания'),
            'last_sent_time' =>Yii::t('mailingList','Дата последней отправки'),
            'subject'=>Yii::t('mailingList','Тема рассылки'),
			//'weight' => 'Weight',
		);
	}
    
    protected function beforeSave() {
        if (!parent::beforeSave())
            return false;

        if ($this->isNewRecord)
            $this->created_by_id = (Yii::app()->user->id) ? Yii::app()->user->id : 0;
        else {
            if (Yii::app() instanceof CWebApplication) {
                $this->updated_by_id = Yii::app()->user->id;
            }
        }
        return true;
    }    
    
    protected function afterSave()
    {
        parent::afterSave();
        
        $this->weight=$this->id;
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
		$criteria->compare('lang',$this->lang,true);
		$criteria->compare('is_blocked',$this->is_blocked);
		$criteria->compare('is_locked',$this->is_locked);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_by_id',$this->created_by_id,true);
		$criteria->compare('updated_by_id',$this->updated_by_id,true);
		$criteria->compare('template',$this->template,true);
		$criteria->compare('weight',$this->weight);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}