<?php

/**
 * This is the model class for table "resformulatitle".
 *
 * The followings are the available columns in table 'resformulatitle':
 * @property string $id
 * @property integer $is_locked
 * @property integer $is_blocked
 * @property string $created_by_id
 * @property string $updated_by_id
 * @property integer $weight
 * @property string $create_time
 * @property string $update_time
 * @property string $range 
 *
 * The followings are the available model relations:
 * @property ResformulatitleTranslation[] $resformulatitleTranslations
 */
class ResFormulaTitle extends CActiveRecord
{
	public $title;
    public $resFormulaTitleTranslation;
    /**
    * When this array is changed, the same one should also be changed in components/Evaluate.php
    * @var mixed
    */
    public $rangeList=array(
        '1'=>'CТ',
        '2'=>'CГ',
        '3'=>'CБ',
        '4'=>'ОП',
        '5'=>'ШГ',
        '6'=>'РП',        
    );
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResFormulaTitle the static model class
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
		return 'resformulatitle';
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
		// will receive user inputs.
		return array(
			array('is_locked, is_blocked, weight', 'numerical', 'integerOnly'=>true),
			array('created_by_id, updated_by_id', 'length', 'max'=>10),
			array('create_time, update_time, range', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, is_locked, is_blocked, created_by_id, updated_by_id, weight, create_time, update_time', 'safe', 'on'=>'search'),
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
            'translations'=>array(self::HAS_MANY,'ResFormulaTitleTranslation','id','index'=>'language_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            //'title' => Yii::t('resFormulaTitle', 'Наименование'),
            'user_title'  => Yii::t('resFormulaTitle', 'Наименование для пользователей'),  
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
    
    protected function afterSave()
    {
        if (!empty($this->resFormulaTitleTranslation))
        {
            foreach($this->translations as $language_id=>$translation)
            {
                $translation->id=$this->id;
                $translation->language_id=$language_id;
                $translation->title=$this->resFormulaTitleTranslation[$language_id]['title'];
                $translation->user_title=$this->resFormulaTitleTranslation[$language_id]['user_title'];
                $translation->save();
            }
        }
    }    
    
    public function scopes()
    {
        return array(
            'visible'=>array(
                'condition'=>'is_blocked=0',
            ),
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
		$criteria->compare('is_locked',$this->is_locked);
		$criteria->compare('is_blocked',$this->is_blocked);
		$criteria->compare('created_by_id',$this->created_by_id,true);
		$criteria->compare('updated_by_id',$this->updated_by_id,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function prepareTranslations()
    {
        $trArray=array();
        $languages = Language::model()->visible()->findAll();
        foreach($languages as $language)
        {
            if ($language->code==Yii::app()->user->language)
            {
                $translation=new ResFormulaTitleTranslation('translation');
                $translation->language_id=$language->code; 
                $translation->label=$language->title; 
                $trArray[$language->code]=$translation;
            }                    
            else
            {
                $translation=new ResFormulaTitleTranslation();
                $translation->language_id=$language->code; 
                $translation->label=$language->title; 
                $trArray[$language->code]=$translation;           
            }

            if(count(($this->translations)>0)) {
                foreach($this->translations as $language_id=>$translation)
                {
                    if($language_id==$language->code)
                    {
                        $translation->language_id=$language->code; 
                        $translation->label=$language->title;
                        
                        if ($language->code==Yii::app()->user->language)
                            $translation->scenario='translation';

                        $trArray[$language->code]=$translation;                            
                    }    
                }
            }

        }
        $this->translations=$trArray;
    }    
    
}