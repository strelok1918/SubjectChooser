<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 27.03.2015
 * Time: 0:42
 */

class UserData extends Users{
	public function getUserInfo(){
		$data = $this->findByPk(Yii::app()->user->id);
		return $this->generateUserData($data);
	}
	public function userList($sorting= null, $page = null, $filter = null){

		$result = array();
        $params = array('order' => $sorting);
        if($page) {
            $params['limit'] = $page['limit'];
            $params['offset'] = $page['offset'];
        }
        $where = "";
        $data = array();
        if($filter) {
            if(!empty($filter['first_name'])) {
                $where = "first_name = :first_name";
                $data[':first_name'] = $filter['first_name'];
            }
            if(!empty($filter['second_name'])) {
                if(!empty($where)) $where .= " AND ";
                $where .= "second_name = :second_name";
                $data[':first_name'] = $filter['first_name'];
            }
            if(!empty($filter['login'])) {
                if(!empty($where)) $where .= " AND ";
                $where .= "login = :login";
                $data[':login'] = $filter['login'];
            }
            if(!empty($filter['mail'])) {
                if(!empty($where)) $where .= " AND ";
                $where .= "mail = :mail";
                $data[':mail'] = $filter['mail'];
            }
        }
        $params['condition'] = $where;
        $params['params'] = $data;
        //print_r($params);
		foreach($this->findAll($params) as $user) {
			$result[] = $this->generateUserData($user);
		}
		return $result;
	}
    public function userCount() {
        return $this->model()->count();
    }
	private function generateUserData($data) {
		return array(
			'id' => $data->id,
			'role' => $data->role,
			'acquisition_year' => $data->acquisition_year,
			'login' => $data->login,
			'first_name' => $data->first_name,
			'second_name' => $data->second_name,
			'group' => $data->group,
			'mail' => $data->mail,
			'password' => $data->password,
		);
	}
	public function saveData($data, $isAdmin = false) {
		if($isAdmin)
			if(isset($data['id']))
				return $this->saveExistUser($data['id'], $data, $isAdmin);
			else
				return $this->saveNewUser($data);
		else
			return $this->saveExistUser(Yii::app()->user->id, $data, $isAdmin);
	}

	private function saveExistUser($id, $data, $isAdmin) {
		$users = Users::model()->findByPk($id);
		$users->attributes = $data;
//        print_r($users->attributes);
        try {
            $users->save();
        } catch(CDbException $e) {

            if(strpos($e->errorInfo[2], 'login')) return "Пользователь с таким логином уже существует.";
            if(strpos($e->errorInfo[2], 'mail')) return "Пользователь с таким E-mail адресом уже существует.";
            return "Invalid data";
        }

		if(!$isAdmin && !$users->hasErrors()) {
			Yii::app()->user->setState('first_name', $users->first_name);
			Yii::app()->user->setState('second_name', $users->second_name);
		}
		return $users->getErrors();
	}

	public function saveNewUser($data) {
//        print_r($data);
		$users = new Users();
		$users->attributes = $data;
        try {
            $users->save();
        } catch(CDbException $e) {
            return array("Invalid data.");
        }
		return $users->getErrors();
	}
    public function deleteUser($userId) {
        return Users::model()->deleteByPk($userId);
    }
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
} 