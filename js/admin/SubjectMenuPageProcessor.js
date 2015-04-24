var SubjectMenuPageProcessor = (function(){
    var _subjectTitleMapping = {};
    var _deleteDialog;
    var _compileTemplates = function() {
        _deleteDialog = _.template($("#deleteSubjectModal").html());
    };
    return {
        init :  function() {
            _compileTemplates();
        },
        getSubject : function(subjectId) {
            return _subjectTitleMapping[subjectId];
        },
        showDeleteModal : function(subjectId){
            $('#dropSubjectId').val(subjectId);
            $('#deleteDialogSubjectTitle').empty();
            $('#deleteDialogSubjectTitle').append(_subjectTitleMapping[subjectId]);
            $('#deleteSubjectModal').modal('show');
        },
        deleteSubject : function() {
            var subjectId = $('#dropSubjectId').val();
            AjaxController.deleteSubject(subjectId).done(function(data){
                $('#subjectItem' + subjectId).remove();
                $('#deleteSubjectModal').modal('hide');
                var responce = JSON.parse(data);
                AlertHandler.showAlert(responce, "Предмет " + SubjectMenu.getSubject(subjectId) + " удален успешно.");
            });
        },
        fillData : function(subjectData) {
            //console.log(subjectData);
            var subjectItem = _.template($('#subjectListItem').html());
            for(var key in subjectData) {
                if(subjectData.hasOwnProperty(key)) {
                    _subjectTitleMapping[key] = subjectData[key];
                    $('#subjectMenu').append(subjectItem({
                        id : subjectData[key].id,
                        title : subjectData[key].title
                    }));
                }
            }
        }
    };
})();