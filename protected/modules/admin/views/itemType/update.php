<?php
$this->pageTitle=Yii::t('language', 'Редактирование типа изделия');

$this->breadcrumbs=array(
	Yii::t('language', 'Управление типами изделий')=>array('index'),
	$this->pageTitle,
);
?>
<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="language-form" class="wide form">
<?php $this->renderPartial('_form', array(
        'model'=>$model,
        'movoToSize'=>'size_pos',
    )); ?>
</div>
