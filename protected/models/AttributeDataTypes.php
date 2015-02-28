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
			$types[] = $value;
		}
		return $types;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
} 