<?php
$this->pageTitle=Yii::t('partner', 'Редактирование партнера');

$this->breadcrumbs=array(
	Yii::t('partner', 'Управление партнерами')=>array('index'),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="partner-form" class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'update-partner-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions'=>array(
                'class'=>'form-horizontal'
                ),
            )); ?>
    <fieldset>
        <legend><span class="left-margin"></span><?php echo Yii::t('formGeneral', 'Основная информация')?></legend>
        <div class="control-group">
            <?php echo $form->labelEx($model,'company_title', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'company_title',array('size'=>100)); ?>
                <?php echo $form->error($model,'company_title'); ?>
            </div>
        </div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'name', array('class'=>'control-label')); ?>
			<div class="controls"> 
                <?php echo $form->textField($model,'name',array('size'=>40)); ?>
			    <?php echo $form->error($model,'name'); ?>
            </div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'email', array('class'=>'control-label')); ?>
			<div class="controls"> 
                <?php echo $form->textField($model,'email',array('size'=>40)); ?>
			    <?php echo $form->error($model,'email'); ?>
            </div>
		</div>
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'phone', array('class'=>'control-label')); ?>
            <div class="controls"> 
                <?php echo $form->textField($model,'phone',array('size'=>40)); ?>
                <?php echo $form->error($model,'phone'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'www', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'www',array('size'=>40)); ?>
                <?php echo $form->error($model,'www'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'xml_url', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'xml_url',array('size'=>40)); ?>
                <?php echo $form->error($model,'xml_url'); ?>
            </div>
        </div>  
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'image_import_url', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'image_import_url',array('size'=>40)); ?>
                <?php echo $form->error($model,'image_import_url'); ?>
            </div>
        </div>                            
    
		<div class="control-group">
			<div class="controls"> 
                <?php echo CHtml::submitButton(Yii::t('partner', 'Обновить'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('partner', 'Отмена'), Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
            </div>
		</div>
    </fieldset>
<?php $this->endWidget(); ?>
</div>

<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScriptFile($baseUrl.'/static/admin/debug/print_r.js')
    ->registerScript(__FILE__,"
    
    $('#g_pass').live('click', function() {".
         CHtml::ajax(array(
            'url'=>Yii::app()->controller->createUrl('generatePassword',array()),
            'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'type'=>'POST',
            'success'=>"function(data){
               $('input#User_password').val(data);
               $('input#User_password_repeat').val(data);
            }"
         ))
    ."});
    
    $('#ch-pass-b').live('click', function() {".
         CHtml::ajax(array(
            'url'=>Yii::app()->controller->createUrl('changePassword',array()),
            'data'=>array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'type'=>'POST',
            'success'=>"function(data){
            var data = jQuery.parseJSON(data);
            $('div#ch_pass_cont').html(data.html);
            }"
         ))
    ."});
    
    function updateModal(data) {
       var data = jQuery.parseJSON(data);
       if(data.status=='success'){
        $('#ch_pass').modal('hide');
        showMessage(data.html);
        //$('div#ch_pass_cont').empty();
        } else {
            $('div#ch_pass_cont').html(data.html);  
        }
    }    
    
    ", CClientScript::POS_READY
);    
?> 
