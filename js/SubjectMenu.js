var SubjectMenu = (function(){
    var _subjectTitleMapping = {};

    return {
        getSubject : function(subjectId) {
            return _subjectTitleMapping[subjectId];
        },
        showDeleteDialog: function(subjectId) {
            $('#dropSubjectId').val(subjectId);
            $('#deleteDialogSubjectTitle').empty();
            $('#deleteDialogSubjectTitle').append(_subjectTitleMapping[subjectId]);
            $('#deleteSubjectModal').modal('show');
        },
        fillSubjectList: function(subjects) {
            var subjectItem = _.template($('#subjectListItem').html());
            for(var key in subjects) {
                if(subjects.hasOwnProperty(key)) {
                    _subjectTitleMapping[key] = subjects[key];
                    $('#subjectMenu').append(subjectItem({
                        id : key,
                        title : subjects[key]
                    }));
                }
            }
        }
    };
})();