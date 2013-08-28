<?php
$this->pageTitle=Yii::t('client', 'Редактирование клиента');

$this->breadcrumbs=array(
	Yii::t('partner', 'Управление клиентами')=>array('index'),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="partner-form" class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'update-client-form',
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
			<?php echo $form->labelEx($model,'name', array('class'=>'control-label item-w')); ?>
			<div class="controls item-l-margin"> 
                <?php echo $form->textField($model,'name',array('size'=>40)); ?>
			    <?php echo $form->error($model,'name'); ?>
            </div>
		</div>

<!--		<div class="control-group">-->
<!--			--><?php //echo $form->labelEx($model,'email', array('class'=>'control-label item-w')); ?>
<!--			<div class="controls item-l-margin"> -->
<!--			--><?php //echo $form->textField($model,'email',array('size'=>40)); ?>
<!--			--><?php //echo $form->error($model,'email'); ?>
<!--            </div>-->
<!--		</div>-->
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'phone', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin"> 
                <?php echo $form->textField($model,'phone',array('size'=>40)); ?>
                <?php echo $form->error($model,'phone'); ?>
            </div>
        </div>
        
    <fieldset>
        <legend><span class="left-margin"><?php echo Yii::t('client', 'Данные о размерах')?></legend>

        <?php foreach ($listOfClientSizeModelsForUpdate as $i => $item): ?>
            <div class="control-group">
                <?php echo $form->labelEx($item['model'], "[$i]value", array('class' => 'control-label item-w', 'label' => $item['model']->label)); ?>
                <div class="controls item-l-margin">
                    <?php echo $form->textField($item['model'], "[$i]value", array('size' => 40)); ?>
                    <?php echo $form->error($item['model'], "[$i]value"); ?>
                    <?php echo $form->hiddenField($item['model'], "[$i]size_id", array('size' => 40)); ?>
                </div>
            </div>
        <?php endForeach; ?>
    </fieldset>          
        
		<div class="control-group">
			<div class="controls item-l-margin"> 
                <?php echo CHtml::submitButton(Yii::t('client', 'Обновить'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('client', 'Отмена'), Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
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
