        <div id="alert" class="alert" <?php if(!Yii::app()->user->hasFlash('alert')):?> style="display:none" <?php endif; ?>>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?php echo Yii::t('alert', 'Внимание!'); ?></strong>
            <?php if(Yii::app()->user->hasFlash('alert')): echo Yii::app()->user->getFlash('alert'); elseif(isset($alertMessage)): echo $alertMessage; endif; ?>
        </div>        