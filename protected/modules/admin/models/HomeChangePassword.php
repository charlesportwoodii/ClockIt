<?php

/**
 * Change Password Model
 * Changes your current password to a new supplied password
 */
class HomeChangePassword extends CFormModel
{
	public $username;
	public $oldPassword;
	public $newPassword;
	public $newPassword2;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, oldPassword, newPassword, newPassword2', 'required'),
			array('newPassword2', 'compare', 'compareAttribute'=>'newPassword'),
			array(	
				'newPassword, newPassword2', 
				'length',
				'min'=>'8', 'max'=>'16', 
				'tooShort'=>'Your new password must be at least 8 characters long', 
				'tooLong'=>'Your new password cannot be longer than 16 characters',
				),
			array('oldPassword', 'auth'),
			);
	}	

	public function auth($attribute,$params) {
		if(!$this->hasErrors())
		{
			 $record=Users::model()->findByAttributes(array('email'=>$this->username));
			 if($record->password!==Users::model()->_encryptHash($this->username, $this->oldPassword, Yii::app()->params['encryptionKey']))
				$this->addError('oldPassword','Your password cannot be changed unless you provide your correct old password.');
			}
		}
		
	public function sync() {
		// Generate the new password
			$password = Users::model()->_encryptHash($this->username, $this->newPassword, Yii::app()->params['encryptionKey']);
		
		// Get the user's current UID
			$uid = Yii::app()->user->id;
			
		// Create a new connection to mySQL
			$connection=Yii::app()->db;
		// Create the SQL and Bind the parameters
			$sql="UPDATE users SET password = :password WHERE uid = :uid";
			$command = $connection->createCommand($sql);
			$command->bindParam(":password", $password, PDO::PARAM_STR);
			$command->bindParam(":uid", $uid, PDO::PARAM_STR);

			$command->execute();
		// Connect to ShiftPlanning
			Yii::import("application.extensions.shiftplanning.YShiftPlanning");
			$sp = new YShiftPlanning(
				array(
					'key' => Yii::app()->params['SPAPIKey']
					)
				);		
				
		$record=Users::model()->findByAttributes(array('uid'=>$uid));
		// Change SP Password
		$sp->updateEmployee($record->spUid, array('password'=>$this->newPassword));
		}
}
