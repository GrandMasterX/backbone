<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>($model->isNewRecord) ? 'create-itemType-form' : 'update-itemType-form',
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

        <div class="tab-holder-item" style="width:519px !important">  
            <?php $this->widget('bootstrap.widgets.TbTabs', array(
                'type'=>'tabs',
                'tabs'=>$this->generateTranslationFieldsForTab($model,$form),
            )); ?>
        </div>        
        
        <div class="control-group">
            <?php echo $form->labelEx($model,'root', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo Chosen::activeDropDownList(
                    $model, 
                    'root', 
                    ItemType::getListOfItemType(), array(
                        'empty'=>Yii::t('itemType', 'Без категории')
                        )
                    ); ?> 
                <?php echo $form->error($model,'root'); ?>
            </div>
        </div>
    
    <fieldset>
        <legend><span class="left-margin"><?php echo Yii::t('itemType', 'Привязка к размерам')?></legend>        
            <table>
                <?php echo $form->checkBoxList($model, 'typeSizeList', $model->getListOfSizeForBinding(), array('template'=>'<tr><td>{input}</td><td>{label}</td></tr>')); ?>
            </table> 
    </fieldset>           

		<div class="control-group">
			<div class="controls item-l-margin">
                <?php echo CHtml::submitButton(
                    ($model->isNewRecord) ? Yii::t('itemType', 'Создать') : Yii::t('itemType', 'Обновить'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('itemType', 'Отмена'), Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
            </div>
		</div>

	</fieldset>

<?php $this->endWidget(); ?>

<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScript(__FILE__,"
    
    $('#ItemType_is_child').live('click', function() {
        if($(this).is(':checked'))
            $('div#radioButtonList').show();
        else
            $('div#radioButtonList').hide();

    });
    
    function uncheckRadioButtonList(){
    }    
    
    ", CClientScript::POS_READY
);    
?> 
