<?php
$this->pageTitle=Yii::t('clientSize', 'Редактирование размера клиента');

$this->breadcrumbs=array(
	Yii::t('clientSize', 'Управление размерами клиента')=>array('index'),
	$this->pageTitle,
);
?>
<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="language-form" class="wide form">
<?php $this->renderPartial('_form', array(
        'model'=>$model
    )); ?>
</div>
