<?php

/**
 * LinkForm class.
 * Link ClockIt to SP
 */
class LinkForm extends CFormModel
{
	public $username;
	public $spPassword;
	public $newPassword;
	public $newPassword2;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('spPassword, newPassword, newPassword2', 'required'),
			array('spPassword', 'authenticate'),
			array('newPassword2', 'compare', 'compareAttribute'=>'newPassword'),
			array(	
				'newPassword, newPassword2', 
				'length',
				'min'=>'8', 'max'=>'16', 
				'tooShort'=>'Your new password must be at least 8 characters long', 
				'tooLong'=>'Your new password cannot be longer than 16 characters',
				),
			);
	}

	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->username = Yii::app()->user->getState('email');
			Yii::import("application.extensions.shiftplanning.YShiftPlanning");
				$sp = new YShiftPlanning(
					array(
						'key' => Yii::app()->params['SPAPIKey'],
						)
					);
			// Attempt to authenticate with the current username
			$response = $sp->doLogin(
					array(
						'username' => $this->username,		// Load the current usernamed as defined upon login
						'password' => $this->spPassword,			// Authenticate with the SP Password
						)	
					);
			
			Yii::app()->user->setState('appToken', $sp->getAppToken());
			// If the request is not valid, we need to return an error and kill the session
			if ($response['status']['code'] == 7) 
				$this->addError('spPassword','Could not authenticate against Shift Planning, please verify your Shift Planning password');
			else if ($response['status']['code'] != 1)
				$this->addError('spPassword',$response['status']['text'] . "<br /><i>Please verify your information and try again.</i>");
		}
	}

	/*******************************************************************************************************
	*	Sync ClockIt Password with ShiftPlanning
	*******************************************************************************************************/
	public function sync() {
		Yii::import("application.extensions.shiftplanning.YShiftPlanning");
		$sp = new YShiftPlanning(
			array(
				'key' => Yii::app()->params['SPAPIKey'],	// Load the API Key from the Params List
				'token' => Yii::app()->user->appToken,
				)
			);
		/*******************************************************************************************************
		*	Update ClockIt Password with the new password
		*******************************************************************************************************/
		// Generate new password encryption.
		$data = $sp->getSession();
		
		$password = Users::_encryptHash(Yii::app()->user->getState('email'), $this->newPassword, Yii::app()->params['encryptionKey']);
		$uid = Yii::app()->user->id;
		$connection=Yii::app()->db;
		$zero = 0;
		// Create the SQL statement
		$sql="UPDATE users SET dispName = :name, password = :password, firstLogin = 0, phoneNumber = :phoneNumber, address = :address, city = :city, state = :state, zip = :zip WHERE uid = '$uid'";
		$command = $connection->createCommand($sql);
		// Bind the parameters
		$command->bindParam(":name", $data['employee']['name'], PDO::PARAM_STR);
		$command->bindParam(":password", $password, PDO::PARAM_STR);
		$command->bindParam(":phoneNumber", $data['employee']['cell_phone'], PDO::PARAM_STR);
		$command->bindParam(":address", $data['employee']['address'], PDO::PARAM_STR);
		$command->bindParam(":city", $data['employee']['city'], PDO::PARAM_STR);
		$command->bindParam(":state", $data['employee']['state'], PDO::PARAM_STR);
		$command->bindParam(":zip", $data['employee']['zip'], PDO::PARAM_STR);
		Yii::app()->user->setState('firstLogin', 0);
		// Execute the command
		$command->execute();
		/*******************************************************************************************************
		*	Change ShiftPlanning Password to match ClockIt's update password and Sync
		*******************************************************************************************************/
		$data = $sp->getSession();
		$sp->updateEmployee($data['employee']['id'], array('password' => $this->newPassword));		
		}
		
}
