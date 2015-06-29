<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 13.02.2015
 * Time: 15:03
 */

class Attribute extends AttributeType{
	public function fetchList($options = null) {
		$result = array();
        $params = array('order' => $options['sorting']);
        if($options['page']) {
            $params['limit'] = $options['page']['limit'];
            $params['offset'] = $options['page']['offset'];
        }
		foreach($this->findAll($params) as $attribute) {
            $result[] = $attribute->attributes;
		}
		return $result;
	}

    public function drop($id) {
		try {
			$this->deleteByPk($id);
			$message = $this->getErrors();
		} catch (Exception $e) {
			$message = array($e->getMessage());
		}
		return $message;
	}

	public function saveData($data) {
		try {
			if(isset($data['id'])) {
				$this->updateByPk($data['id'], array('title' => $data['title'], 'type' => $data['type'], 'is_visible' => $data['is_visible']));
				$this->id = $data['id'];
			} else {
				$this->title = $data['title'];
				$this->type = $data['type'];
                $this->is_visible = $data['is_visible'];
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