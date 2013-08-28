            <?php if ($model->mainItemImage):?>
                <img src="<?php echo Yii::app()->baseUrl . DIRECTORY_SEPARATOR . Item::GALLERY_IMAGES_DIR . DIRECTORY_SEPARATOR . 
                    $model->id . DIRECTORY_SEPARATOR . $model->mainItemImage['1']->thumbnail ?>" border="0" width="100" height="100">
                <div id="del">
                    <a href="#" id="<?php echo $model->mainItemImage['1']->id ?>" class="del_photo"><img src="<?php echo Yii::app()->baseUrl ?> /static/admin/gridview/b_trash.png" title="<?php echo Yii::t('gallery', 'delete')?>" alt="<?php echo Yii::t('gallery', 'delete')?>"></a>
                </div>                    
            <?php else: ?>
                <img src="<?php echo Yii::app()->baseUrl ?> /static/admin/no_photo_<?php echo Yii::app()->language ?>.png" border="0" width="100" height="100">
            <?php endif ?>
