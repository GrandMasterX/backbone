<?php
$this->pageTitle=Yii::t('adminUser', 'Создание администратора');

$this->breadcrumbs=array(
	Yii::t('adminUser', 'Управление администраторами')=>array('index'),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="user-form" class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'create-user-form',
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
			<div class="controls">
                <?php echo CHtml::submitButton(Yii::t('adminUser', 'Создать'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('adminUser', 'Отмена'), Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
            </div>
		</div>

	</fieldset>

<?php $this->endWidget(); ?>
</div>
