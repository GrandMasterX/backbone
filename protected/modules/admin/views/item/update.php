<?php
$this->pageTitle=Yii::t('item', 'Редактирование изделия');

$this->breadcrumbs=array(
	Yii::t('item', 'Управление изделиями')=>array('index'),
	$this->pageTitle,
);
?>
<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="language-form" class="wide form" style="width:100%">
<?php $this->renderPartial('_form', array(
        'model'=>$model,
    )); ?>
</div>
