<?php
$this->pageTitle=Yii::t('Logging', 'Лог системных событий');

$this->breadcrumbs=array(
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<?php
$this->widget('ext.yii-loganalyzer.LogAnalyzerWidget',
    array( 'filters' => array(),    ///'Текст для фильтрации','И еще одно'
           'title' => 'Анализатор логов', // заголовок виджета
           ///'log_file_path' => 'protected/runtime/application.log'
    ));  
?>
</div>