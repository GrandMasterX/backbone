<?php
ini_set('max_execution_time',0);

return array(
	'basePath'=>dirname(__FILE__).'/..',

	'import'=>array(
		'application.models.*',
        'application.extensions.*',
	),

    'components'=>array(
        'db'=>require('db.php'),
        'image'=>array(
            'class'=>'ext.image.ImageComponent',
        ),
    ),
);