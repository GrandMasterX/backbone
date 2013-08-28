<!DOCTYPE html>
<html lang="en" xmlns:fb="http://ogp.me/ns/fb#">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo Yii::t('index', 'AstraFit'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php
        $app=Yii::app();
        $baseUrl=$app->baseUrl;
    ?>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo $baseUrl?>.'/static/bootstrap/front/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="<?php echo $baseUrl?>/static/img/favicon.ico">
  </head>
  <body>
    <!--facebook Like button-->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>  
  
    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Begin page content -->
      <div class="container">
        <div class="page-header">
            <div class="masthead">
                <ul class="nav nav-pills pull-right">
                  <?php if(!Yii::app()->user->isGuest):?>
                      <li class="dropdown user-email <?php if (Helper::getRoutePartsForModuleAndController() == 'site/mydata'): ?> active <?php endif ?>">
                            <a class="dropdown-toggle user-link"
                               data-toggle="dropdown"
                               href="#"
                               title=<?php Yii::t('index', 'Кабинет')?>>
                               <?php echo CHtml::encode(Yii::app()->user->email);?>
                               <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li class=""><?php echo CHtml::link(Yii::t('index', CHtml::encode('Мои размеры')),Yii::app()->createUrl('site/mydata', array('size'=>true)),array('class'=>'top-menu','title'=>Yii::t('index', 'Мои размеры'))); ?></li>
                                <li class=""><?php echo CHtml::link(Yii::t('index', CHtml::encode('Личные данные')),Yii::app()->createUrl('site/mydata', array('private'=>true)),array('class'=>'top-menu','title'=>Yii::t('index', 'Личные данные'))); ?></li>
                            </ul>
                            <li><?php echo CHtml::link(Yii::t('index', CHtml::encode('Выход')), Yii::app()->createUrl('site/logout', array('code'=>Yii::app()->request->getQuery('code'))),array('class'=>'top-menu','title'=>Yii::t('index', 'Выход'))); ?></li>
                      </li>                  
                  <?php endIf; ?>
                </ul>
                <h3 class="muted"><a href="<?php echo Yii::app()->createUrl('site/index'); ?>"><img src="<?php echo $baseUrl?>/static/img/astra-fit-logo-small.png" width="45" height="41"></a></h3>
            </div>
        </div>
            
            <div class="language-holder left">
                  <ul class="">
                      <?php echo CHtml::beginForm('', '', array('class'=>'nav marg')); ?>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo (isset(Yii::app()->user->currentLanguageTitle)) ?  CHtml::encode(Yii::app()->user->currentLanguageTitle) : CHtml::encode(Yii::app()->params['currentLanguageTitle']); ?><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                              <?php $models = Language::model()->visible()->findAll(); ?>
                              <?php foreach ($models as $model): ?>
                                <li><a href="<?php echo Yii::app()->createUrl('site/changeLanguage', array('language'=>$model->code, 'currentLanguageTitle'=>$model->title, Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken));?>"><?php echo CHtml::encode($model->title); ?></a></li>
                              <?php endForeach ?>
                            </ul>
                          </li>
                      <?php echo CHtml::endForm(); ?>                 
                  </ul>
            </div>

            <div class="like-holder right">                        
            <!--like button-->
                <fb:like href="https://www.facebook.com/pages/Astra-Fit/461825663894545" send="false" layout="button_count" width="115" show_faces="false" font="arial"></fb:like>
            </div>
            <div class="clear"></div>
            
            <?php $this->widget('Breadcrumbs',array(
                'tagName'=>'ul',
                'separator'=>'',
                'htmlOptions'=>array('class'=>'breadcrumb result'),
                'links'=>$this->breadcrumbs,
            )); ?>
        <?php echo $content; ?>    
      </div>

      <div id="push"></div>
    </div>

    <div id="footer">
      <div class="container">
        <p class="muted credit"><?php echo Yii::t('index', 'Все права защищены. AstraFit'); ?></p>
      </div>
    </div>

    <?php $this->renderPartial('//layouts/reformal');?>
    <?php $this->renderPartial('//layouts/gAnalytics');?>    
    
  </body>
</html>

<?php
$app->clientScript
    ->registerCoreScript('jquery')
    ->registerCssFile($baseUrl.'/static/css/reset.css')
    ->registerCssFile($baseUrl.'/static/css/main.css')
    ->registerCssFile($baseUrl.'/static/bootstrap/front/css/bootstrap.css')
    ->registerCssFile($baseUrl.'/static/bootstrap/front/css/bootstrap-responsive.css')
    ->registerScriptFile($baseUrl.'/static/bootstrap/js/bootstrap.all.js');
?>

<script type="text/javascript">
    function PopupWindowCenter(URL, title,w,h)
    {
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2)-50;
        var newWin = window.open (URL, title, 'toolbar=no, location=no,directories=no, menubar=no, status=no, scrollbars=yes, resizable=0,copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
    }
</script>
