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

	public function subjectInfo($subjectId) {
		$data = $this->model()->with(array('attributeMappings','attributeMappings.attributeType', 'validatorMappings', 'validatorMappings.validator'))->findByPk($subjectId);
		$attributes = $this->getAtrributeList($data->attributeMappings);
		return array(
			'id' => $subjectId,
			'title' => $data->title,
			'attributes' => $attributes,
			'validators' => $this->validatorList($data->validatorMappings, $attributes),
		);
	}

	public function saveData($objectId, $data) {
		$errorList = $this->saveObject($objectId, $data['attributes'][0]['value']);

		array_shift($data['attributes']);
		foreach((array)$data['attributes'] as $attribute) {
			$errorList = array_merge($errorList, $this->saveAttribute($objectId, $attribute));
		}

		foreach((array)$data['validators'] as $validator) {
			$errorList = array_merge($errorList, $this->saveValidator($objectId, $validator));
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
			$this->title = $title;
			$this->save();
			$objectId = $this->id;
		}
		return $this->getErrors();
	}

	private function saveAttribute($objectId, $attributeData) {
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
} 