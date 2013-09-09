<!DOCTYPE html>
<html lang="en" class="js flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths">
  <head>
    <?php
      $app=Yii::app();
      $baseUrl=$app->baseUrl;
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo Yii::t('index', 'AstraFit'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <script data-main="<?php echo Yii::app()->request->baseUrl; ?>/static/app/js/main"
              src="<?php echo Yii::app()->request->baseUrl; ?>/static/app/js/libs/require/require.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/static/app/js/utils.js"></script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo $baseUrl?>.'/static/bootstrap/front/js/html5shiv.js"></script>
      <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/static/css/ie.css" />
    <![endif]-->
  </head>
  <body>
    <!-- Part 1: Wrap all page content here -->
    <div class="main_page_bg" style="position: absolute;"></div>
    <div class="wrapper" id="wrapper_hide">
      <!-- Begin page content -->
      <div class="allin">
        <?php echo $content; ?>
      </div>
    </div>
    <div class="modal" style="display: none;"></div>
   <?php $this->renderPartial('/site/modal');?>
   <?php $this->renderPartial('//layouts/gAnalytics');?>
  </body>
</html>

<?php
$app->clientScript
    ->registerCoreScript('jquery')
    ->registerCssFile($baseUrl.'/static/bootstrap/front/css/bootstrap.min.css')
    ->registerCssFile($baseUrl.'/static/css/base.css');
?>


<script type="text/javascript">
    function PopupWindowCenter(URL, title,w,h)
    {
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2)-50;
        var newWin = window.open (URL, title, 'toolbar=no, location=no,directories=no, menubar=no, status=no, scrollbars=yes, resizable=0,copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
    }
</script>
