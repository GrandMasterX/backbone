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
        'ext.eoauth.*',
        'ext.eoauth.lib.*',
        'ext.lightopenid.*',
        'ext.eauth.*',
        'ext.eauth.services.*',
        'application.vendors',
        'ext.yii-mail.YiiMailMessage',
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
        'exel' => array(
            'defaultController' =>'index',
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
                'service'=>'site/service',
                'howitworks'=>'site/howitworks',
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
        'loid' => array(
            'class' => 'ext.lightopenid.loid',
        ),
        'mail' => array(
             'class' => 'ext.yii-mail.YiiMail',
             'transportType' => 'php',
             'viewPath' => 'application.views.mail',
             'logging' => false,
             'dryRun' => false
         ),
        'eauth' => array(
            'class' => 'ext.eauth.EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache'.  
            'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
            'services' => array(// You can change the providers and their classes.
//                'google' => array(
//                    'class' => 'GoogleOpenIDService',
//                ),
//                'yandex' => array(
//                    'class' => 'YandexOpenIDService',
//                ),
//                'twitter' => array(
                // register your app here: https://dev.twitter.com/apps/new
//                    'class' => 'TwitterOAuthService',
//                    'key' => '...',
//                    'secret' => '...',
//                ),
                'google_oauth' => array(
                    // register your app here: https://code.google.com/apis/console/
                    'class' => 'CustomGoogleService',
                    'client_id' => '121482514649-7orl2mum6mco54pe33rvl743j9bp2353.apps.googleusercontent.com',
                    'client_secret' => 's19p91oTKTLJvvMKGVEi_kebs',
                    'title' => 'Google (OAuth)',
                ),
//                'yandex_oauth' => array(
                // register your app here: https://oauth.yandex.ru/client/my
//                    'class' => 'YandexOAuthService',
//                    'client_id' => '...',
//                    'client_secret' => '...',
//                    'title' => 'Yandex (OAuth)',
//                ),
                'facebook' => array(
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'CustomFacebookService',
                    'client_id' => '689556884392541',
                    'client_secret' => '5af00ac919412ac2dcaa416e29adeec3',
                ),
//                'linkedin' => array(
                // register your app here: https://www.linkedin.com/secure/developer
//                    'class' => 'LinkedinOAuthService',
//                    'key' => '...',
//                    'secret' => '...',
//                ),
//                'github' => array(
                // register your app here: https://github.com/settings/applications
//                    'class' => 'GitHubOAuthService',
//                    'client_id' => '...',
//                    'client_secret' => '...',
//                ),
//                'live' => array(
                // register your app here: https://manage.dev.live.com/Applications/Index
//                    'class' => 'LiveOAuthService',
//                    'client_id' => '...',
//                    'client_secret' => '...',
//                ),
                'vkontakte' => array(
                    // register your app here: https://vk.com/editapp?act=create&site=1
                    'class' => 'CustomVKontakteService',
                    'client_id' => '3792586',
                    'client_secret' => 'VY2T0rp0SMkHtyRmrTSJ',
                ),
//                'mailru' => array(
            // register your app here: http://api.mail.ru/sites/my/add
//                    'class' => 'MailruOAuthService',
//                    'client_id' => '...',
//                    'client_secret' => '...',
//                ),
//                'moikrug' => array(
            // register your app here: https://oauth.yandex.ru/client/my
//                    'class' => 'MoikrugOAuthService',
//                    'client_id' => '...',
//                    'client_secret' => '...',
//                ),
//                'odnoklassniki' => array(
            // register your app here: http://dev.odnoklassniki.ru/wiki/pages/viewpage.action?pageId=13992188
            // ... or here: http://www.odnoklassniki.ru/dk?st.cmd=appsInfoMyDevList&st._aid=Apps_Info_MyDev
//                    'class' => 'OdnoklassnikiOAuthService',
//                    'client_id' => '...',
//                    'client_public' => '...',
//                    'client_secret' => '...',
//                    'title' => 'Odnokl.',
//                ),
            ),
        ),
        'excel'=>array(
            'class'=>'application.extensions.PHPExcel',
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
