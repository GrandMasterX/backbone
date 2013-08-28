<?php
$this->pageTitle=Yii::t('itemSize', 'Управление размерами всех изделий');

$this->breadcrumbs=array(
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php
$this->renderPartial('_grid',array(
	'dataProvider'=>$dataProvider,
	'search'=>$search,
));
?>
</div>