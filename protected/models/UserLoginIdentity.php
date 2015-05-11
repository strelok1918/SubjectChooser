<?php

class UserLoginIdentity extends CUserIdentity
{
	private $_id;
	public function authenticate() {
		$record = Users::model()->with('groupRel')->findByAttributes(array('login'=>$this->username));
		if($record === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else if($this->password != $record->password) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			$this->errorCode = self::ERROR_NONE;
			$this->_id = $record->id;
//             echo "<pre>";
//            print_r($record->role);
			$this->setState('id', $record->id);
			$this->setState('first_name', $record->first_name);
			$this->setState('second_name', $record->second_name);
            $this->setState('role', $record->role);
            $this->setState('course', date("Y") - $record->acquisition_year + (date("n") > 7));
            $this->setState('acquisition_year', $record->acquisition_year);
//            Yii::app()->authManager->assign($record->role, $record->id);
		}
		return !$this->errorCode;
	}

	public function getId() {
		return $this->_id;
	}
}