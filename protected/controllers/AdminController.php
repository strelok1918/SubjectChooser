<?php

class AdminController extends Controller
{
	public function init() {
		parent::init();
		$this->layout = "//layouts/adminLayout";
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	public function filters() {
		return array(
			'ajaxOnly + saveSubject, deleteSubject'
		);
	}
	public function actionSubjects() {
		$subjects = new Subject();
		$this->render('subjectList', array('subjects' => json_encode($subjects->subjectList())));
	}

	public function actionDeleteSubject() {
		$subject = new Subject();
		echo json_encode($subject->dropSubject($_GET['id']));
	}

	public function actionAttributes() {
		$this->render('attributeEditor');
	}
	public function actionEditSubject() {
		$id = $_GET['id'];
		$subject = new Subject();
		$this->render('editSubject', array('subjectData' => json_encode($subject->subjectInfo($id))));
	}
	public function actionSaveSubject() {
		$id = Yii::app()->request->getPost('id');
		$data = Yii::app()->request->getPost('data');
		$subject = new Subject();
		echo json_encode($subject->saveData($id, $data));
	}
	public function actionAttributeList() {
		$attribute = new Attribute();
		echo json_encode(array( "Result" => "OK",
								"Records" => $attribute->attributeList()));
	}
	public function actionSaveAttribute() {
		$attribute = new Attribute();
		$errors = $attribute->saveData($_POST);
		if(empty($errors)) echo json_encode(array ("Result" => "OK", "Record" => $attribute->attributes));
		else echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно сохранить запись."));
	}
	public function actionDeleteAttribute() {
		$attribute = new Attribute();
		$errors = $attribute->drop($_POST['id']);
		if(empty($errors)) echo json_encode(array ("Result" => "OK"));
		else echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно удалить запись."));
	}
	public function actionGetDataTypeList() {
		$types = new AttributeDataTypes();
		$result = array();
		foreach($types->typeList() as $key => $value) {
			$result[] = array(
				'Value' => $value['type'],
				'DisplayText' => $value['title']
			);
		}
		echo json_encode(array("Result" => "OK", "Options" => $result));
	}
	public function actionValidators() {
		$this->render('validatorEditor');
	}
	public function actionValidatorList() {
		$validator = new Validator();
		echo json_encode(array( "Result" => "OK",
						"Records" => $validator->validatorlist()));
	}
	public function actionGetAttributeListInValidatorEditor() {
		$attributes = new Attribute();
		$result = array();
		foreach($attributes->attributeList() as $key => $value) {
			$result[] = array(
				'Value' => $value['id'],
				'DisplayText' => $value['title']
			);
		}
		echo json_encode(array("Result" => "OK", "Options" => $result));
	}
	public function actionDeleteValidator() {
		$validator = new Validator();
		$errors = $validator->drop($_POST['id']);
		if(empty($errors)) echo json_encode(array ("Result" => "OK"));
		else echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно удалить запись."));
	}
	public function actionSaveValidator() {
		$validator = new Validator();
		$errors = $validator->saveData($_POST);
		if(empty($errors)) echo json_encode(array ("Result" => "OK", "Record" => $validator->attributes));
		else echo json_encode(array ("Result" => "ERROR", "Message" => "Невозможно сохранить запись."));
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