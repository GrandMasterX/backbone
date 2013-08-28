        <div id="error" class="alert alert-error" <?php if(!Yii::app()->user->hasFlash('error')):?> style="display:none" <?php endif; ?>>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?php echo Yii::t('alert', 'Ошибка!'); ?></strong>
            <?php if(Yii::app()->user->hasFlash('error')): echo Yii::app()->user->getFlash('error'); elseif(isset($errorMessage)): echo $errorMessage; endif; ?>
        </div>        