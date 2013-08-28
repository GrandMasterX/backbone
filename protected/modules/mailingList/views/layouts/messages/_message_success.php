        <div id="success" class="alert alert-success" <?php if(!Yii::app()->user->hasFlash('success')):?> style="display:none" <?php endif; ?>>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?php echo Yii::t('alert', 'Успешно!'); ?></strong>
            <?php if(Yii::app()->user->hasFlash('success')): echo Yii::app()->user->getFlash('success'); elseif(isset($message)): echo $message; endif; ?>
        </div>