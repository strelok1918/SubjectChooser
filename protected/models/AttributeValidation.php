<?php

class AttributeValidation {
    private $_data;
    private $_validatorData;
    public  function __construct($validators, $year = null, $semester = null) {

        foreach($validators as $validator) {
            $this->_validatorData[] = array(
                'user_state' => $validator->validator->user_state,
                'value' =>  $validator->value,
                'message' => $validator->validator->message
            );
        }

        $this->_data = array(
            //'faculty' => Yii::app()->user->faculty,
            //'group' => Yii::app()->user->group,
        );

        if($year && $semester) {
            $this->_data['course'] = $year - Yii::app()->user->acquisition_year + ($semester - 1);
        }
    }

    public function validate() {
        foreach($this->_validatorData as $field) {
             if(isset($this->_data[$field['user_state']])) {
                 $b = $this->_data[$field['user_state']];
                 $data = explode(';', $field['value']);
                 $operator = $data[0];
                 $a = $data[1];
                 if(!$this->checkExpression($a, $b, $operator)) {
                     return array('result' => false, 'message' => $field['message']);
                 }
             }
        }
        return array('result' => true);
    }

    private function checkExpression($a, $b, $operation) {
        switch ($operation) {
            case 'equals' :
                return $a == $b;
            case 'less_than':
                return $a < $b;
            case 'less_than_or_equal_to':
                return $a <= $b;
            case 'greater_than':
                return $a > $b;
            case 'greater_than_or_equal_to':
                return $a >= $b;
            case 'not_equal_to':
                return $a != $b;
            case 'in' :
                return in_array($b, explode(',', $a));
        }
    }
}