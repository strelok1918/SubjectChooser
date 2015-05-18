<?php

class ChooseHandler extends StudentsSubjects {
	public function saveChoose($data, $userId) {
        $validators = CustomValidators::model()->findAll('object_id = :object_id', array(':object_id' => $data['object_id']));
        //print_r($validators);
        foreach($validators as $validator) {
            if($validator->action[1] == '0') continue;
            if(!$validator->checkValid()) {
                return array('errors' => array('errors' => array("Невозможно записаться на дисциплину.")));
            }
        }

        $validators = ValidatorMapping::model()->with('validator')->findAll('object_id = :object_id', array(':object_id' => $data['object_id']));
        $validation = new AttributeValidation($validators, $data['year'], $data['semester']);
        $validationResult = $validation->validate();
        if(!$validationResult['result']) {
            return array('data' => null, 'errors' => array('errors' => array($validationResult['message'])));
        }
        $choose = new StudentsSubjects();
        $choose->user_id = $userId;
        $choose->object_id = $data['object_id'];
        $choose->year = $data['year'];
        $choose->semester = $data['semester'];

        if(isset($data['id'])) {
            $choose->updateByPk($data['id'], array('user_id' => $data['student_id'],
                                                    'object_id' => $data['object_id'],
                                                    'semester' => $data['semester'],
                                                    'year' => $data['year']));
        } else {
            try {
                $choose->save();
            } catch(CdbException $ex) {
                $choose->addError('errors', "Вы уже выбрали данный предмет на заданный период обучения.");
            }
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