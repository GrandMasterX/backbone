<?php
$this->pageTitle=Yii::t('translation', 'Создание перевода');

$this->breadcrumbs=array(
	Yii::t('translation', 'Управление переводами')=>array('index?languageTab=' . $model->language),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>
<?php $this->renderPartial('_form', array(
    'model'=>$model
    )); ?>

</div>