<?php
$this->pageTitle=Yii::t('consultant', 'Управление клиентами');

$this->breadcrumbs=array(
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php
echo CHtml::link(Yii::t('consultant', 'Создать клиента'),
        Yii::app()->controller->createUrl('create'), 
        array('class'=>'btn btn-primary btn-wrap')
    );
if(!is_null(Yii::app()->request->getQuery('lastuserid'))) {
    echo CHtml::link(Yii::t('consultant', 'Подбор изделий по последнему пользователю'),
        Yii::app()->controller->createUrl('suitableItems',array('parent_id'=>4,'lastuserid'=>Yii::app()->request->getQuery('lastuserid'))),
        array('class'=>'btn btn-success btn-wrap', 'target'=>'_blank')
    );
}

$this->renderPartial('_grid',array(
	'dataProvider'=>$dataProvider,
	'search'=>$search,
));
?>
</div>