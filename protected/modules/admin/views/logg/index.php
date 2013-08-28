<?php
$this->pageTitle=Yii::t('Logging', 'Лог событий');

$this->breadcrumbs=array(
	$this->pageTitle,
);
?>

<div style="float:right;"><?php 
echo CHtml::ajaxLink( 'сегодня', 'logg/History', $this->HistoryAjax( 0 ));     echo "  |  ";
echo CHtml::ajaxLink( '3 дня', 'logg/History', $this->HistoryAjax( 2 ));       echo "  |  ";
echo CHtml::ajaxLink( 'неделя', 'logg/History', $this->HistoryAjax( 6 ));      echo "  |  ";
echo CHtml::ajaxLink( '2 недели', 'logg/History', $this->HistoryAjax( 13 ));   echo "  |  ";
echo CHtml::ajaxLink( 'месяц', 'logg/History', $this->HistoryAjax( 31 ));
?></div>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'select-date-log',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>false,  //true
            ),
            'htmlOptions'=>array(
                'class'=>'form-horizontal'
                ),
            )); ?>
           
<div class="control-group" style="float: right;">Задайте даты: c 
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'dateFrom',
    'attribute'=>'dateFrom',
    'language'=>'ru',
    'value'=>"$dateFrom",
    'options'=>array(       // additional javascript options for the date picker plugin
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?>
 по
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'name'=>'dateTo',
    'attribute'=>'dateTo',
    'language'=>'ru',
    'value'=>"$dateTo",
    'options'=>array(       // additional javascript options for the date picker plugin
        'showAnim'=>'fold',
        'dateFormat'=>'yy-mm-dd',
    ),
    'htmlOptions'=>array(
        'style'=>'height:20px;'
    ),
));
?>

<?php echo CHtml::submitButton(Yii::t('filterLog', 'Фильтровать'), array('class'=>'btn btn-success')); ?>
</div>

<?php $this->endWidget(); ?>

<?php
///if ($level) echo "<pre><br>LEVEL <br>";    print_r( $level );     die;
$this->renderPartial('_grid',array(
    'level' => @$level,
	'dataProvider'=>$dataProvider,
    'search'=>$search,
));
?>
</div>