<?php

/**
 * This is the model class for table "item_image".
 *
 * The followings are the available columns in table 'item_image':
 * @property string $id
 * @property string $item_id
 * @property integer $main
 * @property string $ext
 * @property integer $weight
 */
class ItemImage extends CActiveRecord
{
    
    const GALLERY_IMAGES_THUMB_DIR      = 'uploads/custom/item/galleryImages/thumbs';
    const THUMB_WIDTH                   = 215;
    const THUMB_SMALL                   ='small_';
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ItemImage the static model class
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
		return 'item_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('main', 'numerical', 'integerOnly'=>true),
			array('item_id', 'length', 'max'=>10),
            array('weight,name,belongs,thumbnail', 'safe'),
			array('ext', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item_id, main, ext', 'safe', 'on'=>'search'),
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
			'item_id' => 'Item',
			'main' => 'Main',
			'ext' => 'Ext',
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
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('main',$this->main);
		$criteria->compare('ext',$this->ext,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getFile()
    {
        //$path=substr(Yii::getPathOfAlias('webroot'), 0, -10);
        //return 'http://www.astrafit.com.ua/'.Item::GALLERY_IMAGES_DIR."/{$this->item_id}/{$this->name}";
        $baseDir=pathinfo(Yii::app()->request->scriptFile);
        $baseDir=substr($baseDir['dirname'],0,-9);
        return $baseDir.Item::GALLERY_IMAGES_DIR."/{$this->item_id}/{$this->name}";
    }
    
    public function getPathForThumb($type=null)
    {
        //$path=substr(Yii::getPathOfAlias('webroot'), 0, -10);
        //return 'http://www.astrafit.com.ua/'.Item::GALLERY_IMAGES_DIR."/{$this->item_id}/{$type}{$this->name}";
        $baseDir=pathinfo(Yii::app()->request->scriptFile);
        $baseDir=substr($baseDir['dirname'],0,-9);
        return $baseDir.Item::GALLERY_IMAGES_DIR."/{$this->item_id}/{$type}{$this->name}";
    }    
        
}