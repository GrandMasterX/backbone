<?php
$this->pageTitle=Yii::t('mailingList', 'Добавление получателей в email рассылку');

$this->breadcrumbs=array(
	Yii::t('mailingList', 'Управление email рассылками')=>array('index'),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php $this->renderPartial('_grid_user',array('users'=>$users,'mlid'=>$mlid,'filtersForm'=>$filtersForm));?>
