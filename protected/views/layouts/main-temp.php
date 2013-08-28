<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <?php
        $app=Yii::app();
        $baseUrl=$app->baseUrl;
    ?>
<link rel="shortcut icon" href="<?php echo $baseUrl?>/static/img/favicon.ico">
<title><?php echo Yii::t('index', 'AstraFit'); ?></title>
</head>
<body>
<div class="main">
	<div class="content">
		<?php echo $content; ?>
	</div>
</div>

<?php $this->renderPartial('//layouts/reformal');?>   

</body>
</html>
<?php
$app=Yii::app();
$baseUrl=$app->baseUrl;

$app->clientScript
	->registerCssFile($baseUrl.'/static/css/reset.css')
	->registerCssFile($baseUrl.'/static/css/style.css')
    ->registerCssFile($baseUrl.'/static/bootstrap/css/bootstrap.headings.body.etc.css')
    ->registerCssFile($baseUrl.'/static/bootstrap/css/bootstrap.buttons.css')
    ->registerCssFile($baseUrl.'/static/bootstrap/css/bootstrap.form.css');
?>