<div id="user-form" class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'update-translation-grid',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions'=>array(
                'class'=>'form-horizontal'
                ),
            )); ?>
    <fieldset>
        <?php $langText = Language::model()->find(array('condition'=>'code=:code', 'params'=>array(':code'=>$model->language))); ?>
        <legend><span class="left-margin"></span><?php echo Yii::t('translation', 'Язык'). ': ' . $langText->title; ?></legend>
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'category', array('class'=>'control-label')); ?>
            <div class="controls"> 
                <?php echo $form->textField($model,'category',array('size'=>80, 'disabled'=>'true')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'message', array('class'=>'control-label')); ?>
            <div class="controls"> 
                <?php echo $form->textArea($model, 'message', array('rows'=>1, 'cols'=>75, 'disabled'=>'true')) ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'translation', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'translation', array('rows'=>1, 'cols'=>75)) ?>
                <?php echo $form->error($model,'translation'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <div class="controls"> 
                <?php echo $form->hiddenField($model,'language',array('size'=>40)); ?>
            </div>
        </div>        
    
        <div class="control-group">
            <div class="controls"> 
                <?php echo CHtml::submitButton(Yii::t('translation', 'Обновить'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('translation', 'Отмена'), Yii::app()->controller->createUrl('index', array('languageTab'=>$model->language)), array('class'=>'btn'))?>
            </div>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>