<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>($model->isNewRecord) ? 'create-clientSize-form' : 'update-clientSize-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions'=>array(
                'class'=>'form-horizontal'
                ),
            )); ?>

	<fieldset>
		<legend><span class="left-margin"><?php echo Yii::t('clientSize', 'Основная информация')?></legend>

        <div class="tab-holder-item" style="width:519px !important">  
            <?php $this->widget('bootstrap.widgets.TbTabs', array(
                'type'=>'tabs',
                'tabs'=>$this->generateTranslationFieldsForTab($model,$form),
            )); ?>
        </div>

		<div class="control-group">
			<div class="controls item-l-margin">
                <?php echo CHtml::submitButton(($model->isNewRecord) ? Yii::t('clientSize', 'Создать') : Yii::t('clientSize', 'Обновить'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('clientSize', 'Отмена'), Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
            </div>
		</div>

	</fieldset>

<?php $this->endWidget(); ?>

