<?php
$this->pageTitle=Yii::t('mailingList', 'Редактирование клиента');

$this->breadcrumbs=array(
	Yii::t('mailingList', 'Управление клиентами')=>array('index'),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php $this->renderPartial('_form',array('model'=>$model));?>