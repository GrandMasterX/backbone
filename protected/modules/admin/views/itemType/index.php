<?php
$this->pageTitle=Yii::t('language', 'Управление типами изделий');

$this->breadcrumbs=array(
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php
echo CHtml::link(Yii::t('adminUser', 'Создать тип изделия'), 
        Yii::app()->controller->createUrl('create'), 
        array('class'=>'btn btn-primary btn-wrap')
    );

$this->renderPartial('_grid',array(
	'dataProvider'=>$dataProvider,
    'model'=>$model,
));
?>
</div>