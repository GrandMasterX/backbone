            <h2><?php echo Yii::t('restorePassForm', 'Восстановление пароля'); ?></h2>
            <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'restore-pass-form',
                        'enableAjaxValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>false,
                        ),
                        'htmlOptions'=>array(
                            'class'=>'form-horizontal'
                            ),
                        )); ?>

                <div class="control-group">  
                    <?php echo $form->labelEx($model,'email', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'email'); ?>
                        <?php echo $form->error($model,'email'); ?>
                    </div>
                </div>

                <div class="control-group"> 
                    <div class="controls">
                        <?php echo CHtml::link(Yii::t('restorePassForm', 'Вернуться к авторизации'),'',array('class'=>'login-link'))?>
                    </div>
                </div>
                
                <div class="control-group"> 
                    <div class="controls">
                        <?php
                            echo CHtml::ajaxSubmitButton(Yii::t('restorePassForm', 'Готово'), 
                                Yii::app()->controller->createUrl('restorePassword',array()), 
                                array(
                                    'type' => 'POST',
                                    'data'=>'js:$("#restore-pass-form").serialize()',
                                    'success' => 'function(data){
                                       $(".restore-pass-form-holder").html(data).show();  
                                    }',
                                ),
                                array(
                                   'type' => 'submit',
                                   'class'=>'btn'
                                ));
                        ?>                        
                    </div>
                </div>            
            <?php $this->endWidget(); ?>