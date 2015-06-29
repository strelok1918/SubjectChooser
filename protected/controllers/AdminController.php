<?php

class AdminController extends Controller
{
	public function init() {
		parent::init();
		$this->layout = "//layouts/adminLayout";
        $this->defaultAction = "subjects";
	}
	public function filters() {
		return array(
			'accessControl',
		);
	}
    public function accessRules() {
        return array(
            array('allow',
                'actions'=>array('subjects', 'editSubject','stat', 'fullSubjectList'),
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
	public function actionSubjects() {
		$this->render('subjectList', array('subjects' => json_encode(Subject::model()->fetchList(true))));
	}
	public function actionAttributes() {
		$this->render('attributeEditor');
	}
	public function actionEditSubject() {
		$this->render('editSubject', array('subjectData' => json_encode(Subject::model()->subjectInfo($_GET['id'])), 'userList' => UserData::model()->fetchList()));
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