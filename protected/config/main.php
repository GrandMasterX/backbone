<?php
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');

return array(
    'name' => 'AstraFit',
    'sourceLanguage' => 'ru',
    'language' => 'ru',
    'defaultController' => 'site/index',
    'preload' => array('log', 'languageManager'),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
        'application.extensions.chosen.Chosen',
        'application.extensions.sweekit.Sweeml',
        'application.extensions.MobileDetect.Mobile_Detect',
        'application.extensions.calc.eqEOS',
        'application.vendors',
        'ext.yii-mail.YiiMailMessage',
        'ext.imperavi-redactor-widget.ImperaviRedactorWidget',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '1234567',
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'clevertechYiiBooster.gii'
            ),
        ),
        'admin' => array(
            'defaultController' =>'user',
        ),
        'mailingList'=>array(
            'defaultController'=>'email',
        ),
    ),
	'components'=>array(
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>YII_DEBUG,
			'rules'=>array(
                'musthave/<id>'=>'musthave/index',
                'consultant'=>'admin/consultant',
                '<controller>/<action>'=>'<controller>/<action>',
			),
		),
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'defaultRoles' => array('guest'),
            'itemTable'=>'auth_item',
            'itemChildTable'=>'auth_item_self_assn',
            'assignmentTable'=>'auth_item_user_assn',
        ),
//        'bootstrap'=>array(
//            'class'=>'bootstrap.extensions.Bootstrap',
//        ),
        'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
        ),
        //'session' => array(
        //'timeout' => 86400,
        //),
        'request' => array(
            'class' => 'HttpRequest',
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
            'noCsrfValidationRoutes' => array('admin/item', 'register/SaveComment'),    ///, 'logg/History'
        ),
        'languageManager' => array(
            'class' => 'DbLanguageManager',
        ),
        'db' => require('db.php'),
        'user' => array(
            'allowAutoLogin' => true,
            'class' => 'WebUser',
            'identityClass' => 'User',
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'clientScript' => array(
            'behaviors' => array(
                'sweelixClientScript' => array(
                    'class' => 'ext.sweekit.behaviors.SwClientScriptBehavior',
                ),
            ),
        ),
        'messages' => array(
            'class' => 'CDbMessageSource',
            'sourceMessageTable' => 'sourceMessage',
            'translatedMessageTable' => 'message',
        ),
        'log' => array(
            'class' => 'LogRouter',
            'routes' => YII_DEBUG ? array(
                array(
                    'class'=>'DbLogRoute',   // DbLogRoute       LALogRoute
                    'levels'=>'info, error, warning, trace, profile',
                ),
                array(
                    'class' => 'CEmailLogRoute',
                    'levels'=>'error',                  //'categories'
                    'emails' => array('moneystream@mail.ru', 'o.turansky@gmail.com'),
                    'sentFrom' => 'error_log@astrafit.com.ua',
                    'subject' => 'Error at astrafit.com.ua'
                ),
                array(
                    'class' => 'CWebLogRoute',
                    'levels'=>'trace, info, error, warning, profile',   //vardump,
                    ///'categories'=>'system',   ///'system.db.CDbCommand',
                    'showInFireBug'=>true,
                    'collapsedInFireBug'=>1,
                ),
                array(
                    'class' => 'CProfileLogRoute',
                    'enabled' => true,
                    'showInFireBug'=>true,
                    'collapsedInFireBug'=>1,
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error,warning,info',
                    ///'categories' => 'system',
                ),
                    ) : array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error,warning',
                    'categories' => 'system',
                ),
                array(
                    'class'=>'DbLogRoute',
                    'levels'=>'info, error, warning, trace, profile',
                ),
                array(
                    'class' => 'CEmailLogRoute',
                    'levels'=>'error, warning',
                    'emails' => array('moneystream@mail.ru', 'o.turansky@gmail.com'),
                    'sentFrom' => 'error_log@astrafit.com.ua',
                    'subject' => 'Error at astrafit.com.ua'
                ),
            ),
        ),
       'cache' =>  array(
            'class' => 'CFileCache',
            'cachePath' => 'protected/runtime/cache',
        ),
        'image' => array(
            'class' => 'ext.image.ImageComponent',
            'driver' => 'Gd',
        ),
        'mail' => array(
             'class' => 'ext.yii-mail.YiiMail',
             'transportType' => 'php',
             'viewPath' => 'application.views.mail',
             'logging' => false,
             'dryRun' => false
         ),
    ),
    'params' => array(
        'adminEmail' => 'dobrynina@astrafit.com',
        'loginDuration' => 3600 * 24 * 30,
        'minPasswordLength' => 6,
        'address' => 'Moscow',
        'defaultLanguage' => 'Рус',
        'defaultPageSize' => 50,
        'sizeOptions' => array(10, 25, 50, 100, 200, 500, 1000, 3000),
        'currentLanguageTitle' => 'Рус',
    ),
);
