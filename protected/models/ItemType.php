<?php

/**
 * This is the model class for table "item_type".
 *
 * The followings are the available columns in table 'item_type':
 * @property string $id
 * @property string $title
 * @property string $lft
 * @property string $rgt
 * @property integer $level
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_locked
 * @property integer $is_blocked
 * @property string $created_by_id
 * @property string $updated_by_id
 * @property integer $weight
 */
class ItemType extends CActiveRecord {

    public $is_child;
    public $itemTypeTranslation;
    public $copyTranslations=array();
    public $sizeListArray;
    public $old_value;
    public $new_title=false;
    public $item_type_search;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ItemType the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'item_type';
    }

    public function behaviors() {
        return array(
            'zii.behaviors.CTimestampBehavior',
            'nestedSetBehavior' => array(
                'class' => 'ext.trees.NestedSetBehavior',
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'levelAttribute' => 'level',
                'hasManyRoots' => true,
            ),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('title', 'required', 'on'=>'insert,update'),
            array('level, is_locked', 'numerical', 'integerOnly' => true),
            array('lft, rgt, created_by_id, updated_by_id', 'length', 'max' => 10),
            array('update_time, root, is_blocked', 'safe'),
            array('typeSizeList', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, lft, rgt, level, create_time, update_time, is_locked, is_blocked, created_by_id, updated_by_id, item_type_search', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'translations' => array(self::HAS_MANY, 'ItemTypeTranslation', 'id', 'index' => 'language_id'),
            'sizeList' => array(self::MANY_MANY, 'ClientSize', 'itemtype_size(itemType_id, size_id)'),
        );
    }

    public function getTypeSizeList() {
        if ($this->sizeListArray === null)
            $this->sizeListArray = CHtml::listData($this->sizeList, 'id', 'id');
        return $this->sizeListArray;
    }

    public function setTypeSizeList($value) {
        $this->sizeListArray = $value;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'level' => Yii::t('itemType', 'Глубина вложенности'),
            'root' => Yii::t('itemType', 'Категория'),
            'title' => Yii::t('itemType', 'Наименование'),
            'item_type_search' => Yii::t('itemType', 'Наименование'),
            'create_time' => Yii::t('itemType', 'Дата создания'),
            'update_time' => Yii::t('itemType', 'Дата обновления'),
            'is_child' => Yii::t('itemType', 'Это подкатегория/модель'),
        );
    }

    protected function beforeSave() {
        if (!parent::beforeSave())
            return false;

        if ($this->isNewRecord)
            $this->created_by_id = Yii::app()->user->id;
        else
            $this->updated_by_id = Yii::app()->user->id;

        return true;
    }

    protected function afterSave() {
        parent::afterSave();
        if (!empty($this->itemTypeTranslation)) {
            foreach ($this->translations as $language_id => $translation) {
                $translation->id = $this->id;
                $translation->language_id = $language_id;
                $translation->title = $this->itemTypeTranslation[$language_id]['title'];
                $translation->save();
            }
        }

        //save translation when an itemType is copied;
        if (!empty($this->copyTranslations)) {
            foreach ($this->copyTranslations as $language_id => $translation) {
                $new_translation=new ItemTypeTranslation();
                $new_translation->id = $this->id;
                $new_translation->language_id = $language_id;
                if($this->new_title)
                {

                }
                else
                {
                    $new_translation->title = 'Copy - ' . $translation->title;
                }
                $new_translation->save(false);
            }
        }

        $this->refreshSizeList();
    }

    protected function afterFind() {
        if ($this->level > 1)
            $this->is_child = 1;
        else
            $this->is_child = null;

        return parent::afterFind();
    }

    public function scopes() {
        return array(
            'visible' => array(
                'condition' => 'is_blocked=0',
            ),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('lft', $this->lft, true);
        $criteria->compare('rgt', $this->rgt, true);
        $criteria->compare('level', $this->level);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('is_locked', $this->is_locked);
        $criteria->compare('is_blocked', $this->is_blocked);
        $criteria->compare('created_by_id', $this->created_by_id, true);
        $criteria->compare('updated_by_id', $this->updated_by_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getListOfItemType() {
        $arrayOfModels = array();
        $criteria = new CDbCriteria;
        $criteria->order = 'root, lft';
        $models = ItemType::model()->visible()->findAll($criteria);

        foreach ($models as $model) {
            $model->title = $model->translations[Yii::app()->language]->title;
            $arrayOfModels[] = $model;
        }

        return Html::listTreeData($arrayOfModels, 'id', 'title');
    }

    public function prepareTranslations() {
        $trArray = array();
        $languages = Language::model()->visible()->findAll();
        foreach ($languages as $language) {
            if ($language->code == Yii::app()->user->language) {
                $translation = new ItemTypeTranslation('translation');
                $translation->language_id = $language->code;
                $translation->label = $language->title;
                $trArray[$language->code] = $translation;
            } else {
                $translation = new ItemTypeTranslation();
                $translation->language_id = $language->code;
                $translation->label = $language->title;
                $trArray[$language->code] = $translation;
            }

            if (count(($this->translations) > 0)) {
                foreach ($this->translations as $language_id => $translation) {
                    if ($language_id == $language->code) {
                        $translation->language_id = $language->code;
                        $translation->label = $language->title;

                        if ($language->code == Yii::app()->user->language)
                            $translation->scenario = 'translation';

                        $trArray[$language->code] = $translation;
                    }
                }
            }
        }
        $this->translations = $trArray;
    }

    /**
     * Generates an array of ClientHasSize models for the current User(Client)
     * @param mixed $update populates field 'value' from table client_size. Defaults to false;
     */
    public function getListOfSizeForBinding($update = false) {
        $sizeListOfAll = ClientSize::model()->visible()->findAll();
        $listOfSizeofModels = array();
        foreach ($sizeListOfAll as $item) {
            $listOfSizeofModels[$item->id] = $item->title;
        }

        return $listOfSizeofModels;
    }

    protected function refreshSizeList() {
        ItemTypeSize::model()->deleteAllByAttributes(array('itemType_id' => $this->id));

        if (is_array($this->typeSizeList)) {
            foreach ($this->typeSizeList as $id) {
//                if (ClientSize::model()->exists('id=:id', array(':id'=>$id)))
//                {                
                $itemTypeSize = new ItemTypeSize();
                $itemTypeSize->itemType_id = $this->id;
                $itemTypeSize->size_id = $id;
                $itemTypeSize->save();
//                }
            }
        }
    }

    public static function getListOfSizeModelsByItemTypeId($sizeList) {
        $listOfSizeModels = array();
        foreach ($sizeList as $item) {
            $model = new ClientHasSize('collectSize');

            if(!Yii::app()->user->isGuest)
                $model->client_id=Yii::app()->user->id;

            (isset($item['size_id'])) 
                ? $model->size_id = $item['size_id'] 
                : $model->size_id = $item['id'];
            
            if(isset($item['title']))
                $model->label = $item['title'];

            if(isset($item['value']))
                $model->value=$item['value'];
                
            if(isset($item['weight']))
                $model->weight=$item['weight'];

            if(isset($item['video_url']))
                $model->video_url = $item['video_url'];

            if(isset($item['video_text']))
                $model->video_text = $item['video_text'];
                
            $listOfSizeModels[$item['id']]['model'] = $model;
        }
        return $listOfSizeModels;
    }

}
