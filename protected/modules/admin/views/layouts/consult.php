<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="ru" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->baseUrl; ?>/favicon.ico" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div id="wrap">
<div class="navbar" style="margin-bottom:10px !important">
    <div class="navbar-inner" style="height:40px !important">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>    
            <a class="brand" href="<?php echo Yii::app()->controller->createUrl('/admin/consultant/index')?>"><?php echo CHtml::encode(Yii::app()->name); ?></a>
                <div class="nav-collapse collapse navbar-responsive-collapse">
                <ul class="nav">
                  <li class="divider-vertical"></li>
                  <li class="active hide-link"><a href="#"><?php echo Yii::t('consult','Консультант: '); echo Chtml::encode(Yii::app()->user->name)?></a></li>
                </ul>
                <ul class="nav pull-right">
                <li class="divider-vertical"></li>
                  <?php if(Yii::app()->user->isGuest):?>
                    <li><a href="<?php echo Yii::app()->controller->createUrl('/site/login')?>"><?php echo Yii::t('menu', 'Вход') ?></a></li>
                  <?php else: ?>
                    <li><a href="<?php echo Yii::app()->controller->createUrl('/site/logout')?>"><?php echo Yii::t('menu', 'Выход') ?></a></li>
                  <?php endif ?>                  
                </ul>                
            </div>
        </div>
    </div>
</div><!--Header-->

<!--animate flash messages container START-->  
    <?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerCoreScript('jquery')
    ->registerScriptFile($baseUrl.'/static/admin/stickyScroller/StickyScroller.min.js')
    ->registerScriptFile($baseUrl.'/static/admin/stickyScroller/GetSet.js')
    ->registerScript(__FILE__,"
    $('div#success').animate({opacity: 1.0}, 3000).fadeOut('slow');
    $('div#alert').animate({opacity: 1.0}, 3000).fadeOut('slow');
    $('div#error').animate({opacity: 1.0}, 3000).fadeOut('slow');
    
    //is used to prepend message block on ajax actions
    function showMessage(data) {
        $('#statusMsg').prepend(data);
        $('#statusMsg div:first-child').show().animate({opacity: 1.0}, 3000).fadeOut('slow', function(){\$(this).remove()});
    }    
    
    $('button.close').live('click', function() {
        $(this).parent('div').stop().fadeOut('slow');
    });
    
    var scroller = new StickyScroller('#statusMsg',
    {
        start: 80,
        end: 1000,
        margin: 1,
    });            
    
    ", CClientScript::POS_READY
);    
?>    
    <!--animate flash messages container END-->
    
    <!--flash messages container START-->
    <div id="statusMsg" class="sticky">
        <?php echo $this->renderPartial('/layouts/messages/_message_success', array());?>
        <?php echo $this->renderPartial('/layouts/messages/_message_error', array());?>
        <?php echo $this->renderPartial('/layouts/messages/_message_alert', array());?>  
    </div>    
    <!--flash messages container END-->
    
    <?php $this->widget('Breadcrumbs',array(
        'tagName'=>'ul',
        'separator'=>'',
        'htmlOptions'=>array('class'=>'breadcrumb'),
        'links'=>$this->breadcrumbs,
    )); ?>

    <div id="content">
        <?php echo $content; ?>
    </div><!--content-->

</div><!--wrap-->
    <div id="footer">
        Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::link('TurSystem','mailto:o.ts@tursystem.com.ua'); ?>.<br/>
        All Rights Reserved.<br/>
        <?php echo Yii::powered(); ?>
    </div>
</body>
</html>
<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
    ->registerCssFile($baseUrl.'/static/admin/reset.css')
    ->registerCssFile($baseUrl.'/static/admin/main.css')
    ->registerCssFile($baseUrl.'/static/admin/form.css')
    ->registerCssFile($baseUrl.'/static/bootstrap/css/bootstrap.all.css')
    //->registerCssFile($baseUrl.'/static/bootstrap/css/bootstrap.navbar.css')
//    ->registerCssFile($baseUrl.'/static/bootstrap/css/bootstrap.buttons.css')
    //->registerCssFile($baseUrl.'/static/bootstrap/css/bootstrap.modal.css')
    ->registerCssFile($baseUrl.'/static/bootstrap/css/bootstrap.form.css')
//    ->registerScriptFile($baseUrl.'/static/bootstrap/js/bootstrap-modal.js')
    ->registerScriptFile($baseUrl.'/static/bootstrap/js/bootstrap.all.js');
?>