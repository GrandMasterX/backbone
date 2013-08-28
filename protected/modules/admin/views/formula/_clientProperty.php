<?php if(isset($data) && !empty($data)):?>
    <?php foreach($data as $sizeItem):
            echo $sizeItem['link'];
                
            if($sizeItem['vst'] != null) 
                echo $sizeItem['vst'];                

            if($sizeItem['vk'] != null) 
                echo $sizeItem['vk'];
                
            if($sizeItem['vzu'] != null) 
                echo $sizeItem['vzu'];                                
                
            if($sizeItem['dts'] != null) 
                echo $sizeItem['dts'];
                
            if($sizeItem['dr'] != null) 
                echo $sizeItem['dr'];

            if($sizeItem['vpl'] != null)
                echo $sizeItem['vpl'];

            if($sizeItem['vlok'] != null)
                echo $sizeItem['vlok'];

            if($sizeItem['vprch'] != null)
                echo $sizeItem['vprch'];

            if($sizeItem['drvnch'] != null)
                echo $sizeItem['drvnch'];

        endForeach; ?>
<?php elseIf(isset($data['empty'])): ?>
    <span id="client-property-info">
        <?php echo Yii::t('formula', 'У данного клиента нет размеров'); ?>
    </span>
<?php else: ?>
    <span id="client-property-info">
        <?php echo Yii::t('formula', 'Необходимо выбрать клиента'); ?>
    </span>    
<?php endIf;?>
