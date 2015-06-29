<?php

class AjaxController extends Controller{
    public function filters() {
        return array(
            'accessControl',
            'ajaxOnly +  saveSubject, deleteSubject, saveAttribute, deleteAttribute, saveValidator, deleteValidator, saveUserData, deleteUser, saveChoose, dismissChoose, saveGroupDaa, deleteGroup'
        );
    }
    public function accessRules() {
        return array(
            array('allow',
                'controllers'=>array('ajax'),
                'expression' => array('AjaxController', 'allowAdminAndModerator'),
            ),
            array('deny',
                'controllers'=>array('ajax'),
                'users'=>array('*'),
            ),
        );
    }
    public static function allowAdminAndModerator() {
        return !(Yii::app()->user->isGuest) && (Yii::app()->user->role == "Admin" || Yii::app()->user->role == "Moderator");
    }
    public function actionSaveAttribute() {
        $attribute = new Attribute();
        $errors = $attribute->saveData($_POST);
        echo $this->responceHandler($errors, $attribute->attributes, StringConstants::CANT_SAVE_ROW);
    }
    public function actionDeleteAttribute() {
        $errors = Attribute::model()->drop($_POST['id']);
        echo $this->responceHandler($errors, null, StringConstants::CANT_DELETE_ROW);
    }

    public function actionSaveValidator() {
        $validator = new Validator();
        $errors = $validator->saveData($_POST);
        echo $this->responceHandler($errors, $validator->attributes, StringConstants::CANT_SAVE_ROW);
    }
    public function actionDeleteValidator() {
        $errors = Validator::model()->drop($_POST['id']);
        echo $this->responceHandler($errors, null, StringConstants::CANT_DELETE_ROW);
    }

    public function actionSaveUserData() {
        $user = new UserData();
        $errors = $user->saveData($_POST, true);
        echo $this->responceHandler($errors, $user->attributes, StringConstants::CANT_SAVE_ROW);
    }
    public function actionDeleteUser() {
        $errors = UserData::model()->deleteUser($_POST['id']);
        echo $this->responceHandler($errors, null, StringConstants::CANT_DELETE_ROW);
    }

    public function actionSaveChoose() {
        $choose = new ChooseHandler();
        $responce = $choose->saveChoose($_POST, $_GET['userId']);
        echo $this->responceHandler($responce['errors'], $choose->attributes, StringConstants::CANT_SAVE_ROW);
    }
    public function actionDismissChoose() {
        $errors = ChooseHandler::model()->dismissChoose($_POST['id'], $_GET['userId']);
        echo $this->responceHandler($errors, null, StringConstants::CANT_DELETE_ROW);
    }

    public function actionSaveGroupData() {
        $group = new UserGroups();
        $errors = $group->saveData($_POST);
        echo $this->responceHandler($errors, $group->attributes, StringConstants::CANT_SAVE_ROW);
    }
    public function actionDeleteGroup() {
        $errors = UserGroups::model()->dropGroupItem($_POST['id']);
        echo $this->responceHandler($errors, null, StringConstants::CANT_DELETE_ROW);
    }

    public function actionSaveSubject() {
        $responce = Subject::model()->saveData(Yii::app()->request->getPost('id'), Yii::app()->request->getPost('data'));
        $subjectInfo = Subject::model()->subjectInfo($responce['id']);
        echo $this->responceHandler($responce['errors'], $subjectInfo, StringConstants::CANT_SAVE_ROW);
    }
    public function actionDeleteSubject() {
        $errors = Subject::model()->dropSubject($_POST['id']);
        echo $this->responceHandler($errors, null, StringConstants::CANT_DELETE_ROW);
    }




    private function responceHandler($errors, $record, $errorMessage) {
        $result = null;
        if(empty($errors)) {
            $result = json_encode(array ("Result" => "OK", "Record" => $record));
        } else {
            foreach($errors as $error)
                $errorMessage .= "; " . $error[0];
            $result = json_encode(array("Result" => "ERROR", "Message" => $errorMessage));
        }
        return $result;
    }
}