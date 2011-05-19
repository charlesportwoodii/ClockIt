<?php

/**
 * This is the model class for table "forgot".
 *
 * The followings are the available columns in table 'forgot':
 * @property integer $id
 * @property string $uid
 * @property integer $asid
 * @property string $submissionTime
 * @property string $start
 * @property string $end
 * @property integer $type
 * @property integer $processed
 * @property string $comment
 * @property integer $flag
 * @property string $data
 */
class Forgot extends CActiveRecord
{
	public function behaviors() { 
		return array( 'LoggableBehavior'=> 'application.modules.auditTrail.behaviors.LoggableBehavior', ); 
		}
	/**
	 * Returns the static model of the specified AR class.
	 * @return Forgot the static model class
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
		return 'forgot';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, submissionTime, type, processed, comment', 'required'),
			array('asid, type, processed, flag', 'numerical', 'integerOnly'=>true),
			array('uid', 'length', 'max'=>20),
			array('start, end', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, uid, asid, submissionTime, start, end, type, processed, comment, flag, data', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'uid' => 'User ID',
			'asid' => 'Associated Shift',
			'submissionTime' => 'Submission Time',
			'start' => 'Start',
			'end' => 'End',
			'type' => 'Type',
			'processed' => 'Processed',
			'comment' => 'Comment',
			'flag' => 'Flag',
			'data' => 'Data',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('asid',$this->asid);
		$criteria->compare('submissionTime',$this->submissionTime,true);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('processed',$this->processed);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('flag',$this->flag);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
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