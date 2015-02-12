var MenuHandler = (function(){
    return {
        deleteSubject: function(subjectId) {
            SubjectProcessor.deleteSubject(subjectId).done(function(data){
                $('#subjectItem' + subjectId).remove();
                $('#deleteSubjectModal').modal('hide');

                var responce = JSON.parse(data);
                var message = "";
                if($.isEmptyObject(responce)) {
                    message = _.template($('#savedSuccessMessage').html());
                }
                $('#messageBox').prepend(message({message : "Предмет " + SubjectMenu.getSubject(subjectId) + " удален успешно."}));
            });
        }
    };
})();