<?php
$yii='framework/yii_1_1_13/framework/yiilite.php';
//$yii='framework/yiilite.php';
$config='protected/config/main.php';

// Логирование работает для localhost-а
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') { 
  defined('YII_DEBUG') or define('YII_DEBUG',true);
} 

require($yii);
Yii::createWebApplication($config)->run();