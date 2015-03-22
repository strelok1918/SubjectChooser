<?php

class UserController extends Controller
{
	public function filters() {
		return array(
			'accessControl',
			'ajaxOnly + saveChoose, dismissChoose',
		);
	}
	public function accessRules() {
		return array(
			array('allow',
				'actions'=>array('subjectList', 'saveChoose', 'mySubjects', 'dismissChoose'),
				'users'=>array('@'),
			),
			array('deny',
				'actions'=>array('subjectList', 'saveChoose', 'mySubjects', 'dismissChoose'),
				'users'=>array('?'),
			),

		);
	}
	public function actionIndex() {
		$this->actionSubjectList();
	}
	public function actionSubjectList() {
		$this->render('subjectList', array('subjects' => Subject::model()->subjectDetailedList()));
	}
	public function actionSaveChoose() {
		$responce = array();
		$responce['errors'] = ChooseHandler::model()->saveChoose($_POST['data']);
		echo json_encode($responce);
	}
	public function actionDismissChoose() {
		$responce = array();
		$responce['errors'] = ChooseHandler::model()->dismissChoose($_POST['data']);
		echo json_encode($responce);
	}
	public function actionMySubjects() {
		$userId = Yii::app()->user->id;
		$this->render('mySubjects', array('subjects' => Subject::model()->userSubjectList($userId), 'mySubjectsPage' => 1));
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