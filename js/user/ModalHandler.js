var ModalHandler = (function(){
    return  {
        fillModalData : function(id) {
            $('#subjectId').val(id);
        },
        fillDismissModal : function(id) {
            $('#chooseId').val(id);
        }
    };
})();