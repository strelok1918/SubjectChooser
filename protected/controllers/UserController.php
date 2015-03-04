<?php

class UserController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionSubjectList()
	{
		$this->render('subjectList', array('subjects' => Subject::model()->subjectDetailedList()));
	}

	public function actionSubjectDetails() {

		$this->render('subjectDetails', array('data' => Subject::model()->subjectInfo($_GET['id'])));
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}