<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 02.02.2015
 * Time: 13:21
 */

class Subject extends Objects{
	public function subjectList() {
		$subjectList = array();
		foreach($this->model()->findAll() as $subjectRecord) {
			$subjectList[$subjectRecord->id] = $subjectRecord->title;
		}
		return $subjectList;
	}

	public function subjectDetailedList() {
		$data = $this->model()->with(array('attributeMappings','attributeMappings.attributeType', 'validatorMappings', 'validatorMappings.validator'))->findAll();
		$result = array();
		foreach((array)$data as $subject) {
//			print_r($subject);
			$result[] = $this->userSubject($subject);
		}
		return $result;
	}

	public function userSubjectList($userId) {
		$data = StudentsSubjects::model()->with(array('object', 'object.attributeMappings','object.attributeMappings.attributeType', 'object.validatorMappings', 'object.validatorMappings.validator'))->findAll('user_id = :userId', array(':userId' => $userId));
		$result = array();

		foreach((array)$data as $subject) {
			$subjectData = $this->userSubject($subject->object);
			$subjectData['attributes'][] = array(
				'value' => $subject->year,
				'title' => "Год",
			);
			$subjectData['attributes'][] = array(
				'value' => $subject->semester,
				'title' => "Семестр",
			);
			$subjectData['id'] = $subject->id;

			$result[] = $subjectData;
		}
		return $result;
	}

	private function userSubject($subject) {
		$subjectData = array('id' => $subject->id, 'title' => $subject->title, 'attributes' => array());
		foreach((array)$subject->attributeMappings as $attribute) {
			if(!empty($attribute->attributes)) {
				$subjectData['attributes'][] = array(
					'id' => $attribute->id,
					'value' => $attribute->value,
					'title' => $attribute->attributeType->title,
					'type' => $attribute->attributeType->type,
				);
			}
		}
		return $subjectData;
	}
	public function subjectInfo($subjectId) {
		$data = $this->model()->with(array('attributeMappings','attributeMappings.attributeType', 'validatorMappings', 'validatorMappings.validator'))->findByPk($subjectId);
		$attributes = $this->getAtrributeList($data->attributeMappings);
		return array(
			'id' => $subjectId,
			'title' => $data->title,
			'attributes' => $attributes,
			'validators' => $this->validatorList($data->validatorMappings, $attributes),
			'customValidators' => $this->customValidatorList($subjectId),
		);
	}

	public function saveData($objectId, $data) {
//		echo json_encode($data);
		$errorList = $this->saveObject($objectId, $data['attributes'][0]['value']);

		array_shift($data['attributes']);
		foreach((array)$data['attributes'] as $attribute) {
			$errorList = array_merge($errorList, $this->saveAttribute($objectId, $attribute));
		}

		foreach((array)$data['validators'] as $validator) {
			$errorList = array_merge($errorList, $this->saveValidator($objectId, $validator));
		}

		foreach((array)$data['customValidators'] as $validator) {
			$errorList = array_merge($errorList, $this->saveCustomValidator($objectId, $validator));
		}
		foreach((array)$data['deleted']['validators'] as $validator) {
			ValidatorMapping::model()->deleteByPk($validator);
		}
		foreach((array)$data['deleted']['customValidators'] as $validator) {
			CustomValidators::model()->deleteByPk($validator);
		}
		return array('id' => $objectId, 'errors' => $errorList);
	}

	public function dropSubject($subjectId) {
		$this->dropObject($subjectId);
		return $this->getErrors();
	}

	private function dropObject($id) {
		AttributeMapping::model()->deleteAll("object_id = " . $id);
		Objects::model()->deleteByPk($id);
	}

	private function saveObject(&$objectId, $title) {
		if($objectId != 'new') {
			$this->model()->updateByPk($objectId, array('title' => $title));
		} else {
			$subject = new Objects();
			$subject->title = $title;
			$subject->save();
			$objectId = $subject->id;
		}
		return $this->getErrors();
	}

	private function saveAttribute($objectId, $attributeData) {
		if(empty($attributeData['value'])) return array();
		if(!empty($attributeData['attribute_id'])) {
			AttributeMapping::model()->updateByPk($attributeData['attribute_id'], array('value' => $attributeData['value']));
			return $this->getErrors();
		} else {
			$mapping = new AttributeMapping();
			$mapping->attribute_type_id = $attributeData['type_id'];
			$mapping->object_id = $objectId;
			$mapping->value = $attributeData['value'];
			$mapping->save();

			return $mapping->getErrors();
		}
	}

	private function saveValidator($objectId, $validatorData) {
		if(!empty($validatorData['validator_id'])) {
			ValidatorMapping::model()->updateByPk($validatorData['validator_id'], array('value' => $validatorData['value']));
			return $this->getErrors();
		} else {
			$mapping = new ValidatorMapping();
			$mapping->validator_id = $validatorData['type_id'];
			$mapping->object_id = $objectId;
			$mapping->value = $validatorData['value'];
			$mapping->save();

			return $mapping->getErrors();
		}
	}
	private function saveCustomValidator($objectId, $validator) {
		if(!empty($validator['id'])) {
			CustomValidators::model()->updateByPk($validator['id'], array('value' => $validator['value']));
			return $this->getErrors();
		} else {
			$validatorObject = new CustomValidators();
			$validatorObject->object_id = $objectId;
			$validatorObject->value = $validator['value'];
			$validatorObject->save();
			return $validatorObject->getErrors();
		}
	}
	private function getAtrributeList($attributes) {
		$attributeData = array();
		foreach(AttributeType::model()->findAll() as $attribute) {
			$attributeData[$attribute->id] = array(
				'attribute_title' => $attribute->title,
				'attribute_type' => $attribute->type,
			);
		}

		if(!empty($attributes)) {
			foreach ($attributes as $attribute) {
				$attributeData[$attribute->attribute_type_id] =
					array(
						'attribute_value' => $attribute->value,
						'attribute_id' => $attribute->id,
						'attribute_title' => $attribute->attributeType->title,
						'attribute_type' => $attribute->attributeType->type,
					);
			}
		}
		return $attributeData;
	}

	private function validatorList($validatorData, $attributeData) {
		$result = array();
		foreach(Validator::model()->findAll() as $validator) {
			$result[$validator->id] = array(
				'validator_title' => $validator->title,
				'attribute_title' => $attributeData[$validator->attribute_id]['attribute_title'],
				'attribute_id' => $validator->attribute_id,
			);
		}

		if(!empty($validatorData)) {
			foreach ($validatorData as $validator) {
				$validatorValue = explode(';', $validator->value);
				$result[$validator->validator_id] =
					array(
						'validator_title' => $validator->validator->title,
						'attribute_id' => $validator->validator->attribute_id,
						'validator_id' => $validator->id,
						'attribute_title' => $attributeData[$validator->validator->attribute_id]['attribute_title'],
						'operator' => trim($validatorValue[0]),
						'value' => trim($validatorValue[1]),
					);
			}
		}

		return $result;
	}

	private function customValidatorList($objectId) {
		$result = array();
		foreach(CustomValidators::model()->findAll("object_id = :object_id", array(":object_id" => $objectId)) as $validator) {
			$result[] = array( 'id' => $validator->id,
								'value' => $validator->value);
		}
		return $result;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
} 