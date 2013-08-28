<?php
$this->pageTitle=Yii::t('clientSize', 'Управление наименованиями оценочных формул');

$this->breadcrumbs=array(
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php
echo CHtml::link(Yii::t('resFormulaTitle', 'Создать наименование оценочной формулы'), 
        Yii::app()->controller->createUrl('create'), 
        array('class'=>'btn btn-primary btn-wrap')
    );

$this->renderPartial('_grid',array(
	'dataProvider'=>$dataProvider,
	'search'=>$search,
));
?>
</div>