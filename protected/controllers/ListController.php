<?php
class ListController extends Controller{
    public function filters() {
        return array(
            'accessControl',
            'ajaxOnly + attributeList, groupList, subjectList, userList, validatorList, userSubjectList, attributesInOptions, SubjectListOptions, groupListOptions'
        );
    }
    public function accessRules() {
        return array(
            array('allow',
                'controllers'=>array('list'),
                'expression' => array('ListController', 'allowAdminAndModerator'),
            ),
            array('deny',
                'controllers'=>array('list'),
                'users'=>array('*'),
            ),
        );
    }
    public static function allowAdminAndModerator() {
        return !(Yii::app()->user->isGuest) && (Yii::app()->user->role == "Admin" || Yii::app()->user->role == "Moderator");
    }
    public function actionAttributeList() {
        echo $this->tableResponce(Attribute::model()->fetchList($this->queryData()), Attribute::model()->count());
    }
    public function actionGroupList() {
        echo $this->tableResponce(UserGroups::model()->fetchList($this->queryData(), $_POST), UserGroups::model()->count());
    }
    public function actionSubjectList() {
        $data = $this->queryData();
        echo $this->tableResponce(Subject::model()->fetchList(true, $data['sorting'], $data['page'], $_POST), Subject::model()->count());
    }
    public function actionUserList() {
        $data = $this->queryData();
        echo $this->tableResponce(UserData::model()->fetchList($data['sorting'], $data['page'], $_POST), UserData::model()->count());
    }
    public function actionValidatorList() {
        $data = $this->queryData();
        echo $this->tableResponce(Validator::model()->fetchList($data['sorting'], $data['page']), Validator::model()->count());
    }
    public function actionUserSubjectList() {
        $data = $this->queryData();
        echo $this->tableResponce(Subject::model()->simplifiedSubjectList($_GET['userId'], $data['sorting'], $data['page']), null);
    }

    public function actionAttributesInOptions() {
        echo json_encode(array("Result" => "OK", "Options" => $this->optionsResponce(Attribute::model()->fetchList())));
    }
    public function actionSubjectListOptions() {
        echo json_encode(array("Result" => "OK", "Options" => $this->optionsResponce(Subject::model()->subjectList())));
    }
    public function actionGroupListOptions() {
        echo json_encode(array("Result" => "OK", "Options" => $this->optionsResponce(UserGroups::model()->fetchList())));
    }
//    public function actionGetDataTypeList() {
//        echo json_encode(array("Result" => "OK", "Options" => $this->optionsResponce(AttributeDataTypes::model()->fetchList())));
//    }

    private function optionsResponce($data) {
        $result = array();
        foreach($data as $key => $value) {
            $result[] = array(
                'Value' => $value['id'],
                'DisplayText' => $value['title']
            );
        }
        return $result;
    }

    private function tableResponce($data, $count) {
        return json_encode(array(   "Result" => "OK",
                                    "TotalRecordCount" => $count,
                                    "Records" => $data));
    }

    private function queryData() {
        $responce = array();
        $responce['sorting'] = $_GET['jtSorting'];
        $responce['page'] = null;

        if(isset($_GET['jtPageSize'])) {
            $responce['page'] = array('limit' => $_GET['jtPageSize'], 'offset' => $_GET['jtStartIndex']);
        }
        return $responce;
    }
}