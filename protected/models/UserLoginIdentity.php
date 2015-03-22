<?php

class UserLoginIdentity extends CUserIdentity
{
	private $_id;
	public function authenticate() {
		$record = Users::model()->findByAttributes(array('login'=>$this->username));
		if($record === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else if($this->password != $record->password) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			$this->errorCode = self::ERROR_NONE;
			$this->_id = $record->id;
			$this->setState('id', $record->id);
			$this->setState('first_name', $record->first_name);
			$this->setState('second_name', $record->second_name);
		}
		return !$this->errorCode;
	}

	public function getId() {
		return $this->_id;
	}
}