<?php
$this->pageTitle=Yii::t('setPasswordForm', 'Установка пароля');
?>

<div class="form-outer-holder">
    <div class="l-form-holder">
        <div class="login-form-holder">  
            <h2><?php echo $this->pageTitle?></h2>
            <?php if ($set): ?> 
            <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'login-form',
                        'enableAjaxValidation'=>false,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>false,
                        ),
                        'htmlOptions'=>array(
                            'class'=>'form-horizontal'
                            ),
                        )); ?>

                <div class="control-group">
                    <?php echo $form->labelEx($model,'password', array('class'=>'control-label')); ?>
                    <div class="controls">  
                        <?php echo $form->passwordField($model,'password'); ?>
                        <?php echo $form->error($model,'password'); ?>
                    </div>
                </div>
                
                <div class="control-group">   
                    <?php echo $form->labelEx($model,'password_repeat', array('class'=>'control-label')); ?>
                    <div class="controls">  
                        <?php echo $form->passwordField($model,'password_repeat'); ?>
                        <?php echo $form->error($model,'password_repeat'); ?>
                    </div>
                </div>    

                <div class="control-group"> 
                    <div class="controls">
                        <?php echo CHtml::submitButton(Yii::t('setPasswordForm', 'Установить'),array('class'=>'btn')); ?>
                    </div>
                </div>

            <?php $this->endWidget(); ?>

            <?php else: ?>    
                <div style="padding-left:10px">
                    <p class="text-error"><?php echo Yii::t('setPasswordForm', 'Проверочный код уже недействителен. Вам необходимо повторно запросить установку пароля у администратора.'); ?></p>
                </div>
            <?php endif ?>    
        </div>
    </div>
</div>