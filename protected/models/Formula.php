<?php

/**
 * This is the model class for table "formula".
 *
 * The followings are the available columns in table 'formula':
 * @property string $id
 * @property string $title
 * @property string $value
 * @property string $info
 * @property integer $weight
 */
class Formula extends CActiveRecord
{
    public $rangeTitle;
    public $rangeTitleTranslationForUser;
    
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Formula the static model class
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
		return 'formula';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required', 'on'=>'formulaNormal'),
            array('weight', 'numerical', 'integerOnly'=>true),
			array('title,value', 'length', 'max'=>255),
            array('tag, fvalue', 'length', 'min'=>4, 'max'=>50),
            //array('tag','unique','on'=>'update'),   
			array('value, info', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, value, info, weight, tag', 'safe', 'on'=>'search'),
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
		    'children'=>array(self::HAS_MANY,'formula','parent'),
            'parent'=>array(self::HAS_ONE,'formula','parent'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'title' => Yii::t('formula','Наименование'),
            'tag' => Yii::t('formula','Тэг'),
            'fvalue'=> Yii::t('formula','Берет значение из:'),
			'value' => Yii::t('formula','Значение'),
			'info' => Yii::t('formula','Описание'),
		);
	}

    public function afterFind()
    {
        parent::afterFind();
        if ($this->type==2) {
            $this->rangeTitle=$this->getRangeTitle($this->title);
            $this->rangeTitleTranslationForUser=$this->getRangeTitleTranslationForUser($this->title);
        }
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
		$criteria->compare('value',$this->value,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('weight',$this->weight);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function defaultScope()
    {
        return array(
             'order'=>'weight ASC',
        );
    }
    
    public function scopes()
    {
        return array(
            'locked'=>array(
                'condition'=>'is_locked=1',
            ),            
            'unlocked'=>array(
                'condition'=>'is_locked=0',
            ),
            'weighted'=>array(
                'order'=>'weight ASC',
            ),
            'noParent'=>array(
                'condition'=>'parent IS NULL',
            ),    
        );
    }

    public static function getListOfTitles()
    {
        $arrayOfModels = array();
        $models = ResFormulaTitle::model()->visible()->findAll();
        
        foreach ($models as $model)
        {
            $model->title=$model->translations[Yii::app()->language]->title;
            $arrayOfModels[]=$model;
        }
        
        return CHtml::listData($arrayOfModels, 'id', 'title');
    }
    
    public function getRangeTitle($range_id)
    {
        $model = ResFormulaTitle::model()->findByPk(array('id'=>':id', ':id'=>$range_id));
        if($model)
            return $model->range;
    }
    
    public function getRangeTitleTranslationForUser($range_id)
    {
        $model = ResFormulaTitle::model()->findByPk(array('id'=>':id', ':id'=>$range_id));
        if($model)
            return $model->translations[Yii::app()->language]->user_title;
    }        
        
}