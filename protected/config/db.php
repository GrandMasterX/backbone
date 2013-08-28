<?php
return YII_DEBUG ? array(
    'connectionString'=>'mysql:host=localhost;dbname=astrafit',
    'username'=>'astra_db',
    'password'=>'luL0hIA4',
    'charset'=>'utf8',
    //'autoConnect'=>false,
    //'schemaCachingDuration'=>3600,
    'enableParamLogging'=>true,
    'enableProfiling'=>true,
) : array(
    'connectionString'=>'mysql:host=localhost;dbname=astrafit',
    'username'=>'astra_db',
    'password'=>'luL0hIA4',
    'charset'=>'utf8',
    'schemaCachingDuration'=>3600,
);

