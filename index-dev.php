<?php
$yii='framework/yii_1_1_13/framework/yii.php';
//$yii='framework/yii.php';
$config='protected/config/main.php';
define('YII_DEBUG',true);
define('YII_TRACE_LEVEL',3);
require($yii);
Yii::createWebApplication($config)->run();