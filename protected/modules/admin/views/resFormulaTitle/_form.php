<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>($model->isNewRecord) ? 'create-resFormulaTitle-form' : 'update-resFormulaTitle-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions'=>array(
                'class'=>'form-horizontal'
                ),
            )); ?>

	<fieldset>
		<legend><span class="left-margin"><?php echo Yii::t('resFormulaTitle', 'Основная информация')?></legend>

        <div class="tab-holder-item" style="width:519px !important">  
            <?php $this->widget('bootstrap.widgets.TbTabs', array(
                'type'=>'tabs',
                'tabs'=>$this->generateTranslationFieldsForTab($model,$form),
            )); ?>
        </div>  
       
        <fieldset>
            <legend><span class="left-margin"><?php echo Yii::t('resFormulaTitle', 'Привязка диапазона')?></legend>
        <div class="control-group">
            <div class="controls">
            <?php echo $form->radioButtonList($model,'range',$model->rangeList, array('separator'=>'&nbsp&nbsp&nbsp&nbsp&nbsp', 'labelOptions'=>array('style'=>'display:inline'))); ?>
            </div>
        </div>            
        </fieldset>          
        
		<div class="control-group">
			<div class="controls item-l-margin">
                <?php echo CHtml::submitButton(($model->isNewRecord) ? Yii::t('resFormulaTitle', 'Создать') : Yii::t('resFormulaTitle', 'Обновить'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('resFormulaTitle', 'Отмена'), Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
            </div>
		</div>


<?php $this->endWidget(); ?>

