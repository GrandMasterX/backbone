<?php
$this->pageTitle=Yii::t('adminUser', 'Редактирование страницы');

$this->breadcrumbs=array(
	Yii::t('adminUser', 'Управление страницами')=>array('index'),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="user-form" class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'update-user-form',
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
			<?php echo $form->labelEx($model,'name', array('class'=>'control-label')); ?>
			<div class="controls"> 
                <?php echo $form->textField($model,'name',array('size'=>40)); ?>
			    <?php echo $form->error($model,'name'); ?>
            </div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'info', array('class'=>'control-label')); ?>
			<div class="controls"> 
                <?php echo $form->textField($model,'info',array('size'=>40)); ?>
			    <?php echo $form->error($model,'info'); ?>
            </div>
		</div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'weight', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'weight',array('size'=>40)); ?>
                <?php echo $form->error($model,'weight'); ?>
            </div>
        </div>
    
		<div class="control-group">
			<div class="controls"> 
                <?php echo CHtml::submitButton(Yii::t('Pages', 'Обновить'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('Pages', 'Отмена'), Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
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
