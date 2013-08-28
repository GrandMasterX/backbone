<?php

/**
 * This is the model class for table "clientsize".
 *
 * The followings are the available columns in table 'clientsize':
 * @property string $id
 * @property string $title
 * @property string $short_title
 * @property integer $is_locked
 * @property integer $is_blocked
 * @property string $created_by_id
 * @property string $updated_by_id
 * @property integer $weight
 * @property string video_url
 * @property string video_text
 */
class ClientSize extends CActiveRecord
{
	public $clientSizeTranslation;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Clientsize the static model class
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
		return 'clientsize';
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
			//array('title', 'required'),
			array('weight', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
			array('short_title, created_by_id, updated_by_id', 'length', 'max'=>10),
            array('video_url, video_text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, short_title, is_locked, is_blocked, created_by_id, updated_by_id, weight, video_url, video_text', 'safe', 'on'=>'search'),
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
            'translations'=>array(self::HAS_MANY,'ClientSizeTranslation','id','index'=>'language_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => Yii::t('clientSize', 'Наименование'),
			'short_title' => Yii::t('clientSize', 'Аббревиатура'),
            'video_url' => Yii::t('clientSize', 'Ссылка или код видео'),
            'video_text' => Yii::t('clientSize', 'Подпись видео'),
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
        if (!empty($this->clientSizeTranslation))
        {
            foreach($this->translations as $language_id=>$translation)
            {
                $translation->id=$this->id;
                $translation->language_id=$language_id;
                $translation->title=$this->clientSizeTranslation[$language_id]['title'];
                $translation->short_title=$this->clientSizeTranslation[$language_id]['short_title'];
                $translation->video_url=$this->clientSizeTranslation[$language_id]['video_url'];
                $translation->video_text=$this->clientSizeTranslation[$language_id]['video_text'];
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
            'active'=>array(
                'condition'=>'is_locked=0',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('short_title',$this->short_title,true);
		$criteria->compare('is_locked',$this->is_locked);
		$criteria->compare('is_blocked',$this->is_blocked);
		$criteria->compare('created_by_id',$this->created_by_id,true);
		$criteria->compare('updated_by_id',$this->updated_by_id,true);
		$criteria->compare('weight',$this->weight);

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
                $translation=new ClientSizeTranslation('translation');
                $translation->language_id=$language->code; 
                $translation->label=$language->title; 
                $trArray[$language->code]=$translation;
            }                    
            else
            {
                $translation=new ClientSizeTranslation();
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