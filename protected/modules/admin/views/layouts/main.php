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
            <a class="brand" href="<?php echo Yii::app()->controller->createUrl('/admin/user/index')?>"><?php echo CHtml::encode(Yii::app()->name); ?></a>
            <div class="nav-collapse collapse navbar-responsive-collapse">
                <ul class="nav">
                  <li class="divider-vertical"></li>
                  <!--<li class="active"><a href="#">Home</a></li>-->
                  <li class="<?php if (Helper::getRoutePartsForModuleAndController() == 'admin/user'): ?> active <?php endif ?>"><a href="<?php echo Yii::app()->controller->createUrl('/admin/user/index')?>"><?php echo Yii::t('menu', 'Пользователи') ?></a></li>
                  <li class="<?php if (Helper::getRoutePartsForModuleAndController() == 'admin/partner'): ?> active <?php endif ?>"><a href="<?php echo Yii::app()->controller->createUrl('/admin/partner/index')?>"><?php echo Yii::t('menu', 'Партнеры') ?></a></li>

                    <li class="dropdown <?php if (Helper::getRoutePartsForModuleAndController() == 'admin/client'): ?> active <?php endif ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Yii::t('client', 'Клиенты'); ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/client/index')?>"><?php echo Yii::t('client', 'База клиентов'); ?></a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/logg')?>"><?php echo Yii::t('client', 'Лог событий'); ?></a></li>
                            <li class="divider"></li>
                            <li class="nav-header"><?php echo Yii::t('client', 'Параметры'); ?></li>
                            <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/clientSize/index')?>"><?php echo Yii::t('item', 'Размеры'); ?></a></li>
                        </ul>
                    </li>

                    <li class="dropdown <?php if (Helper::getRoutePartsForModuleAndController() == 'admin/item'): ?> active <?php endif ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Yii::t('item', 'Изделия'); ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/item/index')?>"><?php echo Yii::t('item', 'База изделий'); ?></a></li>
                      <li class="divider"></li>
                      <li class="nav-header"><?php echo Yii::t('item', 'Параметры'); ?></li>
                      <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/itemType/index')?>"><?php echo Yii::t('item', 'Типы'); ?></a></li>
                      <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/itemSize/index')?>"><?php echo Yii::t('item', 'Размеры'); ?></a></li>
                      <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/itemSource/index')?>"><?php echo Yii::t('item_source', 'Синхронизация с нетбуком'); ?></a></li>
                    </ul>
                  </li>
                  
                  <li class="dropdown <?php if (Helper::getRoutePartsForModuleAndController() == 'admin/formula'): ?> active <?php endif ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Yii::t('formula', 'Формулы'); ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/formula/index')?>"><?php echo Yii::t('formula', 'Подбор изделий'); ?></a></li>
                      <li class="divider"></li>
                      <li class="nav-header"><?php echo Yii::t('item', 'Параметры'); ?></li>
                      <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/resFormulaTitle/index')?>"><?php echo Yii::t('formula', 'Наименования оценочных формул'); ?></a></li>
                    </ul>
                  </li>
                  
                  <li class="<?php if (Helper::getRoutePartsForModuleAndController() == 'mailingList/email'): ?> active <?php endif ?>"><a href="<?php echo Yii::app()->controller->createUrl('/mailingList/email/index')?>"><?php echo Yii::t('menu', 'Рассылки') ?></a></li>                   
                  
                </ul>
                <ul class="nav pull-right">
                  <?php echo CHtml::beginForm('', '', array('class'=>'nav')); ?>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                            <?php echo (isset(Yii::app()->user->language)) ? (isset(Yii::app()->languageManager->languages[Yii::app()->user->language]))
                                ? CHtml::encode(Yii::app()->languageManager->languages[Yii::app()->user->language])
                                : (isset(Yii::app()->languageManager->languages[Yii::app()->language]))
                                    ? CHtml::encode(Yii::app()->languageManager->languages[Yii::app()->language])
                                    : CHtml::encode(Yii::app()->params['defaultLanguage'])
                                : CHtml::encode(Yii::app()->params['defaultLanguage']);?>

                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <?php foreach (Yii::app()->languageManager->languages as $key=>$language): ?>
                            <li><?php echo CHtml::link(CHtml::encode($language), '#', array('submit' => array('/admin/default/changeLanguage', 'language'=>$key, 'currentLanguageTitle'=>$language, Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken)));?></li>
                          <?php endForeach ?>
                        </ul>
                      </li>
                  <?php echo CHtml::endForm(); ?> 
                  <li class="divider-vertical"></li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="icon-cog"></span><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/settings/index', array('param'=>true))?>"><?php echo Yii::t('settings', 'Параметры'); ?></a></li>
                      <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/translation/index')?>"><?php echo Yii::t('settings', 'Переводы'); ?></a></li>
                      <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/language/index')?>"><?php echo Yii::t('settings', 'Языки'); ?></a></li>
                      <li class="divider"></li>
                      <li><a href="<?php echo Yii::app()->controller->createUrl('/admin/settings/index')?>"><span class="icon-wrench"></span><span style="margin-left:5px"></span><?php echo Yii::t('settings', 'Настройки'); ?></a></li>
                    </ul>
                  </li>
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
    ->registerCssFile($baseUrl.'/static/admin/reset.css')
    ->registerCssFile($baseUrl.'/static/admin/main.css')
    ->registerCssFile($baseUrl.'/static/admin/form.css')
    ->registerCssFile($baseUrl.'/static/bootstrap/css/bootstrap.all.css')
    ->registerCssFile($baseUrl.'/static/bootstrap/css/bootstrap.form.css')
    ->registerScriptFile($baseUrl.'/static/bootstrap/js/bootstrap.all.js')
    ->registerScriptFile($baseUrl.'/static/js/garand-sticky/jquery.sticky.js')
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

        $('#statusMsg').sticky({topSpacing:0,center:true,});

", CClientScript::POS_READY
);    
?>    
    <!--animate flash messages container END-->
    <!--flash messages container START-->
    <div id="statusMsg">
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
