<?php
$this->pageTitle=Yii::t('resFormulaTitle', 'Редактирование наименования оценочной формулы');

$this->breadcrumbs=array(
	Yii::t('resFormulaTitle', 'Управление наименованиями оценочных формул')=>array('index'),
	$this->pageTitle,
);
?>
<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="language-form" class="wide form">
<?php $this->renderPartial('_form', array(
        'model'=>$model
    )); ?>
</div>
