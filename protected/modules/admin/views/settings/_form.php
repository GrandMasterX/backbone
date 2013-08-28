<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>($model->isNewRecord) ? 'create-settings-form' : 'update-settings-form',
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
			<?php echo $form->labelEx($model,'title', array('class'=>'control-label')); ?>
			<div class="controls">
                <?php echo $form->textField($model,'title',array('size'=>100)); ?>
			    <?php echo $form->error($model,'title'); ?>
            </div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'code', array('class'=>'control-label')); ?>
			<div class="controls">
                <?php echo $form->textField($model,'code',array('size'=>10)); ?>
			    <?php echo $form->error($model,'code'); ?>
            </div>
		</div>
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'value', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'value',array('size'=>10)); ?>
                <?php echo $form->error($model,'value'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'info', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'info',array('size'=>10)); ?>
                <?php echo $form->error($model,'info'); ?>
            </div>
        </div>                
        
		<div class="control-group">
			<div class="controls">
                <?php echo CHtml::submitButton(($model->isNewRecord) ? Yii::t('language', 'Создать') : Yii::t('language', 'Обновить'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('language', 'Отмена'), (Yii::app()->session['param']) ? Yii::app()->controller->createUrl('index', array('param'=>Yii::app()->session['param'])) : Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
            </div>
		</div>

	</fieldset>

<?php $this->endWidget(); ?>

