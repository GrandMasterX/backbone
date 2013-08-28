<?php
$this->pageTitle=Yii::t('partner', 'Создание партнера');

$this->breadcrumbs=array(
	Yii::t('partner', 'Управление партнера')=>array('index'),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="partner-form" class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'create-partner-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions'=>array(
                'class'=>'form-horizontal'
                ),
            )); ?>

	<fieldset>
		<legend><span class="left-margin"><?php echo Yii::t('formGeneral', 'Основная информация')?></legend>

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
                <?php echo CHtml::submitButton(Yii::t('partner', 'Создать'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('partner', 'Отмена'), Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
            </div>
		</div>

	</fieldset>

<?php $this->endWidget(); ?>
</div>
