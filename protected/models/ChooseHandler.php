<?php

class ChooseHandler extends StudentsSubjects {
	public function saveChoose($data) {
		$choose = new StudentsSubjects();
		$choose->user_id = Yii::app()->user->id;
		$choose->object_id = $data['subject_id'];
		$choose->year = $data['year'];
		$choose->semester = $data['semester'];

		try {
			$choose->save();
		} catch(CdbException $ex) {
			$choose->addError('error', "Вы уже выбрали данный предмет на заданный период обучения.");
		}

		return $choose->getErrors();
	}

	public function dismissChoose($id) {
		$criteria = new CDbCriteria;
		$criteria->condition = 'user_id = :user_id AND id = :id';
		$criteria->params = array(':user_id' => Yii::app()->user->id, ':id' => $id);

		$choose = new StudentsSubjects();
		if($choose->deleteAll($criteria) == 0) {
			$choose->addError('deleting', 'Невозможно удалить строку.');
		}
		return $choose->getErrors();
	}
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
} 