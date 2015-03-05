var EditPageHandler = (function(){
    var _attributesFields = {};
    var _validatorFields = {};
    var _customValidatorFields = {};
    var _subjectListPage = "";
    var _customValidatorLastId = 0;
    var customValidator;
    var _deletedValidators = {
        'validators' : [],
        'customValidators' :[]
    };

    var operationTypes = {
        "1" : {"value" : "equals", "title" : "="},
        "2" : {"value" : "less_than", "title" : "&lt;"},
        "3" : {"value" : "less_than_or_equal_to", "title" : "&le;"},
        "4" : {"value" : "greater_than", "title" : "&gt"},
        "5" : {"value" : "greater_than_or_equal_to", "title" : "&ge;"},
        "6" : {"value" : "now_equal_to", "title" : "&lt;&gt;"},
        "7" : {"value" : "in", "title" : "IN"}
    };

    var _collectAttributesdata = function() {
        var attributes = [];
        for(var key in _attributesFields){
            if(_attributesFields.hasOwnProperty(key)) {
                attributes.push({
                    value:	$('#input' + key).val(),
                    type_id : key,
                    attribute_id :  _attributesFields[key]
                });
            }
        }
        return attributes;
    };
    var _collectValidatorsData = function() {
        var validators = [];
        for(var key in _validatorFields){
            if(_validatorFields.hasOwnProperty(key)) {
                if(!$('#validatorValue' + key).val()) {
                   if(_validatorFields[key])
                       _deletedValidators.validators.push(_validatorFields[key]);
                } else {
                    validators.push({
                        value:	$('#validatorOperator' + key).val() + ';' + $('#validatorValue' + key).val(),
                        type_id : key,
                        validator_id :  _validatorFields[key]
                    });
                }

            }
        }
        return validators;
    };
    var _collectCustomValidatorsData = function() {
        var data = [];
        for(var key in _customValidatorFields) {
            if(_customValidatorFields.hasOwnProperty(key)) {
                if(!$('#customValidator' + key).val()) {
                    if(_customValidatorFields[key])
                        _deletedValidators.customValidators.push(_customValidatorFields[key]);
                } else {
                    data.push({
                        'id': _customValidatorFields[key],
                        'value': $('#customValidator' + key).val()
                    });
                }
            }
        }
        //console.log(_deletedValidators);
        return data;
    };
    var _collectData = function() {

        return {
            'attributes' : _collectAttributesdata(),
            'validators' : _collectValidatorsData(),
            'customValidators' : _collectCustomValidatorsData(),
            'deleted' : _deletedValidators
        };
    };
    var _fillFormData = function(subjectData) {
        subjectData.attributes[0] = {'attribute_title' : 'Название','attribute_value' : subjectData.title};
        data = {'attributes' : _fillAttributeFields(subjectData.attributes),
                'validators':  _fillValidatorFields(subjectData.validators),
                'customValidators' : _fillCustomValidatorFields(subjectData.customValidators)};
        _deletedValidators = {'validators' : [], 'customValidators' :[]};
        $('#subjectFormFields').prepend(data.attributes);
        $('#validators').prepend(data.validators);
        $('#customValidators').prepend(data.customValidators);
    };
    var _fillAttributeFields = function(attributesData) {
        var inputText = _.template($('#formInputText').html());
        var result = "";
        for(var key in attributesData) {
            if(attributesData.hasOwnProperty(key)) {
                _attributesFields[key] = attributesData[key].attribute_id || null;
                result += inputText({
                    'id' : key,
                    'title' : attributesData[key].attribute_title,
                    'value' : attributesData[key].attribute_value
                });
            }
        }
        return result;
    };
    var _fillValidatorFields = function(validatorsData) {
        var validatorField = _.template($('#formValidatorTemplate').html());
        var result = "";
        for(var key in validatorsData) {
            if(validatorsData.hasOwnProperty(key)) {
                _validatorFields[key] = validatorsData[key].validator_id || null;
                result += validatorField({
                    'id' : key,
                    'title' : validatorsData[key].validator_title,
                    'value' : validatorsData[key].value,
                    'operators': operationTypes,
                    'selectedOperator' : validatorsData[key].operator
                });
            }
        }
        return result;
    };
    var _fillCustomValidatorFields = function(validatorsData) {
        var result = "";
        for(var key in validatorsData) {
            if(validatorsData.hasOwnProperty(key)) {
                result += _addCustomValidator(validatorsData[key].id, validatorsData[key].value);
            }
        }
        //console.log(_customValidatorFields);
        return result;
    };
    var _compileTemplates = function() {
        customValidator = _.template($('#customValidatorTemplate').html());
    };
    var _addCustomValidator = function(id, value) {
        _customValidatorLastId++;
        _customValidatorFields[_customValidatorLastId] = id;
        return customValidator({'id' : _customValidatorLastId, 'value' : value});
    };

    var showResponceAlert = function(errors, successMessage) {

        console.log(errors);
        console.log($.isEmptyObject(errors));

        var resultAlert = "";
        var message;
        if($.isEmptyObject(errors)) {
            resultAlert = _.template($('#savedSuccessMessage').html());
            message = successMessage;
        }
        $('#messageBox').prepend(resultAlert({message : message}));
    };

    return{
        init: function() {
          _compileTemplates();
        },
        saveData : function() {
            SubjectProcessor.saveSubject(currentSubjectId, _collectData()).done(function(responce) {
                var data = JSON.parse(responce);
                currentSubjectId = data.subjectData.id;
                $('#subjectFormFields').empty();
                $('#validators').empty();
                $('#customValidators').empty();
                _customValidatorLastId = 0;
                _customValidatorFields = {};
                _fillFormData(data.subjectData);
                showResponceAlert(data.errors, "Изменения сохранены.");
            });
        },
        showDeleteModal : function(subjectId) {
            $('#dropSubjectId').val(subjectId);
            $('#deleteDialogSubjectTitle').empty();
            $('#deleteSubjectModal').modal('show');
        },
        deleteSubject: function(subjectId) {
            SubjectProcessor.deleteSubject(subjectId).done(function(data){
                $('#deleteSubjectModal').modal('hide');
                showResponceAlert(data, "Предмет успешно удален");
                window.location = _subjectListPage;
            });
        },
        fillForm : function(subjectData) {
            //console.log(subjectData);
            _fillFormData(subjectData);
        },
        setSubjectListPage : function(URL) {
            _subjectListPage = URL;
        },
        addValidatorField : function() {
            $('#customValidators').append(_addCustomValidator(null, null));
        },
        deleteValidatorField : function(id) {
            $('#customValidator' + id).parent().parent().remove();
            if(_customValidatorFields[id]) {
                _deletedValidators.customValidators.push(_customValidatorFields[id]);
            }
            delete _customValidatorFields[id];
            //console.log(_deletedValidators);
        }
    };
})();