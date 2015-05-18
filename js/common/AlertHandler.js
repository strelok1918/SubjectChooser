var AlertHandler = (function(){
    var _succesAlertTemplate;
    var _errorAlertTemplate;

    var _compileTemplates = function() {
        _succesAlertTemplate =_.template($('#successAlert').html());
        _errorAlertTemplate =_.template($('#errorAlert').html());
    };
    var _showAlert = function(errorList, successMessage) {
        console.log(errorList);
        var resultAlert = "";
        if($.isEmptyObject(errorList)) {
            resultAlert = _succesAlertTemplate({message : successMessage});
        } else {

            for(var key in errorList) {
                if(errorList.hasOwnProperty(key)) {
                    resultAlert += _errorAlertTemplate({message : errorList[key]});
                }
            }
        }
        $('#messageBox').prepend(resultAlert);
    };
    return {
        init : function() {
            _compileTemplates();
        },
        showAlert : function(errors, successMessage) {

            _showAlert(errors, successMessage);
        }
    };
})();