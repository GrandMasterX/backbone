        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'change-pass-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions'=>array(
                'class'=>'form-horizontal'
                ),
            )); ?> 
            <div class="control-group">
                <?php echo $form->labelEx($model,'password_check', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->passwordField($model,'password_check',array('size'=>40)); ?> 
                    <?php echo $form->error($model,'password_check'); ?>
                </div>
            </div>         
            
            <div class="control-group">   
                <?php echo $form->labelEx($model,'password', array('class'=>'control-label')); ?>
                <div class="controls">  
                    <?php echo $form->textField($model,'password',array('size'=>40)); ?> 
                    <?php echo CHtml::button(Yii::t('adminUser', 'Сгенерировать'), array('id'=>'g_pass', 'class'=>'btn btn-info btn-mini')); ?>
                    <?php echo $form->error($model,'password'); ?>
                </div>
            </div>

            <div class="control-group">  
                <?php echo $form->labelEx($model,'password_repeat', array('class'=>'control-label')); ?>
                <div class="controls">  
                    <?php echo $form->textField($model,'password_repeat',array('size'=>40)); ?>
                    <?php echo $form->error($model,'password_repeat'); ?>
                </div>
                <?php echo CHtml::hiddenField('ajax','changepassform',array('size'=>16)); ?>
            </div>
        <?php $this->endWidget(); ?>               