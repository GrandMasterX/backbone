<?php
$this->pageTitle=Yii::t('adminUser', 'Управление пользователями');

$this->breadcrumbs=array(
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php
echo CHtml::link(Yii::t('adminUser', 'Создать пользователя'),
        Yii::app()->controller->createUrl('create'), 
        array('class'=>'btn btn-primary btn-wrap')
    );

    $this->renderPartial('_grid',array(
	'dataProvider'=>$dataProvider,
	'search'=>$search,
));
?>
</div>