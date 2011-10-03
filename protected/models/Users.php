<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $uid
 * @property integer $spUid
 * @property string $email
 * @property string $password
 * @property string $fName
 * @property string $lName
 * @property string $dispName
 * @property string $phoneNumber
 * @property string $address
 * @property string $city
 * @property string $state
 * @property integer $zip
 * @property string $birthday
 * @property integer $active
 * @property integer $role
 * @property integer $violations
 * @property integer $tardies
 * @property integer $absences
 * @property integer $forgot
 * @property integer $assists
 * @property string $lastAttempt
 * @property integer $firstLogin
 * @property integer $numOfAttempts
  * @property integer $clockStatus
 * @property varchar #appToken
 */
class Users extends CActiveRecord
{
	public function behaviors() { 
		return array( 'LoggableBehavior'=> 'application.modules.auditTrail.behaviors.LoggableBehavior', ); 
		}
	/**
	 * Returns the static model of the specified AR class.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password, fName, lName, dispName, phoneNumber, birthday', 'required'),
			array('spUid, zip, active, role, violations, tardies, absences, forgot, assists, firstLogin, numOfAttempts', 'numerical', 'integerOnly'=>true),
			array('uid', 'length', 'max'=>25),
			array('email, dispName', 'length', 'max'=>200),
			array('password', 'length', 'max'=>64),
			array('fName, lName, phoneNumber', 'length', 'max'=>100),
			array('address', 'length', 'max'=>255),
			array('city', 'length', 'max'=>50),
			array('state', 'length', 'max'=>5),
			array('birthday', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uid, spUid, email, password, fName, lName, dispName, phoneNumber, address, city, state, zip, birthday, active, role, violations, tardies, absences, forgot, assists, lastAttempt, firstLogin, numOfAttempts', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'User ID',
			'spUid' => 'ShiftPlanning ID',
			'email' => 'Email',
			'password' => 'Password',
			'fName' => 'First Name',
			'lName' => 'Last Name',
			'dispName' => 'Display Name',
			'phoneNumber' => 'Phone Number',
			'address' => 'Address',
			'city' => 'City',
			'state' => 'State',
			'zip' => 'Zip',
			'birthday' => 'Birthday',
			'active' => 'isActive',
			'role' => 'Role',
			'violations' => 'Violations',
			'tardies' => 'Tardies',
			'absences' => 'Absences',
			'forgot' => 'Forgot',
			'assists' => 'Assists',
			'lastAttempt' => 'Last Attempt',
			'firstLogin' => 'First Login',
			'numOfAttempts' => 'Number Of Attempts',
			'cStatus' => 'Clock Status',
			'appToken' => 'ShiftPlanning API Token',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('spUid',$this->spUid);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fName',$this->fName,true);
		$criteria->compare('lName',$this->lName,true);
		$criteria->compare('dispName',$this->dispName,true);
		$criteria->compare('phoneNumber',$this->phoneNumber,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zip',$this->zip);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('role',$this->role);
		$criteria->compare('violations',$this->violations);
		$criteria->compare('tardies',$this->tardies);
		$criteria->compare('absences',$this->absences);
		$criteria->compare('forgot',$this->forgot);
		$criteria->compare('assists',$this->assists);
		$criteria->compare('lastAttempt',$this->lastAttempt,true);
		$criteria->compare('firstLogin',$this->firstLogin);
		$criteria->compare('numOfAttempts',$this->numOfAttempts);
		$criteria->compare('cStatus',$this->cStatus);
		$criteria->compare('appToken',$this->appToken);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	   /**
	*	 Provides encryption hashing support to the entire model
	*
	**/
	public function _encryptHash($email, $password, $_dbsalt) {
			return mb_strimwidth(hash("sha512", hash("sha512", hash("whirlpool", md5($password . md5($email)))) . hash("sha512", md5($password . md5($_dbsalt))) . $_dbsalt), 0, 64);	
			}
			
	public function getName($uid) {
		$model = self::model()->findByPk($uid);
		return $model->dispName;
		}
	
	public function getSPuid($uid) {
		$model = self::model()->findByPk($uid);
		return $model->spUid;
		}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{		
		$model=self::model()->findByPk($id);
		if($model===null) {
			$this->layout="//layouts/column1";
			throw new CHttpException(404,'The requested user could not be found. Please verify the user ID in the URL field before trying again.');
			}
		return $model;
	}
}
