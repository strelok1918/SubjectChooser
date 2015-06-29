<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 28.03.2015
 * Time: 22:10
 */

class UserGroups extends Groups{
	public function fetchList($options = null, $filter = null) {
        $params = array('order' => $options['sorting']);
        if($options['page']) {
            $params['limit'] = $options['page']['limit'];
            $params['offset'] = $options['page']['offset'];
        }
        $where = "";
        $data = array();
        if($filter) {
            if(!empty($filter['title'])) {
                $where = "title = :title";
                $data[':title'] = $filter['title'];
            }
        }
        $params['condition'] = $where;
        $params['params'] = $data;

		$result = array();
		foreach($this->findAll($params) as $group) {
			$result[] = array(  'id'=> $group->id,
                                'faculty' => $group->faculty,
                                'acquisition_year' => $group->acquisition_year,
                                 'title' => $group->title);
		}
		return $result;
	}

	public function dropGroupItem($id) {
		$this->deleteByPk($id);
		return $this->getErrors();
	}

	public function saveData($data) {
        $message = "";
		try {
			if(isset($data['id'])) {
				$this->updateByPk($data['id'], array('title' => $data['title'], 'acquisition_year' => $data['acquisition_year'], 'faculty' => $data['faculty']));
				$this->id = $data['id'];
			} else {
				$this->title = $data['title'];
				$this->save();
			}
			$message = $this->getErrors();

		} catch (CDbException $e) {
			$message = $e->errorInfo;
            //print_r($message);
            if(strpos($e->errorInfo[2], 'title')) return "Такая группа уже существует.";
		}
		return $message;
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
} 