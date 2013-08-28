<?php
$this->pageTitle=Yii::t('client', 'Создание клиента');

$this->breadcrumbs=array(
	Yii::t('partner', 'Управление клиентами')=>array('index'),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="partner-form" class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'create-client-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'afterValidate'=>'js:function(form,data,hasError){
                        if(!hasError){
                            return true;
                        } else {
                            return true;
                        }
                }'
            ),
            'htmlOptions'=>array(
                'class'=>'form-horizontal'
                ),
            )); ?>

	<fieldset>
		<legend><span class="left-margin"><?php echo Yii::t('formGeneral', 'Основная информация')?></legend>

		<div class="control-group">
			<?php echo $form->labelEx($model,'name', array('class'=>'control-label item-w')); ?>
			<div class="controls item-l-margin">
                <?php echo $form->textField($model,'name',array('size'=>40)); ?>
			    <?php echo $form->error($model,'name'); ?>
            </div>
		</div>

		<div class="control-group">
			<?php echo $form->labelEx($model,'email', array('class'=>'control-label item-w')); ?>
			<div class="controls item-l-margin">
                <?php echo $form->textField($model,'email',array('size'=>40)); ?>

<?php
//                echo CHtml::link(Yii::t('consultant', 'Найти пользователя'),
//                    Yii::app()->controller->createUrl('update'),
//                    array('class'=>'btn btn-primary btn-small')
//                );
?>

			    <?php echo $form->error($model,'email'); ?>
            </div>
		</div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'password', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->passwordField($model,'password',array('size'=>40)); ?>
                <?php echo $form->error($model,'password'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'phone', array('class'=>'control-label item-w')); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($model,'phone',array('size'=>40)); ?>
                <?php echo $form->error($model,'phone'); ?>
            </div>
        </div>
        
    <fieldset>
        <legend><span class="left-margin"><?php echo Yii::t('client', 'Данные о размерах')?></legend>        
        
        <?php foreach($listOfNewClientSizeModels as $i=>$item):?>        
        <div class="control-group">
            <?php echo $form->labelEx($item['model'],"[$i]value", array('class'=>'control-label item-w', 'label'=>$item['label'])); ?>
            <div class="controls item-l-margin">
                <?php echo $form->textField($item['model'],"[$i]value",array('size'=>40)); ?>
                <?php echo $form->error($item['model'],"[$i]value"); ?>
                <?php echo $form->hiddenField($item['model'],"[$i]size_id",array('size'=>40)); ?>
            </div>
        </div>            
        <?php endForeach; ?>
    </fieldset>       

		<div class="control-group">
			<div class="controls item-l-margin">
                <?php echo CHtml::submitButton(Yii::t('client', 'Создать'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('client', 'Отмена'), Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
            </div>
		</div>

	</fieldset>

<?php $this->endWidget(); ?>
</div>
