<?php if ($model->galleryImages): ?>
    <div id="gallery_holder"> 
        <?php foreach ($model->galleryImages as $imageItem): ?>
            <div id="image_holder">
                <img src="<?php echo Yii::app()->baseUrl . DIRECTORY_SEPARATOR . Item::GALLERY_IMAGES_DIR . DIRECTORY_SEPARATOR .
        $model->id . DIRECTORY_SEPARATOR . $imageItem->thumbnail
            ?>" border="0" width="100" height="100">
                <div id="del">
                    <a href="#" id="<?php echo $imageItem->id ?>" class="modelID_<?php echo $model->id ?> del_gallery_item"><img src="<?php echo Yii::app()->baseUrl ?> /static/admin/gridview/b_trash.png" title="<?php echo Yii::t('gallery', 'delete') ?>" alt="<?php echo Yii::t('gallery', 'delete') ?>"></a>
                </div>
            </div>    
    <?php endforeach; ?>    
        <div class="clear"></div>
    </div>
<?php else: ?>
    <div>
        <blockquote style="margin-bottom:0px">
            <p class="text-info"><?php echo Yii::t('gallery', 'В галерее нет фотографий'); ?><p>
        </blockquote>
    </div>            
<?php endif; ?>    
