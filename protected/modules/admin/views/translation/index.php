<?php
$this->pageTitle=Yii::t('language', 'Управление переводами');

$this->breadcrumbs=array(
	$this->pageTitle,
);
?>

<div class="sectionTitle"><?php echo CHtml::encode($this->pageTitle); ?></div>

<div id="tab-holder">
    <?php $this->renderPartial('_tabs', array('tabs'=>$tabs)); ?>
</div>

<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScript(__FILE__,"

     $('a.langLink').live('click', function() {
          sizePerPage = $('div.sizer').find('select option:selected').text();
          jQuery.ajax({
            type: 'GET',
            url: '".Yii::app()->controller->createUrl('index',array('ajaxTabReload'=>'translation-grid'))."',
            data: {languageTab:$(this).attr('id'), size:sizePerPage},
            success: function(data){
                $('div#tab-holder').html(data);
            }
          });
      })    
    
    ", CClientScript::POS_READY
);    
?> 