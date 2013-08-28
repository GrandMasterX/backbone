<?php
$this->pageTitle=Yii::t('mailingList', 'Создание email рассылки');

$this->breadcrumbs=array(
	Yii::t('mailing-list', 'Управление email рассылками')=>array('index'),
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php $this->renderPartial('_form',array('model'=>$model));?>
