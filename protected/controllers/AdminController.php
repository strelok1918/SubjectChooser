<?php

class AdminController extends Controller
{
	public function init() {
		parent::init();
		$this->layout = "//layouts/adminLayout";
	}
	public function filters() {
		return array(
			'ajaxOnly +  saveSubject, deleteSubject, attributeList, saveAttribute, deleteAttribute, getDataTypeList, validatorList, getAttributeListInValidatorEditor, saveValidator, deleteValidator'
		);
	}

	public function actionIndex() {
		$this->render('index');
	}
	public function actionSubjects() {
		$this->render('subjectList', array('subjects' => json_encode(Subject::model()->subjectList())));
	}
	public function actionAttributes() {
		$this->render('attributeEditor');
	}
	public function actionEditSubject() {
		$id = $_GET['id'];
		$this->render('editSubject', array('subjectData' => json_encode(Subject::model()->subjectInfo($id))));
	}
	public function actionValidators() {
		$this->render('validatorEditor');
	}

	public function actionSaveSubject() {
		$id = Yii::app()->request->getPost('id');
		$data = Yii::app()->request->getPost('data');
//		echo json_encode($data);
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

//
//	/**
//	 * Displays the login page
//	 */
//	public function actionLogin()
//	{
//		$model=new LoginForm;
//
//		// if it is ajax validation request
//		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
//		{
//			echo CActiveForm::validate($model);
//			Yii::app()->end();
//		}
//
//		// collect user input data
//		if(isset($_POST['LoginForm']))
//		{
//			$model->attributes=$_POST['LoginForm'];
//			// validate user input and redirect to the previous page if valid
//			if($model->validate() && $model->login())
//				$this->redirect(Yii::app()->user->returnUrl);
//		}
//		// display the login form
//		$this->render('login',array('model'=>$model));
//	}
//
//	/**
//	 * Logs out the current user and redirect to homepage.
//	 */
//	public function actionLogout()
//	{
//		Yii::app()->user->logout();
//		$this->redirect(Yii::app()->homeUrl);
//	}

}