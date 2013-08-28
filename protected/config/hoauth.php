<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

$runtimeUrl=Yii::app()->runtimePath;
$debugFile=$runtimeUrl.'/debug_errors.txt';
/*
http://localhost/astrafit/
http://localhost/astrafit/register/
http://localhost/astrafit/register/index/
http://localhost/astrafit/register/oauth/
http://localhost/astrafit/register/oauth?hauth.done=Google
http://astrafit.com.ua/register/index
http://astrafit.com.ua/register/oauth
http://www.astrafit.com.ua/register/oauth
http://www.astrafit.com.ua/register/index
http://astrafit.com.ua/register/oauth?hauth.done=Google
http://www.astrafit.com.ua/register/oauth?hauth.done=Google*/
return 
	array(
		//"base_url" => "http://localhost/astrafit/register/oauth",
        "base_url" => "http://www.astrafit.com.ua/register/oauth",
		"providers" => array (
			// openid providers
			"OpenID" => array (
				"enabled" => false,
			),

			"AOL"  => array ( 
				"enabled" => false,
			),

			"Yahoo" => array ( 
				"enabled" => false,
				"keys"    => array ( "id" => "#YAHOO_APPLICATION_APP_ID#", "secret" => "#YAHOO_APPLICATION_SECRET#" )
			),

			"Google" => array ( 
				"enabled" => true,
				//"keys"    => array ( "id" => "569502181756-tlavulf7jupnu66asta1ohuf4koe3grj.apps.googleusercontent.com", "secret" => "GrWGVbCGBa_AIkdRVQB19Sna" ),
                "keys"    => array ( "id" => "121482514649-tqusc08nruffclrp938c8a819sjfmcj1.apps.googleusercontent.com", "secret" => "zC1tUhrxKuhADL5OdMimCNos" ),
                                "scope"   => "https://www.googleapis.com/auth/userinfo.profile ". // optional
                                "https://www.googleapis.com/auth/userinfo.email"   , // optional
                                "access_type"     => "offline",   // optional
                                "approval_prompt" => "auto",     // optional
			),
                    
            "Vkontakte" => array (
				"enabled" => true,
				"keys"    => array ( "id" => "3792586", "secret" => "VY2T0rp0SMkHtyRmrTSJ" ),
                                "scope"   => "notifications,offline,wall,first_name,friends,email,notify,mail,last_name,nickname,screen_name,sex,bdate,timezone,photo_rec,photo_big",
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "689556884392541", "secret" => "5af00ac919412ac2dcaa416e29adeec3" ),
                                "scope"   => "email, user_about_me, user_birthday, user_hometown, user_website, offline_access, read_stream, publish_stream, read_friendlists", // optional
                                //"display" => "popup" // optional
			),

			"Twitter" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "#TWITTER_APPLICATION_KEY#", "secret" => "#TWITTER_APPLICATION_SECRET#" ) 
			),

			// windows live
			"Live" => array ( 
				"enabled" => false,
				"keys"    => array ( "id" => "#LIVE_APPLICATION_APP_ID#", "secret" => "#LIVE_APPLICATION_SECRET#" ) 
			),

			"MySpace" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "#MYSPACE_APPLICATION_KEY#", "secret" => "#MYSPACE_APPLICATION_SECRET#" ) 
			),

			"LinkedIn" => array ( 
				"enabled" => false,
				"keys"    => array ( "key" => "#LINKEDIN_APPLICATION_KEY#", "secret" => "#LINKEDIN_APPLICATION_SECRET#" ) 
			),

			"Foursquare" => array (
				"enabled" => false,
				"keys"    => array ( "id" => "#FOURSQUARE_APPLICATION_APP_ID#", "secret" => "#FOURSQUARE_APPLICATION_SECRET#" ) 
			),
		),

        "debug_mode" => true,
        "debug_file" => $debugFile,

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
	);
