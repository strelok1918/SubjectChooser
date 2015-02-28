<?php
	error_reporting(E_ERROR);
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 13.02.2015
 * Time: 15:03
 */

class Attribute extends AttributeType{
	public function attributeList() {
		$attributeList = array();
		foreach($this->findAll() as $attribute) {
			$attributeList[] = $attribute->attributes;
		}
		return $attributeList;
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
				$this->updateByPk($data['id'], array('title' => $data['title'], 'type' => $data['type']));
				$this->id = $data['id'];
			} else {
				$this->title = $data['title'];
				$this->type = $data['type'];
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