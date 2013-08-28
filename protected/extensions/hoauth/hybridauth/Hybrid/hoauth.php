<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return 
	array(
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
				"keys"    => array ( "id" => "121482514649.apps.googleusercontent.com", "secret" => "5oitHROYiyh-RZpUMM5TTMJ0" )
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "689556884392541", "secret" => "5af00ac919412ac2dcaa416e29adeec3" )
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

		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => true,

		"debug_file" => "http://www.astrafit.com.ua/debug_errors.txt"
	);
