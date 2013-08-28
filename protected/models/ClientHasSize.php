<?php

/**
 * This is the model class for table "client_size".
 *
 * The followings are the available columns in table 'client_size':
 * @property string $id
 * @property string $client_id
 * @property integer $weight
 * @property integer $is_blocked
 * $var decimal $vst
 * $var decimal $vk 
 */
class ClientHasSize extends CActiveRecord
{
    public $label;
    public $video_url;
    public $video_text;
    public $old_value;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ClientHasSize the static model class
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
		return 'client_size';
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
			//array('value', 'required', 'on'=>'insert,update'),
            array('value', 'required', 'message'=>Yii::t('clientHasSize', 'Это поле обязательное'), 'on'=>'insert,update,collectSize,userSizeUpdate'),
            array('value', 'match', 'pattern'=>'/^[0-9]{1,3}(\.[0-9]{0,2})?$/', 'on'=>'insert,update,collectSize,userSizeUpdate',
                'message'=>'Значение может быть целым или десятичным числом (0.00).'),            
//            array('value', 'numerical', 'integerOnly'=>true),
            array('client_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('value', 'safe'),
            array('size_id', 'numerical', 'integerOnly'=>true, 'min'=>7, 'max'=>14),
            array('value, client_id, size_id, clientHasSizeId, weight', 'safe', 'on'=>'insert,update,collectSize,userSizeUpdate'),
            array('id, client_id, weight, is_blocked, clientHasSizeId', 'safe', 'on'=>'search'),
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
                'size'=>array(self::BELONGS_TO,'ClientSize', 'size_id'),
            );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'client_id' => 'Client',
            'size_id' => 'Size',
			'weight' => 'Weight',
            'value' => 'Value',
			'is_blocked' => 'Is Blocked',
		);
	}
    
    protected function beforeSave()
    {
        if(!parent::beforeSave())
            return false;

        // Calculate vst and vk for user height
        // id 7 stands for height
        if($this->size_id==7)
        {
            if($this->value<157)
                $this->vst=$this->value*0.87;
            elseif($this->value>=157 && $this->value<170)
                $this->vst=$this->value*0.85;
            elseif($this->value>=170)
                $this->vst=$this->value*0.86;
                
            if($this->value>=170)
                $this->vk=$this->value*0.285;
            elseif($this->value<160)
                $this->vk=$this->value*0.275;
            elseif($this->value>=160 && $this->value<170)
                $this->vk=$this->value*0.28;                
            
            //ВЗУ calculation
            if($this->value>160)
                $this->vzu=$this->value*0.75;
                
            if($this->value<=160)
                $this->vzu=$this->value*0.77; 
                
            //dts calculation
            if($this->value>160)
                $this->dts=$this->value*0.235;
                
            if($this->value<=160)
                $this->dts=$this->value*0.24;                                

            //hand length calculation
            if($this->value<=157)
                $this->dr=$this->value*0.355;
                
            if($this->value>157 && $this->value<=170)
                $this->dr=$this->value*0.365;                                
                
            if($this->value>170)
                $this->dr=$this->value*0.355;

            //vpl calculation
            if($this->value<=166)
                $this->vpl=$this->value*0.815;

            if($this->value>166)
                $this->vpl=$this->value*0.82;

            //vlok calculation
            $this->vlok=$this->dr/2-4.5;
            $this->vprch=$this->vst-$this->vzu;
            $this->drvnch=$this->dr-($this->vprch-($this->vst-$this->vpl));
        }

        //save the time of the creation
        $this->update_time=new CDbExpression('NOW()');

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
		$criteria->compare('client_id',$this->client_id,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('is_blocked',$this->is_blocked);

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
            'active'=>array(
                'condition'=>'is_locked=0',
            ),
        );
    }
}