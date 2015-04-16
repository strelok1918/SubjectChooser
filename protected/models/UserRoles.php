<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 29.03.2015
 * Time: 16:58
 */

class UserRoles extends Roles{
	public function rolesList() {
		$rows = $this->findAll();
		$result = array();
		foreach($rows as $role) {
			$result[] = array( 'id'=> $role->id,
								'title' => $role->title);
		}
		return $result;
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
} 