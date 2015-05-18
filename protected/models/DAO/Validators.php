<?php

/**
 * This is the model class for table "Validators".
 *
 * The followings are the available columns in table 'Validators':
 * @property integer $id
 * @property string $title
 * @property integer $attribute_id
 * @property string $user_state
 * @property string $message
 *
 * The followings are the available model relations:
 * @property ValidatorMapping[] $validatorMappings
 * @property AttributeType $attribute
 */
class Validators extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Validators';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attribute_id', 'numerical', 'integerOnly'=>true),
			array('title, user_state', 'length', 'max'=>50),
			array('message', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, attribute_id, user_state, message', 'safe', 'on'=>'search'),
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
			'validatorMappings' => array(self::HAS_MANY, 'ValidatorMapping', 'validator_id'),
			'attribute' => array(self::BELONGS_TO, 'AttributeType', 'attribute_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'attribute_id' => 'Attribute',
			'user_state' => 'User State',
			'message' => 'Message',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('attribute_id',$this->attribute_id);
		$criteria->compare('user_state',$this->user_state,true);
		$criteria->compare('message',$this->message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Validators the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
