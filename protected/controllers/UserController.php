<?php

class UserController extends Controller
{
	public function filters() {
		return array(
			'accessControl',
			'ajaxOnly + saveChoose, dismissChoose, saveUserData',
		);
	}
	public function accessRules() {
		return array(
			array('allow',
				'actions'=>array('subjectList', 'saveChoose', 'mySubjects', 'dismissChoose', 'editInfo', 'index'),
				'users'=>array('@'),
//				'roles' => array('Admin'),
			),
			array('deny',
				'actions'=>array('subjectList', 'saveChoose', 'mySubjects', 'dismissChoose', 'editInfo', 'index'),
				'users'=>array('*'),
			),

		);
	}
    public function actionRegister() {
        $errors = array();
        if(isset($_POST['info'])) {
            $_POST['info']['role'] = "User";
            $errors = UserData::model()->saveNewUser($_POST['info']);
        }
        $this->layout = 'register';
        $this->render('register', array('errors' => $errors, 'groups' => UserGroups::model()->groupList()));
    }
	public function actionIndex() {
		$this->actionSubjectList();
	}
	public function actionSubjectList() {
		$this->render('subjectList', array('subjects' => Subject::model()->subjectList()));
	}
	public function actionSaveChoose() {
		$responce = ChooseHandler::model()->saveChoose($_POST['data'], Yii::app()->user->id);
		echo json_encode($responce['errors']);
	}
	public function actionDismissChoose() {
		$responce = array();
		$responce['errors'] = ChooseHandler::model()->dismissChoose($_POST['data'], Yii::app()->user->id);
		echo json_encode($responce);
	}
	public function actionMySubjects() {
		$userId = Yii::app()->user->id;
		$this->render('mySubjects', array('subjects' => Subject::model()->userSubjectList($userId)));
	}

	public function actionEditInfo() {
		$this->render('userInfo', array('info' => UserData::model()->getUserInfo(), 'groupList' => UserGroups::model()->groupList()));
	}
	public function actionSaveUserData() {
		$data = $_POST['data'];
		$responce['errors'] = UserData::model()->saveData($data);
		echo json_encode($responce);
	}

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
	public function actionLogin()
	{
		$errors = array();
		if(isset($_POST['loginData']))
		{
			$model = new LoginForm();
			$model->attributes=$_POST['loginData'];

			$model->validate();
			$model->authenticate();
			if(!sizeof($model->getErrors())) {
				$this->redirect(Yii::app()->createAbsoluteUrl("user/subjectList"));
			} else {
				$errors = $model->getErrors();
			}
		}
		$this->renderPartial('login', array('errors' => json_encode($errors)));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->createAbsoluteUrl("user/login"));
	}
}