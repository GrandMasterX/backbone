<?php

/**
 * This is the model class for table "item_image_import".
 *
 * The followings are the available columns in table 'item_image_import':
 * @property string $id
 * @property string $item_id
 * @property string $path
 */
class ItemImageImport extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ItemImageImport the static model class
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
		return 'item_image_import';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, path', 'required'),
			array('item_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item_id, path', 'safe', 'on'=>'search'),
		);
	}
}