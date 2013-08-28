<?php
$this->pageTitle=Yii::t('adminUser', 'Управление импортом/экспортом Ексель файлов');

$this->breadcrumbs=array(
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>
<?php
    $this->renderPartial('upload',array(
            'model'=>$model
        )
    );
?>
</div>