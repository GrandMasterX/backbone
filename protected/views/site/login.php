<?php
$this->pageTitle=Yii::t('loginForm', 'Авторизация');
?>

<div class="form-outer-holder">
    <div class="l-form-holder">
    <div class="login-logo"><img src="<?php echo Yii::app()->baseUrl?>/static/img/login/astraFit.png" border="0" width="172" height="50"></div>
        <div class="login-form-holder">
            <h2><?php echo $this->pageTitle ?></h2>
            <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'login-form',
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
		            <?php echo $form->labelEx($model,'password', array('class'=>'control-label')); ?>
		            <div class="controls">
                        <?php echo $form->passwordField($model,'password'); ?>
		                <?php echo $form->error($model,'password'); ?>
                    </div>
	            </div>

	            <div class="control-group"> 
	                <div class="controls">
                        <?php echo CHtml::link(Yii::t('loginForm', 'Восстановление пароля'),'',array('class'=>'restore-link'))?>
                    </div>
	            </div>
                
                <div class="control-group"> 
                    <div class="controls">
                        <?php echo CHtml::submitButton(Yii::t('loginForm', 'Войти'),array('class'=>'btn')); ?>
                    </div>
                </div>            
            <?php $this->endWidget(); ?>
        </div>
        
        <div class="restore-pass-form-holder" style="display:none">
        </div>        
    </div>
    <?php
        //$this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login'));
    ?>
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