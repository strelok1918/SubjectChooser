var ChooseHandler = (function(){
    return {
         saveChoose : function() {
            var data = {
                'object_id' : $('#subjectId').val(),
                'year' : $('#year').val(),
                'semester' : $('#semester').val()
            };
            AjaxController.saveChoose(data).done(function(data){
                $('#disciplineChooseModal').modal('hide');
                data = JSON.parse(data);
                AlertHandler.showAlert(data.errors, "Изменения сохранены.");
            });
        },
        dismissChoose : function(id) {
            AjaxController.dismissChoose(id).done(function(data){
                $('#deleteSubjectModal').modal('hide');
                data = JSON.parse(data);
                AlertHandler.showAlert(data.errors, "Выбор отменен.");
                if($.isEmptyObject(data.errors)) {
                    $('#subjectItem' + id).remove();
                }
            });
        }
    };
})();