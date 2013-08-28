            <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'restore-pass-form',
                        'enableAjaxValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                            'afterValidate'=>'js:afterFormValidateFunction',
                        ),
                        'htmlOptions'=>array(
                            'class'=>'form-signin',
                            'style'=>'display:none'
                            ),
                        )); ?>
                <h2 class="form-signin-heading"><?php echo Yii::t('login', 'Восстановление пароля');?></h2>
                <div class="control-group">  
                    <?php echo $form->labelEx($user,'email', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($user,'email', array('class'=>'input-block-level', 'placeholder'=>Yii::t('login', 'Email'))); ?>
                        <?php echo $form->error($user,'email'); ?>
                    </div>
                </div>

                <div class="control-group"> 
                    <div class="controls">
                        <?php echo CHtml::link(Yii::t('restorePassForm', 'Вернуться к авторизации'),'',array('class'=>'login-link'))?>
                    </div>
                </div>
                
                <div class="control-group"> 
                    <div class="controls">
                        <?php echo CHtml::submitButton(Yii::t('restorePassForm', 'Восстановить'),array('class'=>'btn restore-pass-btn')); ?>
                    </div>
                </div>
            <?php $this->endWidget(); ?>
            
<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScript(__FILE__,"
    
    function afterFormValidateFunction(form, data, hasError){
        if (!hasError){
            $.post(form.attr('action'), form.serialize(), function(data){
                if (data)
                   $('form#restore-pass-form').remove();
                   $('.form-holder').append(data).find('div#restorePassSucces').fadeIn();
            });
        }
        // Always return false so that Yii will never do a traditional form submit
        return false;
    }         
    
", CClientScript::POS_READY
);    
?>             