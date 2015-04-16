var AttributeProcessor  = (function(){
    var _fieldIds = {};
    var _fillFields = function(data) {
        var inputText = _.template($('#formInputText').html());
        var result = "";
        for(var key in data) {
            if(data.hasOwnProperty(key)) {
                _fieldIds[key] = data[key].attribute_id || null;
                result += inputText({
                    'id' : key,
                    'title' : data[key].title,
                    'value' : data[key].value
                });
            }
        }
        return result;
    };
    var _collectData = function() {
        var data = [];
        for(var key in _fieldIds){
            if(_fieldIds.hasOwnProperty(key)) {
                data.push({
                    value:	$('#input' + key).val(),
                    type_id : key,
                    attribute_id :  _fieldIds[key]
                });
            }
        }
        return data;
    };
    return {
        collectData : function() {
            return _collectData();
        },
        fillData : function(data) {
            return _fillFields(data);
        }
    };
})();