<?php
$this->pageTitle=Yii::t('Logging', 'Лог событий');

$this->breadcrumbs=array(
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php
$this->renderPartial('_grid',array(
	'dataProvider'=>$dataProvider,
    'filtersForm' => $filtersForm,
));
?>
</div>