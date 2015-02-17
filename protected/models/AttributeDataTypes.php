<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 17.02.2015
 * Time: 15:22
 */

class AttributeDataTypes extends DataTypes{

	public function typeList() {
		$types = array();
		foreach($this->findAll() as $value) {
			$types[] = array(
				'Value' => $value->type,
				'DisplayText' => $value->title
			);
		}
		return $types;
	}
} 