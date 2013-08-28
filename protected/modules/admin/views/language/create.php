<?php
$this->pageTitle=Yii::t('languager', 'Создание языка');

$this->breadcrumbs=array(
	Yii::t('language', 'Управление языками')=>array('index'),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="language-form" class="wide form">
<?php $this->renderPartial('_form', array(
        'model'=>$model
    )); ?>
</div>
