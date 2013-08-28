<?php

/**
 * This is the model class for table "item".
 *
 * The followings are the available columns in table 'item':
 * @property string $id
 * @property string $title
 * @property integer $partner_id
 * @property integer $weight*
 * @property integer $type_id
 * @property integer $stretch
 * @property string $colour
 * @property string $material
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_locked
 * @property integer $is_blocked
 * @property integer price
 * @property string $created_by_id
 * @property string $updated_by_id
 * @property string $il
 * @property string $iwa
 * @property string $iww
 * @property string $iwt
 * @property string $ils
 * @property string $iws
 * @property string $iwp
 * @property string $iwss
 * @property string $iwcb
 * @property string $desc
 * @property string $code
 * @property string $vps
 * @property string $di
 * @property string $rpli
 * @property integer $parent_id
 */
class ItemSource extends CActiveRecord
{
    const       GALLERY_IMAGES_DIR = 'uploads/custom/item/galleryImages';
    const       SKIP = 0; //нет совпадения
    const       COMPARE = 1; // совойства в base и source table заполнены.
    const       NEW_DATA = 2; // свойства в base table пустые, а в source - заполнены
    const       LEFT_UNCHANGED = 3; // остались свойства из base table
    const       CHANGED_TO_SOURCE = 4; // применены свойства из source table
    public      $mainImage;
    public      $gallery;
    public      $imageUploadFile;
    public      $imageFileName;
    public      $galleryImagesList;
    public      $galleryImagesFileName;
    public      $type_search;
    public      $sizeTitleList;
    public      $itemSizeTitleList;
    public      $image;
    public      $itemTranslation;
    public      $copyTranslations=array();
    public      $new_title=false;
    protected   $photo_path_with_id;
    protected   $gallery_image_path_with_id;
    protected   $old_photo_name;
    protected   $old_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Item the static model class
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
        return 'item_source';
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
            array('stretch, type_id, partner_id, fabric_id', 'required', 'on'=>'insert,update'),
            array('partner_id, parent_id, price', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>150),
            array('colour', 'length', 'max'=>50),
            array('material', 'length', 'max'=>100),
            array('created_by_id, updated_by_id, il, iwa, iww, iwt, ils, iws, iwp, iwss, iwcb, vpr, di, rpli', 'length', 'max'=>10),
            array('mainImage', 'file', 'types'=>'jpg, gif, png', 'maxSize' => 1048576, 'allowEmpty' => true),
            array('gallery', 'application.extensions.sweekit.validators.SwFileValidator', 'maxFiles' => 10, 'allowEmpty' => true),
            array('material, price, ready, unavailable, code, old_id, stretchp, colour, bretel,comment,size_finished,fabric_type_iwa,fabric_type_iwa_stretch,fabric_type_iww,fabric_type_iww_stretch,fabric_type_iwt,fabric_type_iwt_stretch', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, partner_id, colour, price, type_search, sizeTitleList, code, unavailable', 'safe', 'on'=>'search'),
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
            'translations'=>array(self::HAS_MANY,'ItemTranslationSource','id','index'=>'language_id'),
            'mainItemImage'=>array(self::HAS_MANY,'ItemImage','item_id','on'=>'main=1','index'=>'main'),
            'galleryImages'=>array(self::HAS_MANY,'ItemImage','item_id','on'=>'main IS NULL'),
            'sizeList'=>array(self::HAS_MANY,'ItemSizeSource', 'item_id','on'=>'sizeList.is_blocked=0'),
            'sizeCount'=>array(self::STAT,'ItemSize', 'item_id','condition'=>'is_blocked=0'),
            'partner'=>array(self::BELONGS_TO,'User', 'partner_id'),
            'type'=>array(self::BELONGS_TO,'ItemType', 'type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => Yii::t('item', 'Наименование'),
            'colour' => Yii::t('item', 'Цвет'),
            'material' => Yii::t('item', 'Ткань'),
            'create_time'=>Yii::t('item','Дата создания'),
            'update_time' => Yii::t('item','Дата обновления'),
            'mainImage' => Yii::t('item','Основное фото'),
            'il' => Yii::t('item','Длина изделия по спинке (ДИ)'),
            'iwa' => Yii::t('item','Ширина на уровне глубины проймы (ШУГ)'),
            'iww' => Yii::t('item','Ширина на уровне талии (ШУТ)'),
            'iwt' => Yii::t('item','Ширина на уровне бедер (ШУБ)'),
            'ils' => Yii::t('item','Длина рукава (ДР)'),
            'iws' => Yii::t('item','Ширина рукава вверху (ШР)'),
            'iwp' => Yii::t('item','Ширина полочки в узком месте (ШГ)'),
            'iwss' => Yii::t('item','Длина бокового шва (ДБШ)'),
            'iwcb' => Yii::t('item','Длина подреза по спинке (ДТС)'),
            'stretch' => Yii::t('item','Максимальное натяжение ткани в см.'),
            'stretchp' => Yii::t('item','Максимальное растяжение подкладки в см.'),
            'fabric_id' => Yii::t('item','Тип ткани'),
            'type_id' => Yii::t('item','Тип изделия'),
            'desc' => Yii::t('item','Состав'),
            'gallery' => Yii::t('item','Галерея'),
            'partner_id' => Yii::t('item','Владелец'),
            'price' => Yii::t('item','Цена'),
            'type_search' => Yii::t('item','Тип'),
            'sizeTitleList' => Yii::t('item','Размеры'),
            'ready'=>Yii::t('item','Обработано'),
            'code'=>Yii::t('item','Код'),
            'vpr'=>Yii::t('item','Высота проймы'),
            'di'=>Yii::t('item','Длина изделия'),
            'rpli'=>Yii::t('item','Разлет плечевой изделия'),
            'image'=>Yii::t('item','Фото'),
            'unavailable'=>Yii::t('item', 'Нет в наличии'),
            'bretel'=>Yii::t('item', 'Наличие бретелей'),
            'comment'=>Yii::t('item', 'Комментарий'),
            'size_finished'=>Yii::t('item', 'Все размеры указаны'),
            'fabric_type_iwa'=>Yii::t('item', 'Тип ткани по ШУГ'),
            'fabric_type_iwa_stretch'=>Yii::t('item', 'Макс.нат ткани по ШУГ'),
            'fabric_type_iww'=>Yii::t('item', 'Тип ткани по ШУТ'),
            'fabric_type_iww_stretch'=>Yii::t('item', 'Макс.нат ткани по ШУТ'),
            'fabric_type_iwt'=>Yii::t('item', 'Тип ткани по ШУБ'),
            'fabric_type_iwt_stretch'=>Yii::t('item', 'Макс.нат ткани по ШУБ'),
        );
    }

    protected function beforeSave()
    {
        if(!parent::beforeSave())
            return false;

        if (Yii::app() instanceof CWebApplication)
        {
            if($this->isNewRecord)
                $this->created_by_id=Yii::app()->user->id;
            else
                $this->updated_by_id=Yii::app()->user->id;

            //handle single image upload
            $this->imageUploadFile = CUploadedFile::getInstance($this, 'mainImage');
            if(!is_null($this->imageUploadFile))
            {
                $this->imageFileName = mktime() . $this->imageUploadFile->name;
                $this->mainImage = $this->imageFileName;
            }
            //calculate strech for a user
            $this->stretch_percentage=($this->stretch-10)/10;

            //Вшл- высота шлейфа (автоматический расчет ДИ2-ДИ)
//                if(!empty($this->iltwo) && !empty($this->il))
//                    $this->vsl=$this->iltwo-$this->il;
        }
        //TODO: fix the big with parent nodes for item types(models)
        //$this->parent_id=self::getParentTypeId($this->type_id);
        //$this->parent_id=4;
        return true;
    }

    protected function afterSave()
    {
        parent::afterSave();
        // Handle single image upload - mainImage
        if(!is_null($this->imageUploadFile)){
            $this->photo_path_with_id = self::GALLERY_IMAGES_DIR . DIRECTORY_SEPARATOR . $this->id;
            Html::createDir($this->photo_path_with_id);
            $filename=$this->photo_path_with_id . DIRECTORY_SEPARATOR . $this->imageFileName;
            $this->imageUploadFile->saveAs($filename);

            // Create thumbnail
            $small_filename=$this->photo_path_with_id . DIRECTORY_SEPARATOR . ItemImage::THUMB_SMALL  . $this->imageFileName;
            $image=Yii::app()->image->open($filename);
            $thumbnail=$image->thumbnail(new Imagine\Image\Box(215,300));
            $thumbnail->save($small_filename);

            // Save data for item - images relation
            ItemImage::model()->updateAll(array('main'=>null,'belongs'=>null), 'item_id=:item_id AND main=:main',array(':item_id'=>$this->id, ':main'=>1));
            $galleryImage = new ItemImage();
            $galleryImage->item_id = $this->id;
            $galleryImage->name = $this->mainImage;
            $galleryImage->thumbnail=ItemImage::THUMB_SMALL  . $this->imageFileName;
            $galleryImage->main = true;
            $galleryImage->save('item_id, name');
        }

        // Handle multiple image upload
        if($this->scenario=='insert' || $this->scenario=='update')
        {
            $this->galleryImagesList = SwUploadedFile::getInstances($this, 'gallery');
            if(!empty($this->galleryImagesList)){
                $this->gallery_image_path_with_id = self::GALLERY_IMAGES_DIR . DIRECTORY_SEPARATOR . $this->id;
                foreach($this->galleryImagesList as $image) {
                    $this->galleryImagesFileName = mktime() . $image->name;

                    Html::createDir($this->gallery_image_path_with_id);
                    $filename=$this->gallery_image_path_with_id . DIRECTORY_SEPARATOR . $this->galleryImagesFileName;
                    $image->saveAs($filename);

                    // Create thumbnail
                    $small_filename=$this->gallery_image_path_with_id . DIRECTORY_SEPARATOR . ItemImage::THUMB_SMALL . $this->galleryImagesFileName;
                    $image=Yii::app()->image->open($filename);
                    $thumbnail=$image->thumbnail(new Imagine\Image\Box(215,300));
                    $thumbnail->save($small_filename);

                    // Save data for item - images relation
                    $galleryImage = new ItemImage();
                    $galleryImage->item_id = $this->id;
                    $galleryImage->name = $this->galleryImagesFileName;
                    $galleryImage->thumbnail=ItemImage::THUMB_SMALL . $this->galleryImagesFileName;
                    $galleryImage->save('item_id, name');
                }
            }
        }

        //handle translations
        if (!empty($this->itemTranslation)) {
            foreach ($this->translations as $language_id => $translation) {
                $translation->id = $this->id;
                $translation->language_id = $language_id;
                $translation->title = $this->itemTranslation[$language_id]['title'];
                $translation->desc = $this->itemTranslation[$language_id]['desc'];
                $translation->save();
            }
        }

        //save translation when an itemType is copied;
        if (!empty($this->copyTranslations)) {
            foreach ($this->copyTranslations as $language_id => $translation) {
                $new_translation=new ItemTranslationSource();
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
    }

    public function afterFind()
    {
        parent::afterFind();

        foreach($this->sizeList as $i=>$size)
        {
            if($i==0)
                $this->sizeTitleList=$this->sizeTitleList . ' ' . $size->title;
            else
                $this->sizeTitleList=$this->sizeTitleList . '; ' . $size->title;

            $this->itemSizeTitleList[$size->title]=$size->title;
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
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
        $criteria->compare('partner_id',$this->type_id, true);
        $criteria->compare('colour',$this->colour,true);
        $criteria->compare('desc',$this->desc,true);
        $criteria->compare('price',$this->price,true);

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

    public function markImagesAsDeleted()
    {
        $galleryImages = ItemImage::model()->findAllByAttributes(array('item_id'=>$this->id));
        foreach($galleryImages as $image)
        {
            $image->belongs = NULL;
            $image->save(false, 'belongs');
        }
    }

    public function prepareTranslations()
    {
        $trArray=array();
        $languages = Language::model()->visible()->weighted()->findAll();
        foreach($languages as $language)
        {
            if ($language->code==Yii::app()->user->language)
            {
                $translation=new ItemTranslation('translation');
                $translation->language_id=$language->code;
                $translation->label=$language->title;
                $trArray[$language->code]=$translation;
            }
            else
            {
                $translation=new ItemTranslation();
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

    public static function getParentTypeId($type_id)
    {

        //return 4;//For temp use
        /**
         * A bug with nested tree behaviour should be fixed
         */

        //get type by id
        $query='SELECT lft, rgt
                 FROM item_type
                 WHERE item_type.id=:type_id';

        $command = Yii::app()->db->createCommand($query);
        $command->bindParam(":type_id",$type_id,PDO::PARAM_STR);
        $type_result = $command->queryAll();

        //get type parent
        $query='SELECT id
                 FROM item_type
                 WHERE lft < :lft AND rgt > :rgt 
                 ORDER BY rgt LIMIT 1';

        $command = Yii::app()->db->createCommand($query);
        $command->bindParam(":lft",$type_result[0]['lft'],PDO::PARAM_STR);
        $command->bindParam(":rgt",$type_result[0]['rgt'],PDO::PARAM_STR);
        $parentType_result = $command->queryAll();

        return ($parentType_result[0]['id']==1) ? 4 : $parentType_result[0]['id'];
    }

    /**
     * Return random item code
     */
    public static function getRandomItemCode()
    {
        $item_result = Yii::app()->db->createCommand()
            ->select('code')
            ->from('item')
            ->where('is_blocked=0 AND ready=1 AND unavailable=0')
            ->order('rand()')
            ->limit(10)
            ->queryAll();

        return $item_result[0]['code'];
    }

    public static function getFabricList($sub=null) {
        $value=(is_null($sub)) ? ' 0,1 ' : ' 0 ';

        $sql = "SELECT id, title
                FROM item_fabric
                WHERE sub IN( {$value} )";
        $command = Yii::app()->db->createCommand($sql);
        $result = $command->queryAll();

        return CHtml::listData($result, 'id', 'title');
    }

}
