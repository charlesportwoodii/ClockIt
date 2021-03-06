<?php

/**
 * This is the model class for table "watchdog".
 *
 * The followings are the available columns in table 'watchdog':
 * @property string $id
 * @property string $old_value
 * @property string $new_value
 * @property string $action
 * @property string $model
 * @property string $field
 * @property string $stamp
 * @property string $user_id
 * @property string $model_id
 */
class Watchdog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Watchdog the static model class
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
		return 'watchdog';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('action, model, stamp, user_id', 'required'),
			array('action', 'length', 'max'=>20),
			array('model', 'length', 'max'=>255),
			array('field', 'length', 'max'=>64),
			array('user_id', 'length', 'max'=>30),
			array('model_id', 'length', 'max'=>65),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, old_value, new_value, action, model, field, stamp, user_id, model_id', 'safe', 'on'=>'search'),
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
			'old_value' => 'Old Value',
			'new_value' => 'New Value',
			'action' => 'Action',
			'model' => 'Model',
			'field' => 'Field',
			'stamp' => 'Stamp',
			'user_id' => 'User',
			'model_id' => 'Model',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('old_value',$this->old_value,true);
		$criteria->compare('new_value',$this->new_value,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('field',$this->field,true);
		$criteria->compare('stamp',$this->stamp,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('model_id',$this->model_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}