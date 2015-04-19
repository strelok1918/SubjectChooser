<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

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
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
		);
	}


	public function authenticate()
	{
		if(!$this->hasErrors())
		{
			$identity = new UserLoginIdentity($this->username,$this->password);
			$identity->authenticate();
			switch($identity->errorCode)
			{
				case CUserIdentity::ERROR_NONE:
					$duration=$this->rememberMe ? 3600*24*30 : 0;

					Yii::app()->user->login($identity, 0);
					break;
				case CUserIdentity::ERROR_USERNAME_INVALID:
					$this->addError('username','Username is incorrect.');
					break;
				default: // UserIdentity::ERROR_PASSWORD_INVALID
					$this->addError('password','Password is incorrect.');
					break;
			}

		}
		return $this->getErrors();
	}
}
