<?php
echo CHtml::tag('h3',array(),"{$row['message']}");
echo CHtml::tag('h4',array()," (IP={$row['client_ip']} Страна:{$row['country']} Город:{$row['city']} Браузер:{$row['browser']} v.{$row['browser_v']})");
///echo "<pre><br>";  print_r($row);  die; ///$id

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'type'=>'striped bordered',
    'dataProvider' => $gridDataProvider,
    'template' => "{items}",
    'columns' => $gridColumns, ///array_merge(array(array('class'=>'bootstrap.widgets.TbImageColumn')),$gridColumns),
));
?>
