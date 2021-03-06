 <?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ClockIt',

	// preloading 'log' component
	//'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',	
		'application.modules.admin.models.*',
		'application.modules.home.models.*',
		'application.modules.auditTrail.models.AuditTrail',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'home',
		'admin',
		'auditTrail'=>array(
			'userClass'=>'Users',
			'userIdColumn' => 'id',
			'userNameColumn' => 'email',
			'install'=>true,
			'schemaScript' => 'AuditTrail_initDb_mysql.sql',
			'schemaPath' => 'application.modules.auditTrail.dbSchema',
			
			),
	),
	//'onBeginRequest'=>create_function('$event', 'return ob_start("ob_gzhandler");'),
	//'onEndRequest'=>create_function('$event', 'return ob_end_flush();'),
	// application components
	'components'=>array(
		'widgetFactory'=>array(
            		'widgets'=>array(
                		'CBreadcrumbs'=>array(
				 	'homeLink'=>'ClockIt'
				),
		    	),
		),
		'session' => array(
			'sessionName' => 'Clockit',
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl' => array('/login'),
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'/login'=>'/site/login',
				'/logout'=>'/site/logout',
				'/timeclock'=>'/site/timeclock',
				'/firsttime'=>'/site/firsttime',
				'/comment'=>'/site/comment',
				'home/<action:\w+>'=>'home/default/<action>',
				'/admin/logs'=>'/auditTrail/admin',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;port=3306;dbname=',
			'emulatePrepare' => true,
			'username' => '',
			'password' => '',
			'charset' => 'utf8',
			'enableParamLogging'=>true,
			'enableProfiling'=>true,
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'trace, info, error, warning',
				),
				// uncomment the following to show log messages on web pages
				array(
					'class'=>'CWebLogRoute',
				),
			),
		),
		'browser' => array(
			'class' => 'application.extensions.Browser.CBrowserComponent',
		),
		'memcache'=>array(
			'class'=>'system.caching.CMemCache',
			'servers'=>array(
				array(
					'host'=>'127.0.0.1', 
					'port'=>11211, 
					'weight'=>60
				),
		    	),
		),
		'apccache'=>array(
			'class'=>'CApcCache',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'',
		'encryptionKey' => '',
		'SPAPIKey' => '',
		'SPPassword'=> '',
		'version'=>'2.0 &#9082;',
	),
);
