<?php

/**
 * This is the model class for table "itemsize".
 *
 * The followings are the available columns in table 'itemsize':
 * @property string $id
 * @property string $title
 * @property string $create_time
 * @property string $update_time
 * @property integer $is_locked
 * @property integer $is_blocked
 * @property string $created_by_id
 * @property string $updated_by_id
 * @property string $il
 * @property string $iwa
 * @property string $iww
 * @property string $iwt
 * @property string $ils
 * @property string $iwsa
 * @property string $iwp
 * @property string $iwss
 * @property string $iwcb
 * @property integer $weight
 * @property string $info
 * $property decimal $bw
 * @property string $vps
 * @property string $rpli
 * @property string $iwar
 * @property string $iwwr
 */
class ItemSizeSource extends CActiveRecord
{
    public $item_title;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ItemSize the static model class
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
        return 'itemsize_source';
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
            array('title', 'required', 'on'=>'insert,update'),
            array('title', 'itemSizeNameUnique', 'on'=>'insert,update'),
            //array('title','unique','on'=>'insert,update'),
            array('item_id, cup, birka, update_time, info', 'safe'),
            array('il, iwa, iww, iwt, ils, iws, iws2, iwp, iwss, iwcb, bw,iltwo,iwsstwo,sup,iwap,iwwp,iwtp', 'match', 'pattern'=>'/^[0-9]{1,3}(\.[0-9]{0,2})?$/',
                'message'=>'{attribute} может быть целым или десятичным числом (0.00).'),
            array('title', 'length', 'max'=>150),
            array('created_by_id, updated_by_id, il, iwa, iww, iwt, ils, iws, iws2, iwp, iwss, iwcb, bw, vpr, rpli, iwar, iwwr, iltwo,iwsstwo,vsl,sup,iwap,iwwp,iwtp', 'length', 'max'=>10),
            //array('update_time, info', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, create_time, update_time, is_locked, is_blocked, created_by_id, updated_by_id, il, iwa, bw, iww, iwt, ils, iws, iws2, iwp, iwss, iwcb, vpr, rpli, iwar, iwwr, weight, info, iltwo,iwsstwo,vsl,sup,iwap,iwwp,iwtp,cup,birka', 'safe', 'on'=>'search'),
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
            'item'=>array(self::BELONGS_TO,'ItemSource','item_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => Yii::t('itemSize', 'Наименование'),
            'create_time'=>Yii::t('itemSize','Дата создания'),
            'update_time' => Yii::t('itemSize','Дата обновления'),
            'mainImage' => Yii::t('itemSize','Основное фото'),
            'il' => Yii::t('itemSize','Длина изделия по спинке (ДИ)'),
            'iwa' => Yii::t('itemSize','Ширина на уровне глубины проймы (ШУГ)'),
            'iww' => Yii::t('itemSize','Ширина на уровне талии (ШУТ)'),
            'iwar' => Yii::t('itemSize','Ширина на уровне глубины проймы (ШУГр)'),
            'iwwr' => Yii::t('itemSize','Ширина на уровне талии (ШУТр)'),
            'iwt' => Yii::t('itemSize','Ширина на уровне бедерн (ШУБ)'),
            'ils' => Yii::t('itemSize','Длина рукава (ДР)'),
            'iws' => Yii::t('itemSize','Ширина рукава вверху (ШР)'),
            'iws2' => Yii::t('itemSize','Ширина рукава растянутая (ШР2)'),
            'iwp' => Yii::t('itemSize','Ширина полочки в узком месте (ШГ)'),
            'iwss' => Yii::t('itemSize','Длина бокового шва (ДБШ)'),
            'iwcb' => Yii::t('itemSize','Высота подреза по спинке (Вп)'),
            'bw' => Yii::t('itemSize','Ширина спинки (Шс)'),
            'type_id' => Yii::t('itemSize','Тип изделия'),
            'item_title' =>Yii::t('itemSize','Наименование изделия'),
            'info' => 'Info',
            'vpr'=>Yii::t('item','Высота проймы (Впр):auto'),
            'rpli'=>Yii::t('item','Разлет плечевой изделия (РплИ):auto'),
            'iltwo'=>Yii::t('item','Длина изделия 2 (ДИ2)'),
            'iwsstwo'=>Yii::t('item','Длина бокового шва 2 (Дбш2)'),
            'vsl'=>Yii::t('item','Высота шлейфа (Вшл) :auto'),
            'sup'=>Yii::t('item','Ширина изделя на уровне подреза (ШУП)'),
            'iwap'=>Yii::t('item','Ширина подкладки на уровне глубины проймы (ШУГп)'),
            'iwwp'=>Yii::t('item','Ширина подкладки на уровне талии (ШУТп)'),
            'iwtp'=>Yii::t('item','Ширина подкладки на уровне бедерн (ШУБп)'),
            'cup'=>Yii::t('item','Размер чашечки'),
            'birka'=>Yii::t('item','Размер в магазине'),
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
        }

        //calculate Разлет плечевой изделия (РплИ)
        $this->rpli=$this->bw+2;
        //calculate Высота проймы (Впр)
        $this->vpr=$this->il-$this->iwss;
        //calculate Высота шлейфа (Вшл)
        $this->vsl=($this->iltwo > 0) ? $this->iltwo-$this->il : 0;

        return true;
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
        $criteria->compare('create_time',$this->create_time,true);
        $criteria->compare('update_time',$this->update_time,true);
        $criteria->compare('is_locked',$this->is_locked);
        $criteria->compare('is_blocked',$this->is_blocked);
        $criteria->compare('created_by_id',$this->created_by_id,true);
        $criteria->compare('updated_by_id',$this->updated_by_id,true);
        $criteria->compare('il',$this->il,true);
        $criteria->compare('iwa',$this->iwa,true);
        $criteria->compare('iww',$this->iww,true);
        $criteria->compare('iwt',$this->iwt,true);
        $criteria->compare('ils',$this->ils,true);
        $criteria->compare('iws',$this->iws,true);
        $criteria->compare('iwp',$this->iwp,true);
        $criteria->compare('iwss',$this->iwss,true);
        $criteria->compare('iwcb',$this->iwcb,true);
        $criteria->compare('weight',$this->weight);
        $criteria->compare('info',$this->info,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function itemSizeNameUnique($attribute,$params)
    {
        $criteria=new CDbCriteria();
        if($this->isNewRecord)
            $criteria->condition="item_id={$this->item_id} AND title='{$this->title}'";
        else
            $criteria->condition="item_id={$this->item_id} AND id<>{$this->id} AND title='{$this->title}'";

        $model = ItemSize::model()->find($criteria);

        if($model)
            $this->addError('title',Yii::t('itemSize', 'Такой размер уже существует'));

    }

    public static function toArray()
    {
        $list=array();
        $models=ItemSize::model()->visible()->findAll();
        foreach($models as $model)
        {
            $list[$model->title]=$model->title;
        }
        return array_unique($list);
    }

}