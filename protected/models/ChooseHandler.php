<?php

class ChooseHandler extends StudentsSubjects {
	public function saveChoose($data, $userId) {
		$choose = new StudentsSubjects();
		$choose->user_id = $userId;
		$choose->object_id = $data['object_id'];
		$choose->year = $data['year'];
		$choose->semester = $data['semester'];
//		print_r($this);
		try {
			$choose->save();
		} catch(CdbException $ex) {
			$choose->addError('error', "Вы уже выбрали данный предмет на заданный период обучения.");
		}
		return array('data' => $choose->attributes, 'errors' => $choose->getErrors());
	}

	public function dismissChoose($id, $userId) {
		$this->user_id = $userId;

		$criteria = new CDbCriteria;
		$criteria->condition = 'user_id = :user_id AND id = :id';
		$criteria->params = array(':user_id' => $this->user_id, ':id' => $id);

		if($this->deleteAll($criteria) == 0) {
			$this->addError('', 'Невозможно удалить строку.');
		}
		return $this->getErrors();
	}
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
} 