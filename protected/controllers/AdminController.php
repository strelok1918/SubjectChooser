<?php

class AdminController extends Controller
{
	public function init() {
		parent::init();
		$this->layout = "//layouts/adminLayout";
	}
	public function filters() {
		return array(
			'accessControl',
			'ajaxOnly +  saveSubject, deleteSubject, attributeList, saveAttribute, deleteAttribute, getDataTypeList, validatorList, getAttributeListInValidatorEditor, saveValidator, deleteValidator'
		);
	}
    public function accessRules() {
        return array(
            array('allow',
                'actions'=>array('subjects', 'editSubject','stat'),
                'expression' => array('AdminController', 'allowAdminAndModerator'),
            ),
            array('allow',
                'controllers'=>array('admin'),
                'expression' => array('AdminController', 'allowOnlyAdmin'),
            ),
            array('deny',
                'controllers'=>array('admin'),
                'users'=>array('*'),
            ),
        );
    }

    public static function allowOnlyAdmin() {
        return !(Yii::app()->user->isGuest) && (Yii::app()->user->role == "Admin");
    }

    public static function allowAdminAndModerator() {
        return !(Yii::app()->user->isGuest) && (Yii::app()->user->role == "Admin" || Yii::app()->user->role == "Moderator");
    }
	public function actionIndex() {
		$this->render('index');
	}
	public function actionSubjects() {
//		echo (int)Yii::app()->user->isGuest;
//        echo (Yii::app()->user->role);
		$this->render('subjectList', array('subjects' => json_encode(Subject::model()->subjectList(true))));
	}
	public function actionAttributes() {
		$this->render('attributeEditor');
	}
	public function actionEditSubject() {
		$this->render('editSubject', array('subjectData' => json_encode(Subject::model()->subjectInfo($_GET['id'])), 'userList' => UserData::model()->userList()));
	}
	public function actionValidators() {
		$this->render('validatorEditor');
	}
	public function actionUsers() {
		$this->render('users');
	}
	public function actionGroups() {
		$this->render('groups');
	}
	public function actionStat(){
		$this->render('stat', array('stats' => Subject::model()->subjectsStatistics()));
	}

	//groups
	public function actionGroupList() {
		echo json_encode(array( "Result" => "OK",
			"Records" => UserGroups::model()->groupList()));
	}
	public function actionGetGroupList() {
		$result = array();
		foreach(UserGroups::model()->groupList() as $key => $value) {
			$result[] = array(
				'Value' => $value['id'],
				'DisplayText' => $value['title']
			);
		}
		echo json_encode(array("Result" => "OK", "Options" => $result));
	}
	public function actionUserSubjectList() {
		$userId = $_GET['userId'];
		echo json_encode(array( "Result" => "OK",
			"Records" => Subject::model()->simplifiedSubjectList($userId)));
	}

	public function actionFullSubjectList() {
		$result = array();
		foreach(Subject::model()->subjectList() as $key => $value) {
			$result[] = array(
				'Value' => $value['id'],
				'DisplayText' => $value['title']
			);
		}
		echo json_encode(array("Result" => "OK", "Options" => $result));
	}

	public function actionSaveChoose() {
		$choose = new ChooseHandler();
		$responce = $choose->saveChoose($_POST, $_GET['userId']);
		if(empty($responce['errors']))
			echo json_encode(array ("Result" => "OK", "Record" => $responce['data']));
		else
			echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно сохранить запись."));
	}

	public function actionDismissChoose() {
		$errors = ChooseHandler::model()->dismissChoose($_POST['id'], $_GET['userId']);
		if(empty($errors))
			echo json_encode(array ("Result" => "OK"));
		else
			echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно удалить запись."));
	}

	public function actionSaveUserData() {
		$user = new UserData();
		$errors = $user->saveData($_POST, true);
		if(empty($errors))
			echo json_encode(array ("Result" => "OK", "Record" => $user->attributes));
		else
			echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно сохранить запись."));
	}

	public function actionUserList() {
		echo json_encode(array( "Result" => "OK",
			"Records" => UserData::model()->userList()));
	}
	public function actionDeleteGroup() {
		$errors = UserGroups::model()->dropGroupItem($_POST['id']);
		if(empty($errors))
			echo json_encode(array ("Result" => "OK"));
		else
			echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно удалить запись."));
	}

	public function actionSaveGroupData() {
		$group = new UserGroups();
		$errors = $group->saveData($_POST);
		if(empty($errors))
			echo json_encode(array ("Result" => "OK", "Record" => $group->attributes));
		else
			echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно сохранить запись."));
	}
	public function actionSaveSubject() {
		$id = Yii::app()->request->getPost('id');
		$data = Yii::app()->request->getPost('data');

		$responce = Subject::model()->saveData($id, $data);
		$subjectId = $responce['id'];
		$errors = $responce['errors'];
		$subjectInfo = Subject::model()->subjectInfo($subjectId);
		echo json_encode(array('errors' => $errors, 'subjectData' => $subjectInfo));
	}
	public function actionDeleteSubject() {
		echo json_encode(Subject::model()->dropSubject($_GET['id']));
	}

	public function actionAttributeList() {
		echo json_encode(array( "Result" => "OK",
								"Records" => Attribute::model()->attributeList()));
	}
	public function actionSaveAttribute() {
		$attribute = new Attribute();
		$errors = $attribute->saveData($_POST);
		if(empty($errors)) echo json_encode(array ("Result" => "OK", "Record" => $attribute->attributes));
		else echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно сохранить запись."));
	}
	public function actionDeleteAttribute() {
		$errors = Attribute::model()->drop($_POST['id']);
		if(empty($errors)) echo json_encode(array ("Result" => "OK"));
		else echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно удалить запись."));
	}
	public function actionGetDataTypeList() {
		$result = array();
		foreach(AttributeDataTypes::model()->typeList() as $key => $value) {
			$result[] = array(
				'Value' => $value['type'],
				'DisplayText' => $value['title']
			);
		}
		echo json_encode(array("Result" => "OK", "Options" => $result));
	}

	public function actionValidatorList() {
		echo json_encode(array( "Result" => "OK",
						"Records" => Validator::model()->validatorlist()));
	}
	public function actionGetAttributeListInValidatorEditor() {
		$result = array();
		foreach(Attribute::model()->attributeList() as $key => $value) {
			$result[] = array(
				'Value' => $value['id'],
				'DisplayText' => $value['title']
			);
		}
		echo json_encode(array("Result" => "OK", "Options" => $result));
	}
	public function actionSaveValidator() {
		$validator = new Validator();
		$errors = $validator->saveData($_POST);
		if(empty($errors)) echo json_encode(array ("Result" => "OK", "Record" => $validator->attributes));
		else echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно сохранить запись."));
	}
	public function actionDeleteValidator() {
		$errors = Validator::model()->drop($_POST['id']);
		if(empty($errors)) echo json_encode(array ("Result" => "OK"));
		else echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно удалить запись."));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}