<?php

class AuditTrailModule extends CWebModule
{
	/**
	 * @var string the name of the User class. Defaults to "User"
	 */
	public $userClass = "User";

	/**
	 * @var string the name of the column of the user class that is the primary key. Defaults to "id"
	 */	
	public $userIdColumn = "id";

	/**
	 * @var string the name of the column of the user class that is the username. Defaults to "username"
	 */	
	public $userNameColumn = "username";

	/**
	 * @var boolean true or false, whether or not the module can run the installation database queries. defaults to false
	 */	
	public $install = false;
	
	/**
	 * @var string the path to your dbSchema folder inside the module. Defaults to "application.modules.auditTrail.dbSchema"
	 */	
	public $schemaPath = "application.modules.auditTrail.dbSchema";
	
	/**
	 * @var string the ame of the db install script file you want to use. Defaults to "AuditTrail_initDb_mysql.sql"
	 */	
	public $schemaScript = "AuditTrail_initDb_mysql.sql";
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'auditTrail.models.*',
			'auditTrail.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}