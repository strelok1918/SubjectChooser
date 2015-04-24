<?php

class Subject extends Objects{
	public function simplifiedSubjectList($userId) {
		$data = StudentsSubjects::model()->with(array('object', 'object.attributeMappings','object.attributeMappings.attributeType', 'object.validatorMappings', 'object.validatorMappings.validator'))->findAll('user_id = :userId', array(':userId' => $userId));
		$result = array();
		foreach((array)$data as $subject) {

			$subjectData = array(   'id'=> $subject->id,
									'student_id' => $userId,
									'object_id' => $subject->object_id,
									'year' => $subject->year,
									'semester' => $subject->semester);
			$result[] = $subjectData;
		}
		return $result;
	}

	//list for user/subjectList
	public function subjectList($fromAdmin = false) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('is_visible = 1');

        if($fromAdmin && Yii::app()->user->role == "Moderator") {
               $criteria->addInCondition('owner_id', array(Yii::app()->user->id));
        }

		$data = $this->model()->with(array( 'attributeMappings',
											'attributeMappings.attributeType',
                                            'objectOwners',
											'validatorMappings',
											'validatorMappings.validator'))->findAll($criteria);
		$result = array();
		foreach((array)$data as $subject) {
			$result[] = $this->linkSubjectItemData($subject);
		}
		return $result;
	}
	//detailed list for user/mySubjects
	public function userSubjectList($userId) {
		$data = StudentsSubjects::model()->with(array(  'object',
														'object.attributeMappings',
														'object.attributeMappings.attributeType',
														'object.validatorMappings',
														'object.validatorMappings.validator'))->findAll('user_id = :userId AND is_visible = 1', array(':userId' => $userId));
		$result = array();
		foreach((array)$data as $subject) {
			$subjectData = $this->linkSubjectItemData($subject->object);
			$subjectData['attributes']['year'] = array(
				'value' => $subject->year,
				'title' => "Год",
			);
			$subjectData['attributes']['semester'] = array(
				'value' => $subject->semester,
				'title' => "Семестр",
			);
			$subjectData['id'] = $subject->id;

			$result[] = $subjectData;
		}
		return $result;
	}
	private function linkSubjectItemData($subject) {
		$subjectData = array(   'id' => $subject->id,
								'title' => $subject->title,
								'attributes' => array());
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
		$data = $this->model()->with(array( 'attributeMappings',
                                            'attributeMappings.attributeType',
                                            'validatorMappings',
                                            'validatorMappings.validator',
                                            'objectOwners'))->findByPk($subjectId);
		$attributes = $this->getAtrributeList($data->attributeMappings);

		return array(
			'id' => $subjectId,
			'title' => $data->title,
            'owner' => $this->ownerList($data->objectOwners),
			'attributes' => $attributes,
			'validators' => $this->validatorList($data->validatorMappings, $attributes),
			'customValidators' => $this->customValidatorList($subjectId),
		);
	}

	public function saveData($objectId, $data) {
		$errorList = $this->saveObject($objectId, $data['attributes'][0]['value']);


        ObjectOwners::model()->deleteAll("object_id = :object_id", array(':object_id' => $objectId));
        foreach((array)$data['owner'] as $owner) {
            $errorList = array_merge($errorList, $this->saveOwner($objectId, $owner));
        }

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
		AttributeMapping::model()->deleteAll("object_id = " . $subjectId);
		Objects::model()->deleteByPk($subjectId);
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
    private function saveOwner($objectId, $ownerId) {
        $mapping = new ObjectOwners();
        $mapping->object_id = $objectId;
        $mapping->owner_id = $ownerId;
        $mapping->save();
        return $mapping->getErrors();
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

    private function ownerList($data) {
        $result = array();
        foreach($data as $owner) {
            $result[] = $owner['owner_id'];
        }
        return $result;
    }
	private function getAtrributeList($attributes) {
		$attributeData = Attribute::model()->attributeList();

		if(!empty($attributes)) {
			foreach ($attributes as $attribute) {
				$attributeData[$attribute->attribute_type_id] =
					array(
						'value' => $attribute->value,
						'attribute_id' => $attribute->id,
						'title' => $attribute->attributeType->title,
//                        'is_visible' => $attribute->attributeType->is_visible,
						'attribute_type' => $attribute->attributeType->type,
					);
			}
		}
		return $attributeData;
	}

	private function validatorList($validatorData, $attributeData) {
		$result = Validator::model()->validatorList();
		if(!empty($validatorData)) {
			foreach ($validatorData as $validator) {
				$validatorValue = explode(';', $validator->value);
				$result[$validator->validator_id] =
					array(
						'title' => $validator['title'],
						'attribute_id' => $validator['attribute_id'],
						'id' => $validator['id'],
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

	public function subjectsStatistics() {
		$data = StudentsSubjects::model()->with('object', 'user', 'user.groupRel')->findAll();
		$result = array();
		foreach($data as $item) {
			$result[] = array(
				'subject_id' => $item->object_id,
				'title' => $item->object->title,
				'year' => $item->year,
				'semester' => $item->semester,
				'user_id' => $item->user->id,
				'first_name' => $item->user->first_name,
				'second_name' => $item->user->second_name,
				'group_id' => $item->user->groupRel->id,
				'group' => $item->user->groupRel->title,
			);
		}
		return $result;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
} 