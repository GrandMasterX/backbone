<?php
$this->pageTitle=Yii::t('Page', 'Создание страницы');

$this->breadcrumbs=array(
	Yii::t('Page', 'Управление страницами')=>array('index'),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="user-form" class="wide form_page_create">
<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'create-user-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions'=>array(
                'class'=>'form-horizontal',
                'width'=>'250px',
                ),
            )); ?>

	<fieldset>
		<legend><span class="left-margin"><?php echo Yii::t('formGeneral', 'Основная информация')?></legend>

		<div class="control-group">
			<?php echo $form->labelEx($model,'title', array('class'=>'control-label')); ?>
			<div class="controls">
                <?php echo $form->textField($model,'title',array('size'=>40)); ?>
			    <?php echo $form->error($model,'title'); ?>
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
            <?php echo $form->labelEx($model,'pages_id', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo Chosen::activeDropDownList($model, 'pages_id', CHtml::listData(Pages::model()->notBlocked()->findAll(array('order'=>'name')), 'id', 'name'),
                    array('empty'=>Yii::t('page', 'Выберите из списка'))); ?>
                <?php echo $form->error($model,'pages_id'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model,'body', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                    $this->widget('ImperaviRedactorWidget', array(
                        // You can either use it for model attribute
                        'model' => $model,
                        'attribute' => 'body',
                        'htmlOptions' => array(
                            'style' => 'height:150px;width:250px;'
                        ),

                        // or just for input field
                        'name' => 'body',

                        // Some options, see http://imperavi.com/redactor/docs/
                        'options' => array(
                        'lang' => 'ru',
                        'iframe'=>true,
                        'toolbar' => true,
                        'resize'=>true,
                        'css' => 'redactor-iframe.css',
                        ),
                    ));
                ?>
            </div>
        </div>

		<div class="control-group">
			<div class="controls">
                <?php echo CHtml::submitButton(Yii::t('Pages', 'Создать'), array('class'=>'btn btn-success')); ?>
                <?php echo CHtml::link(Yii::t('Pages', 'Отмена'), Yii::app()->controller->createUrl('index'), array('class'=>'btn'))?>
            </div>
		</div>

	</fieldset>

<?php $this->endWidget(); ?>

