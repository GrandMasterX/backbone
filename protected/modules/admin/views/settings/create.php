<?php
$this->pageTitle=(Yii::app()->session['param']) ? Yii::t('settings', 'Создание параметра') : Yii::t('settings', 'Создание настройки');

$this->breadcrumbs=array(
	(Yii::app()->session['param']) ? Yii::t('settings', 'Управление параметрами') : Yii::t('settings', 'Управление настройками')=>(Yii::app()->session['param']) ? array('index?param=1') : array('index'),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="language-form" class="wide form">
<?php $this->renderPartial('_form', array(
        'model'=>$model
    )); ?>
</div>
