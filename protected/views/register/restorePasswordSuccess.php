             <div id="restorePassSucces" class="form-signin">
                <div class="control-group" style="padding-left:10px">
                    <div><p class="text-success"><?php echo $message; ?></p></div>
                </div>
                <div class="control-group" style="padding-left:10px"> 
                    <div class="controls">
                        <?php echo CHtml::link(Yii::t('restorePassForm', 'Вернуться к авторизации'),'',array('class'=>'login-link'))?>
                    </div>
                </div>
             </div>
