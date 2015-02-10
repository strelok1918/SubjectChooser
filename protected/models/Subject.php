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
		$data = $this->model()->with(array('attributes','attributes.attributeType'))->findByPk($subjectId);
		return array(
			'id' => $subjectId,
			'title' => $data->title,
			'attributes' => $this->getAtrributeList($data->attributes),
		);
	}

	public function saveData($objectId, $attributes) {
		$errorList = $this->saveObject($objectId, $attributes[0]['value']);

		array_shift($attributes);
		foreach($attributes as $attribute) {
			$errorList = array_merge($errorList, $this->saveAttribute($objectId, $attribute));
		}

		return $errorList;
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

	private function getAtrributeList($attributes) {
		$subjectData = array();

		foreach(AttributeType::model()->findAll() as $attribute) {
			$subjectData[$attribute->id] = array(
				'attribute_title' => $attribute->title,
				'attribute_type' => $attribute->type,
			);
		}

		if(!empty($attributes)) {
			foreach ($attributes as $attribute) {
				$subjectData[$attribute->attribute_type_id] = array_merge($subjectData[$attribute->attribute_type_id],
					array(
						'attribute_value' => $attribute->value,
						'attribute_id' => $attribute->id,
					));
			}
		}

		return $subjectData;
	}


} 