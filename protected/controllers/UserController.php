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
			),
			array('deny',
				'actions'=>array('subjectList', 'saveChoose', 'mySubjects', 'dismissChoose', 'editInfo', 'index'),
				'users'=>array('*'),
			),

		);
	}
    public function actionRecovery() {
        Yii::app()->user->logout();
        $this->layout = 'register';
        $errors = array();
        $step = 1;
        if(isset($_POST['login'])) {
            $count = Users::model()->countByAttributes(array('login'=> $_POST['login']));
            if($count == 0) {
                $errors = array('Пользователь не найден.');
            } else {
                $email = Yii::app()->email;
                $email->to = "strelok1918@gmail.com";
                $email->subject = 'Код активации аккаунта для сайта '.Yii::app()->name;
                $email->message = 'Код активации аккаунта: <a href="'.Yii::app()->homeUrl.'/user/default/activation/key/"></a>';
                $email->send();
            }
            $step = 2;
        }
        $this->render('recovery', array('errors' => $errors, 'step' => $step));
    }
    public function actionRegister() {
        Yii::app()->user->logout();
        $errors = array();
        $data = array();
        if(isset($_POST['login'])) {
            $_POST['role'] = "User";
            $errors = UserData::model()->saveNewUser($_POST);
            $data = $_POST;
        }
        $this->layout = 'register';
        $this->render('register', array('errors' => $errors, 'groups' => UserGroups::model()->fetchList(), 'userData' => $data));
    }
    public function actionCheckUser() {
        if(Users::model()->countByAttributes(array('login'=> $_GET['login'])) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

	public function actionIndex() {
		$this->actionSubjectList();
	}
    public function actionSubjectList() {
        $this->render('subjectList', array('subjects' => Subject::model()->fetchList()));
    }

	public function actionSaveChoose() {
		$responce = ChooseHandler::model()->saveChoose($_POST['data'], Yii::app()->user->id);
		echo json_encode($responce['errors']);
	}

	public function actionDismissChoose() {
		echo json_encode(array('errors' => ChooseHandler::model()->dismissChoose($_POST['data'], Yii::app()->user->id)));
	}
	public function actionMySubjects() {
		$userId = Yii::app()->user->id;
		$this->render('mySubjects', array('subjects' => Subject::model()->userSubjectList($userId)));
	}

	public function actionEditInfo() {
		$this->render('userInfo', array('info' => UserData::model()->getUserInfo(), 'groupList' => UserGroups::model()->fetchList()));
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
				$this->renderPartial('error', $error);
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
        $this->layout = 'register';
		$this->render('login', array('errors' => json_encode($errors)));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->createAbsoluteUrl("user/login"));
	}
}