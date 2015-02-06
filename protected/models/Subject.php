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

	public function dropByPk($id) {
		AttributeMapping::model()->deleteAll("object_id = " . $id);
		Objects::model()->deleteByPk($id);
	}

	public function subjectInfo($subjectId) {
		$data = $this->model()->with(array('attributes','attributes.attributeType'))->findByPk($subjectId);
		return array(
			'id' => $subjectId,
			'title' => $data->title,
			'attributes' => $this->getAtrributeList($data->attributes),
		);
	}

//	public function disciplineFullInfoList() {
//		$disciplines = array();
//		foreach($this->model()->with(array('attributes','attributes.attributeType'))->findAll() as $disciplineRecord) {
//			$disciplines[$disciplineRecord->id] = array(
//														'title' => $disciplineRecord->title,
//														'attributes' => $this->getAtrributeList($disciplineRecord->attributes)
//													);
//		}
//		return $disciplines;
//	}

	private function getAtrributeList($attributes) {
		$subjectData = array();

		foreach(AttributeType::model()->findAll() as $attribute)
			$subjectData[$attribute->id] = array(
				'attribute_title' => $attribute->title,
				'attribute_type' => $attribute->type,
			);

		if(!empty($attributes))
		foreach($attributes as $attribute)
			$subjectData[$attribute->attributeType->id] = array_merge($subjectData[$attribute->attributeType->id],
																		array(
																			'attribute_value' => $attribute->value,
																			'attribute_id' => $attribute->id,
																		));
		return $subjectData;
	}
} 