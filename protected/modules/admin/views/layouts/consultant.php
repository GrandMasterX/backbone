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
      <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/static/css/ie.css" />
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
                <ul class="nav nav-pills pull-right">
                  <?php if(!Yii::app()->user->isGuest):?>
                      <li><?php echo CHtml::link(Yii::t('index', CHtml::encode('Назад')), Yii::app()->controller->createUrl('index',array('parent_id'=>4,'lastuserid'=>Yii::app()->request->getQuery('lastuserid'))),array('class'=>'top-menu','title'=>Yii::t('index', 'Выход'))); ?></li>
                  <?php endIf; ?>
                </ul>
                <h3 class="muted"><a href="<?php echo Yii::app()->createUrl('site/index'); ?>"><img src="<?php echo $baseUrl?>/static/img/astra-fit-logo-small.png" width="45" height="41"></a></h3>
            </div>
        </div>

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
    ->registerScriptFile($baseUrl.'/static/js/main.js')
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
