<?php if(isset($data) && !empty($data) && !isset($data['empty'])):?>
    <?php foreach($data as $item):
            echo $item;
        endForeach; ?>
<?php elseIf(isset($data['empty'])): ?>
    <span id="item-property-info">
        <?php echo Yii::t('formula', 'У данного изделия нет размеров'); ?>
    </span>
<?php else: ?>
    <span id="item-property-info">
        <?php echo Yii::t('formula', 'Необходимо выбрать изделие'); ?>
    </span>    
<?php endIf;?>
