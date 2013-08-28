<?php
$this->pageTitle=Yii::t('item', 'Управление изделиями');

$this->breadcrumbs=array(
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php
echo CHtml::link(Yii::t('item', 'Создать изделие'), 
        Yii::app()->controller->createUrl('create'), 
        array('class'=>'btn btn-primary btn-wrap')
    );
$this->renderPartial('_grid',array(
	'dataProvider'=>$dataProvider,
    'filtersForm' => $filtersForm,
));
?>
</div>