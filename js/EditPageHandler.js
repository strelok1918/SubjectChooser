var EditPageHandler = (function(){
    var _dataFields = {};
    var _subjectListPage = "";
    var collectData = function() {
        var formData = [];
        for(var key in _dataFields){
            if(_dataFields.hasOwnProperty(key)) {
                formData.push({
                    value:	$('#input' + key).val(),
                    type_id : key,
                    attribute_id :  _dataFields[key]
                });
            }
        }
        return formData;
    };

    var showResponceAlert = function(responce, successMessage) {
        var data = JSON.parse(responce);
        console.log(data);
        console.log($.isEmptyObject(data));
        var resultAlert = "";
        var message;
        if($.isEmptyObject(data)) {
            resultAlert = _.template($('#savedSuccessMessage').html());
            message = successMessage;
            window.location = _subjectListPage;
        }
        $('#messageBox').prepend(resultAlert({message : message}));
    };
    return{
        saveData : function(subjectId) {
            SubjectProcessor.saveSubject(subjectId, collectData()).done(function(data){
                showResponceAlert(data, "Изменения сохранены.");
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
            });
        },
        fillForm : function(subjectData) {
            var inputText = _.template($('#formInputText').html());
            var formData = "";

            _dataFields[0] = 0;
            formData += inputText({
                'id' : 0,
                'title' : 'Title',
                'value' : subjectData.title
            });

            for(var key in subjectData.attributes) {
                if(subjectData.attributes.hasOwnProperty(key)) {
                    _dataFields[key] = subjectData.attributes[key].attribute_id || null;
                    formData += inputText({
                        'id' : key,
                        'title' : subjectData.attributes[key].attribute_title,
                        'value' : subjectData.attributes[key].attribute_value
                    });
                }
            }
            $('#subjectInfoForm').prepend(formData);
        },
        setSubjectListPage : function(URL) {
            _subjectListPage = URL;
        }
    };
})();