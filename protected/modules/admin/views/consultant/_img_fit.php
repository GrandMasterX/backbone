<?php foreach($data as $item): ?>
    <li id="<?php echo $item['id']; ?>" class="img-holder new" style="display:none">
    <?php if (Yii::app()->user->isGuest): ?>
        <?php if (YII_DEBUG): ?>
            <a href="#" target="_blank"><img src="<?php echo $item['img_url']?>" class="img-polaroid" title="<?php echo Yii::t('img_fit', 'Подошло размеров: ') . $item['sizeF'] . ' ( ' . $item['sizeFitting'] . ')'; ?>" onclick="PopupWindowCenter('http://localhost/astrafit/index-dev.php/register/index?code=<?php echo $item['code'];?>&lastuserid=<?php echo $lastuserid;?>', 'PopupWindowCenter',1250,620); return false;"></a>
        <?php else: ?>
            <a href="#" target="_blank"><img src="<?php echo $item['img_url']?>" class="img-polaroid" title="<?php echo Yii::t('img_fit', 'Подошло размеров: ') . $item['sizeF'] . ' ( ' . $item['sizeFitting'] . ')'; ?>" onclick="PopupWindowCenter('http://localhost/astrafit/register/index?code=<?php echo $item['code'];?>&lastuserid=<?php echo $lastuserid;?>', 'PopupWindowCenter',1250,620); return false;"></a>
        <?php endIf; ?>     
    <?php else: ?>
        <?php if (YII_DEBUG): ?>
            <a href="#" target="_blank"><img src="<?php echo $item['img_url']?>" class="img-polaroid" title="<?php echo Yii::t('img_fit', 'Подошло размеров: ') . $item['sizeF'] . ' ( ' . $item['sizeFitting'] . ')'; ?>" onclick="PopupWindowCenter('http://www.astrafit.com.ua/site/result?code=<?php echo $item['code'];?>&lastuserid=<?php echo $lastuserid;?>', 'PopupWindowCenter',1250,620); return false;"></a>
        <?php else: ?>
            <a href="#" target="_blank"><img src="<?php echo $item['img_url']?>" class="img-polaroid" title="<?php echo Yii::t('img_fit', 'Подошло размеров: ') . $item['sizeF'] . ' ( ' . $item['sizeFitting'] . ')'; ?>" onclick="PopupWindowCenter('http://www.astrafit.com.ua/site/result?code=<?php echo $item['code'];?>&lastuserid=<?php echo $lastuserid;?>', 'PopupWindowCenter',1250,620); return false;"></a>
        <?php endIf; ?>
    <?php endIf; ?>    
    </li>
<?php endForeach; ?>