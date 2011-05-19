<?php

/**
 * This is the model class for table "timecards".
 *
 * The followings are the available columns in table 'timecards':
 * @property integer $pid
 * @property string $uid
 * @property string $shift_start
 * @property string $shift_end
 */
class Timecards extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Timecards the static model class
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
		return 'timecards';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid', 'required'),
			array('uid', 'length', 'max'=>20),
			array('shift_start, shift_end', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pid, uid, shift_start, shift_end', 'safe', 'on'=>'search'),
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
			'pid' => 'Pid',
			'uid' => 'Uid',
			'shift_start' => 'Shift Start',
			'shift_end' => 'Shift End',
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

		$criteria->compare('pid',$this->pid);
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('shift_start',$this->shift_start,true);
		$criteria->compare('shift_end',$this->shift_end,true);

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