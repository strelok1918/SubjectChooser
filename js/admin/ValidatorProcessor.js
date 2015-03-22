var ValidatorProcessor = (function(){
    var _fieldIds = {};
    var _operationTypes = {
        "1" : {"value" : "equals", "title" : "="},
        "2" : {"value" : "less_than", "title" : "&lt;"},
        "3" : {"value" : "less_than_or_equal_to", "title" : "&le;"},
        "4" : {"value" : "greater_than", "title" : "&gt"},
        "5" : {"value" : "greater_than_or_equal_to", "title" : "&ge;"},
        "6" : {"value" : "now_equal_to", "title" : "&lt;&gt;"},
        "7" : {"value" : "in", "title" : "IN"}
    };

    var _collectData = function() {
        var data = [],
            deleted = [];
        for(var key in _fieldIds){
            if(_fieldIds.hasOwnProperty(key)) {
                if(!$('#validatorValue' + key).val()) {
                    if(_fieldIds[key]){
                        deleted.push(_fieldIds[key]);
                    }
                } else {
                    data.push({
                        value:	$('#validatorOperator' + key).val() + ';' + $('#validatorValue' + key).val(),
                        type_id : key,
                        validator_id :  _fieldIds[key]
                    });
                }

            }
        }
        return {'data' : data, 'deleted' : deleted};
    };
    var _fillFields = function(data) {
        var validatorField = _.template($('#formValidatorTemplate').html());
        var result = "";
        for(var key in data) {
            if(data.hasOwnProperty(key)) {
                _fieldIds[key] = data[key].validator_id || null;
                result += validatorField({
                    'id' : key,
                    'title' : data[key].validator_title,
                    'value' : data[key].value,
                    'operators': _operationTypes,
                    'selectedOperator' : data[key].operator
                });
            }
        }
        return result;
    };
    return {
        collectData : function() {
            return _collectData();
        },
        fillData : function(data) {
            return  _fillFields(data);
        }
    };
})();