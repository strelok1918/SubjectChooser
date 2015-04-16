<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 28.03.2015
 * Time: 22:10
 */

class UserGroups extends Groups{
	public function groupList() {
		$rows = $this->findAll();
		$result = array();
		foreach($rows as $group) {
			$result[] = array( 'id'=> $group->id,
			                   'title' => $group->title);
		}
		return $result;
	}
	public function dropGroupItem($id) {
		$this->deleteByPk($id);
		return $this->getErrors();
	}

	public function saveData($data) {
		try {
			if(isset($data['id'])) {
				$this->updateByPk($data['id'], array('title' => $data['title']));
				$this->id = $data['id'];
			} else {
				$this->title = $data['title'];
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