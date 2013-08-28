<?php
class ItemSourceController extends Controller
{
    //Fields list to be displayed in tabel rows for comparison
    public $fieldsToDisplay=array(
        'id'=>'id',
        'code'=>'Код',
        'title'=>'Наименование',
        'type_id'=>'Тип',
        'fabric_id'=>'Тип ткани',
        'colour'=>'Цвет',
        'stretch'=>'МНТ',
        'stretchp'=>'МНТП',
        'price'=>'Цена',
        'bretel'=>'Бретель',
        'comment'=>'Комментарий',
        'size_finished'=>'Есть все размеры',
        'ready'=>'Обработано',
    );

    public $sizeFieldsToDisplay=array(
        'title' => 'Наименование',
        'il' =>'Длина изделия по спинке (ДИ)',
        'iwa' =>'Ширина на уровне глубины проймы (ШУГ)',
        'iww' =>'Ширина на уровне талии (ШУТ)',
        'iwt' =>'Ширина на уровне бедерн (ШУБ)',
        'ils' =>'Длина рукава (ДР)',
        'iws' =>'Ширина рукава вверху (ШР)',
        'iwp' =>'Ширина полочки в узком месте (ШГ)',
        'iwss' =>'Длина бокового шва (ДБШ)',
        'iwcb' =>'Высота подреза по спинке (Вп)',
        'bw' =>'Ширина спинки (Шс)',
        'vpr' =>'Высота проймы (Впр):auto',
        'rpli' =>'Разлет плечевой изделия (РплИ):auto',
        'iwar' =>'Ширина на уровне глубины проймы (ШУГр)',
        'iwwr' =>'Ширина на уровне талии (ШУТр)',
        'iltwo' =>'Длина изделия 2 (ДИ2)',
        'iwsstwo'=>'Длина бокового шва 2 (Дбш2)',
        'vsl'=>'Высота шлейфа (Вшл) :auto',
        'sup'=>'Ширина изделя на уровне подреза (ШУП)',
        'iwap'=>'Ширина подкладки на уровне глубины проймы (ШУГп)',
        'iwwp' =>'Ширина подкладки на уровне талии (ШУТп)',
        'iwtp'=>'Ширина подкладки на уровне бедерн (ШУБп)',
        'cup'=>'Размер чашечки',
        'birka'=>'Размер в магазине',
        'iws2'=>'Ширина рукава растянутая (ШР2)',
    );
    //Fields list to validate against
    protected $keys=array('type_id','fabric_id','colour','stretch','stretchp','price','bretel','comment','size_finished','ready');
    protected $sizeKeys=array('il','iwa','iww','iwt','ils','iws','iwp','iwss','iwcb','bw','vpr','rpli','iwar','iwwr','iltwo','iwsstwo','vsl','sup','iwap','iwwp','iwtp','cip','birka','iws2');

    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly + LoadSizeList',
        );
    }    
    
	public function actionIndex()
	{
        $modelsArray=array();
        //$modelsSizeArray=array();
        $sourceItemArray=array();
        //$sourceItemSizeArray=array();

        $models=Item::model()->visible()->findAll('partner_id=:id',array(':id'=>418));
        if(empty($models))
            throw new CHttpException(404,'No items found in base (item) table for the given partner');

        foreach($models as $n=>$model)
        {
            $result=false;
            $sourceItem=ItemSource::model()->visible()->findByAttributes(array('code'=>$model->code));
            if($sourceItem!==null) {

                foreach($model->attributes as $key=>$value)
                {
                    if(in_array($key,$this->keys))
                    {
                        if($model->attributes[$key] != $sourceItem->attributes[$key])
                        {
                            $sourceItem->addError($key, 'error');
                            $result=true;
                        }

                        if($sourceItem->ready==1)
                            $sourceItem->ready='Да';

                        if($sourceItem->size_finished==1)
                            $sourceItem->size_finished='Да';
                    }

//                    foreach($model->sizeList as $sizeListKey=>$size)
//                    {
//                        foreach($size->attributes as $sizeKey=>$sizeValue)
//                        {
//                            if(in_array($sizeKey, $this->sizeKeys)) {
//                                if(isset($model->sizeList[$sizeListKey]) && isset($sourceItem->sizeList[$sizeListKey])) {
//                                    if($model->sizeList[$sizeListKey]->attributes[$sizeKey] != $sourceItem->sizeList[$sizeListKey]->attributes[$sizeKey])
//                                        $sourceItem->sizeList[$sizeListKey]->addError($sizeKey, 'error');
//                                }
//                            }
//                        }
//                    }
                }

                if($result) {
                    $modelsArray[$n]=$model;
                    $sourceItemArray[$n]=$sourceItem;
                    //$modelsSizeArray[$n]=$model->sizeList;
                    //$sourceItemSizeArray[$n]=$sourceItem->sizeList;
                }
                else
                {
                    unset($models[$n]);
                }
            }
        }

        $this->render('index',array(
            'modelsArray'=>$modelsArray,
            'sourceItemArray'=>$sourceItemArray,
            //'modelsSizeArray'=>$modelsSizeArray,
            //'sourceItemSizeArray'=>$sourceItemSizeArray,
        ));
	}

    public function actionLeaveOld()
    {
        $id=Yii::app()->request->getPost('id');
        $result=ItemSource::model()->findByPk($id)->delete();

        if($result)
            $msg['message']=Yii::t('itemSource','Вы оставили старое значение');
        else
            $msg['errorMessage']=Yii::t('itemSource','Возникла ошибка при сохранении старого значения');

        $data=array(
            'result'=>($result) ? 'success' : 'error',
            'id'=>$id,
            'html'=>$html = $this->renderPartial('/layouts/messages/_message_success', $msg, true, false),
        );

        echo json_encode($data);
        Yii::app()->end();
    }

    public function actionUseNew()
    {
        $id=Yii::app()->request->getPost('id');

        $oldModel=Item::model()->findByPk($id);
        if($oldModel===null)
            throw new CHttpException(404,'Old model not found');

        $sourceModel=ItemSource::model()->findByPk($id);
        if($sourceModel===null)
            throw new CHttpException(404,'Source model not found');

        //copy item properties
        $oldModel->attributes=$sourceModel->attributes;
        //save translation
        $oldModel->itemTranslation = $sourceModel->translations;
        $result=$oldModel->save(false);
        $sourceModel->delete();

        //copy itemSize
        if($result) {
            //$oldModel->sizeList=$sourceModel->sizeList;
            foreach ($oldModel->sizeList as $n=>$itemSizeModel)
            {
                $itemSizeModel->attributes=$sourceModel->sizeList[$n]->attributes;
                $itemSizeModel->save(false);
            }
        }

        if($result)
            $msg['message']=Yii::t('itemSource','Вы применили новое значение');
        else
            $msg['errorMessage']=Yii::t('itemSource','Возникла ошибка при приминении нового значения');

        $data=array(
            'result'=>($result) ? 'success' : 'error',
            'id'=>$id,
            'html'=>$html = $this->renderPartial('/layouts/messages/_message_success', $msg, true, false),
        );

        echo json_encode($data);
        Yii::app()->end();
    }

}