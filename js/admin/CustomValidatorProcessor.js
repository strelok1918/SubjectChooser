var CustomValidatorProcessor = (function(){
    var _fieldIds = {};
    var _lastId = 0;
    var _deleted = [];
    var _validatorTemplate;

    var _addValidator = function(id, value, action) {
        //console.log(value, action);
        _lastId++;
        _fieldIds[_lastId] = id;
        return _validatorTemplate({'id' : _lastId, 'value' : value, 'display' : action[0], 'save' : action[1]});
    };

    var _fillData = function(data) {
        var result = "";
        for(var key in data) {
            if(data.hasOwnProperty(key)) {
                result += _addValidator(data[key].id, data[key].value, data[key].action);
            }
        }

        return result;
    };
    var _collectData = function() {
        var data = [];
        for(var key in _fieldIds) {
            if(_fieldIds.hasOwnProperty(key)) {
                if(!$('#customValidator' + key).val()) {
                    if(_fieldIds[key]) {
                        _deleted.push(_fieldIds[key]);
                    }
                } else {
                    var action = +$('#validDisplay' + key).prop('checked') + '' + +$('#validSave' + key).prop('checked');
                    data.push({
                        'id': _fieldIds[key],
                        'value': $('#customValidator' + key).val(),
                        'action' : action
                    });
                }
            }
        }
        return {'data' : data, 'deleted' : _deleted};
    };
    var _compileTemplates = function() {
        _validatorTemplate = _.template($('#customValidatorTemplate').html());
    };
    return {
        init : function(){
            _compileTemplates();
        },
        clear : function() {
            _lastId = 0;
            _fieldIds = {};
        },
        collectData : function() {
            return _collectData();
        },
        fillData : function(data) {
            return _fillData(data);
        },
        addField : function() {
            $('#customValidators').append(_addValidator(null, null, "11"));
        },
        deleteField : function(id) {
            $('#customValidator' + id).parent().parent().remove();
            if(_fieldIds[id]) {
                _deleted.push(_fieldIds[id]);
            }
            delete _fieldIds[id];
        }
    };
})();