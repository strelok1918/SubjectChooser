<?php

/**
 * This is the model class for table "Users".
 *
 * The followings are the available columns in table 'Users':
 * @property integer $id
 * @property string $role
 * @property string $acquisition_year
 * @property string $login
 * @property string $mail
 * @property string $password
 * @property string $first_name
 * @property string $second_name
 * @property integer $group
 *
 * The followings are the available model relations:
 * @property Objects[] $objects
 * @property StudentsSubjects[] $studentsSubjects
 * @property Groups $group0
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group', 'numerical', 'integerOnly'=>true),
			array('role', 'length', 'max'=>9),
			array('acquisition_year', 'length', 'max'=>4),
			array('login, mail, password, first_name, second_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, role, acquisition_year, login, mail, password, first_name, second_name, group', 'safe', 'on'=>'search'),
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
			'objects' => array(self::HAS_MANY, 'Objects', 'owner'),
			'studentsSubjects' => array(self::HAS_MANY, 'StudentsSubjects', 'user_id'),
			'groupRel' => array(self::BELONGS_TO, 'Groups', 'group'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'role' => 'Role',
			'acquisition_year' => 'Acquisition Year',
			'login' => 'Login',
			'mail' => 'Mail',
			'password' => 'Password',
			'first_name' => 'First Name',
			'second_name' => 'Second Name',
			'group' => 'Group',
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
		$criteria->compare('role',$this->role,true);
		$criteria->compare('acquisition_year',$this->acquisition_year,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('mail',$this->mail,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('second_name',$this->second_name,true);
		$criteria->compare('group',$this->group);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
