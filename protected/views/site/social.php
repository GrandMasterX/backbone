<?php
    $this->pageTitle=Yii::t('socialForm', 'Введите пожалуйста email');
?>
<div class="form-outer-holder">
    <div class="l-form-holder">
    <div class="login-logo"><img src="<?php echo Yii::app()->baseUrl?>/static/img/login/astraFit.png" border="0" width="172" height="50"></div>
        <div class="login-form-holder">
            <h2><?php echo $this->pageTitle ?></h2>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'social-form',
                'enableAjaxValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
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
                        <?php echo CHtml::submitButton(Yii::t('socialForm', 'Нус, приступим!'),array('class'=>'btn')); ?>
                    </div>
                </div>            
            <?php $this->endWidget(); ?>
        </div>       
    </div>
</div>

<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScript(__FILE__,"
    
    $('.restore-link').live('click', function() {".
         CHtml::ajax(array(
            'url'=>Yii::app()->controller->createUrl('restorePassword',array()),
            'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'type'=>'POST',
            'success'=>"function(data){
               $('.restore-pass-form-holder').html(data).show();
               $('.login-form-holder').hide();
            }"
         ))
    ."});
    
    $('.login-link').live('click', function() {".         
        CHtml::ajax(array(
            'url'=>Yii::app()->controller->createUrl('restorePassword',array()),
            'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'type'=>'POST',
            'success'=>"function(data){
               $('.restore-pass-form-holder').html(data).hide();
               $('.login-form-holder').show();
            }"
        ))
."});    
    
", CClientScript::POS_READY
);    
?> 