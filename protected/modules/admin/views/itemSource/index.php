<?php
$this->pageTitle=Yii::t('item_source', 'Синхронизация данных нетбука');

$this->breadcrumbs=array(
	$this->pageTitle,
);
echo '<p style="font-weight:bold">Изделия OhMyLook. Необходимо сравнить изделий:' . count($modelsArray) . '</p>';
?>
<?php foreach($modelsArray as $n=>$item): ?>
    <table id="tbl_<?php echo $item->id;?>" class="sync-table table table-striped table-bordered table-hover table-condensed">
        <tr>
            <th><?php echo Yii::t('itemSource','Поля');?></th>
            <th><?php echo Yii::t('itemSource','Значение из БД');?></th>
            <th><?php echo Yii::t('itemSource','Импортируемое значение');?></th>
        </tr>

        <?php foreach($item->attributes as $key=>$value): ?>
            <?php if(array_key_exists($key, $this->fieldsToDisplay)): ?>
                <tr class="<?php echo $sourceItemArray[$n]->getError($key); ?>">
                    <td><?php echo Yii::t('itemSource',$this->fieldsToDisplay[$key]);?></td>
                    <td><?php echo ($key=='title') ? Helper::getTranslation($item, "title") : $item->$key;?></td>
                    <td><?php echo ($key=='title') ? Helper::getTranslation($sourceItemArray[$n], "title") : $sourceItemArray[$n]->$key;?></td>
                </tr>
            <?php endIf;?>
        <?php endForeach;?>

        <tr>
            <th colspan="3" style="text-align: center"><?php echo Yii::t('itemSource','Размеры');?></th>
        </tr>

        <?php foreach($item->sizeList as $key=>$value): ?>
            <?php foreach($value->attributes as $sizeKey=>$sizeValue): ?>
                <?php if(array_key_exists($sizeKey, $this->sizeFieldsToDisplay)): ?>
                    <tr class="<?php echo ($sizeValue != $sourceItemArray[$n]->sizeList[$key]->$sizeKey) ? 'error': ''?>">
                        <td><?php echo $this->sizeFieldsToDisplay[$sizeKey];?></td>
                        <td><?php echo $sizeValue;?></td>
                        <td><?php echo $sourceItemArray[$n]->sizeList[$key]->$sizeKey;?></td>
                    </tr>
                <?php endIf;?>
            <?php endForeach;?>
        <?php endForeach;?>

<!--        --><?php //foreach($modelsSizeArray[$n] as $sizeKey=>$sizeValue): ?>
<!--            --><?php //if(array_key_exists($sizeKey, $this->sizeFieldsToDisplay)): ?>
<!--                <tr class="--><?php //echo $sourceItemSizeArray[$n]->getError($sizeKey); ?><!--">-->
<!--                    <td>--><?php //echo Yii::t('itemSource',$this->sizeFieldsToDisplay[$key]);?><!--</td>-->
<!--                    <td>--><?php //echo $sizeValue->$sizeKey;?><!--</td>-->
<!--                    <td>--><?php //echo $sourceItemSizeArray[$n]->$sizeKey;?><!--</td>-->
<!--                </tr>-->
            <?php //endIf;?>
        <?php //endForeach;?>

        <tr>
            <td></td>
            <td>
                <?php echo CHtml::link(Yii::t('itemSource', 'Оставить старые значения'),'#',
                    array(
                        'id'=>$item->id,
                        'class'=>'btn btn-warning leave-old',
                    )
                );?>
            </td>
            <td>
                <?php echo CHtml::link(Yii::t('itemSource', 'Применить новые значения'),'#',
                    array(
                        'id'=>$item->id,
                        'class'=>'btn btn-primary use-new',
                    )
                );?>
            </td>
        </tr>
    </table>
<?php endforeach; ?>

<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScriptFile($baseUrl.'/static/admin/debug/print_r.js')
    ->registerScript(__FILE__,"

    $('.leave-old').live('click', function() {".
        CHtml::ajax(array(
            'url'=>Yii::app()->controller->createUrl('leaveOld',array()),
            'data'=>array(
                Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
                'id'=>'js:$(this).attr(\'id\')',
            ),
            'type'=>'POST',
            'dataType'=>'json',
            'success'=>"function(data){
               if(data.result=='success'){
                    $('table#tbl_'+data.id).remove();
                    showMessage(data.html);
               } else {
                    showMessage(data.html);
               }
            }"
        ))
        ."});

    $('.use-new').live('click', function() {".
        CHtml::ajax(array(
            'url'=>Yii::app()->controller->createUrl('useNew',array()),
            'data'=>array(
                Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
                'id'=>'js:$(this).attr(\'id\')',
            ),
            'type'=>'POST',
            'dataType'=>'json',
            'success'=>"function(data){
               if(data.result=='success'){
                    $('table#tbl_'+data.id).remove();
                    showMessage(data.html);
               } else {
                    showMessage(data.html);
               }
            }"
        ))
        ."});

    ", CClientScript::POS_READY
    );
?>