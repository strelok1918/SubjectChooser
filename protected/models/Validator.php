<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 20.02.2015
 * Time: 0:13
 */

class Validator extends Validators{
	public function validatorlist() {
		$validatorlist = array();
		foreach($this->findAll() as $validator) {
			$validatorlist[$validator->id] = $validator->attributes;
		}
		return $validatorlist;
	}

	public function drop($id) {
		try {
			$this->deleteByPk($id);
			$message = $this->getErrors();
		} catch (Exception $e) {
			$message = array($e->getMessage());
		}
		return $message;
	}

	public function saveData($data) {
		try {
			if(isset($data['id'])) {
				$this->updateByPk($data['id'], array('title' => $data['title'], 'attribute_id' => $data['attribute_id']));
				$this->id = $data['id'];
			} else {
				$this->title = $data['title'];
				$this->attribute_id = $data['attribute_id'];
				$this->save();
			}
			$message = $this->getErrors();

		} catch (Exception $e) {
			$message = array($e->getMessage());
		}
		return $message;
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
} 