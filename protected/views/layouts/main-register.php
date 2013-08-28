<!DOCTYPE html>
<html lang="en">
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

    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Begin page content -->
      <div class="container">
        <div class="page-header">
            <div class="masthead">
                <h3 class="muted"><img src="<?php echo $baseUrl?>/static/img/astra-fit-logo-small.png" width="45" height="41"></h3>
            </div>
        </div>

            <div class="language-holder">
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
        
            <?php $this->widget('Breadcrumbs',array(
                'tagName'=>'ul',
                'separator'=>'',
                'htmlOptions'=>array('class'=>'breadcrumb'),
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
    ->registerScriptFile($baseUrl.'/static/admin/debug/print_r.js')
    ->registerScriptFile($baseUrl.'/static/js/vimeo/froogaloop.min.js')    
    ->registerScriptFile($baseUrl.'/static/js/vimeo.js')
    ->registerScriptFile($baseUrl.'/static/bootstrap/js/bootstrap.all.js');         
?>
