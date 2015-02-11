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
    return{
        saveData : function(subjectId) {
            SubjectProcessor.saveSubject(subjectId, collectData()).done(function(data){
                var responce = JSON.parse(data);
                console.log(responce);
                console.log($.isEmptyObject(responce));
                var message = "";
                if($.isEmptyObject(responce)) {
                    message = _.template($('#savedSuccessMessage').html());
                }
                $('#messageBox').prepend(message({message : "Изменения сохранены."}));
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
                var responce = JSON.parse(data);
                var message = "";
                if($.isEmptyObject(responce)) {
                    message = _.template($('#savedSuccessMessage').html());
                }
                $('#messageBox').prepend(message({message : "Предмет удален успешно."}));

                $('button.close').one('click', function(){
                    window.location = _subjectListPage;
                });
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