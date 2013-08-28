<?php            
$this->pageTitle=(Yii::app()->session['param']) ? Yii::t('settings', 'Управление параметрами') : Yii::t('settings', 'Управление настройками');

$this->breadcrumbs=array(
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php
echo CHtml::link(Yii::t('adminUser', (Yii::app()->session['param']) ? Yii::t('settings', 'Создать параметр') : Yii::t('settings', 'Создать настройку')), 
        (Yii::app()->session['param']) ? Yii::app()->controller->createUrl('create', array('param'=>Yii::app()->session['param'])) : Yii::app()->controller->createUrl('create'), 
        array('class'=>'btn btn-primary btn-wrap')
    );

$this->renderPartial('_grid',array(
	'dataProvider'=>$dataProvider,
	'search'=>$search,
));
?>
</div>