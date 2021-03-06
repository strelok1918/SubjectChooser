<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Subject Chooser',
	'defaultController' => 'user',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.models.DAO.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),

	),

	// application components
	'components'=>array(
		'session' => array(
			'autoStart'=>true,
		),
        'email'=>array(
            'class'=>'application.extensions.email.Email',
            'delivery'=>'php', //Will use the php mailing function.
            //May also be set to 'debug' to instead dump the contents of the email into the view
        ),
		'user'=>array(
//            'class' => 'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin' => 1,
			'loginUrl' => array('user/login'),
		),

		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'gii'=>'gii',
                'register' => 'user/register',
                'login' => 'user/login',
                'recovery' => 'user/recovery',
				'gii/<controller:\w+>'=>'gii/<controller>',
				'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
//				'<controller:\w+>/<action:\w+>/<userId:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',

				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),



//        'log'=>array(
//            'class'=>'CLogRouter',
//            'routes'=>array(
//                    array(
//                        'class'=>'CFileLogRoute',
//                        'categories'=>'system.db.*',
//                        'logFile'=>'sql.log',
//                    ),
//                ),
//            ),
		'db'=>require(dirname(__FILE__).'/database.php'),
		'authManager'=>array(
			'class'=>'CDbAuthManager',
//            'class'=>'PhpAuthManager',
			'connectionID'=>'db',
//            'defaultRoles' => array('guest', 'admin', 'user'),
        ),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'user/error',
		),

//		'log'=>array(
//			'class'=>'CLogRouter',
//			'routes'=>array(
//				array(
//					'class'=>'CWebLogRoute',
////					'levels'=>'error, warning, trace, profile, info',
////					'categories' => 'application'
//				),
				// uncomment the following to show log messages on web pages

//				array(
//					'class'=>'CWebLogRoute',
//				),

//			),
//		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
//		'adminEmail'=>'webmaster@example.com',
	),
);
