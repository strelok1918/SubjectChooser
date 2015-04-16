var EditSubjectFormProcessor = (function(){
    var _subjectId;
    var _subjectListPage;

    var _fillData = function(data) {
        data.attributes[0] = {'title' : 'Название',
                              'value' : data.title};

        $('#attributes').prepend(AttributeProcessor.fillData(data.attributes));
        $('#validators').prepend(ValidatorProcessor.fillData(data.validators));
        $('#customValidators').prepend(CustomValidatorProcessor.fillData(data.customValidators));
    };
    var _collectData = function() {
        var attributeData = AttributeProcessor.collectData();
        var validatorData = ValidatorProcessor.collectData();
        var customValidatorData = CustomValidatorProcessor.collectData();
        console.log(customValidatorData);
        return {
            'attributes' : attributeData,
            'validators' : validatorData.data,
            'customValidators' : customValidatorData.data,
            'deleted' : {
                        'validators' : validatorData.deleted,
                        'customValidators' :customValidatorData.deleted
                    }
        };
    };

    return {
        init : function() {
            CustomValidatorProcessor.init();
        },
        fillData :  function(data) {
            _fillData(data);
        },
        collectData : function(){
            return _collectData();
        },
        setSubjectId : function(id) {
            _subjectId = id;
        },
        saveForm : function() {
            AjaxController.saveSubject(_subjectId, _collectData()).done(function(responce) {
                var data = JSON.parse(responce);
                _subjectId = data.subjectData.id;

                $('#attributes').empty();
                $('#validators').empty();
                $('#customValidators').empty();
                CustomValidatorProcessor.clear();
                _fillData(data.subjectData);
                AlertHandler.showAlert(data.errors, "Изменения сохранены.");
            });
        },
        setSubjectListPage : function(URL) {
            _subjectListPage = URL;
        },
        showDeleteModal : function() {
            $('#dropSubjectId').val();
            $('#deleteDialogSubjectTitle').empty();
            $('#deleteSubjectModal').modal('show');
        },
        deleteSubject: function() {
            AjaxController.deleteSubject(_subjectId).done(function(data){
                $('#deleteSubjectModal').modal('hide');
                AlertHandler.showAlert(JSON.parse(data), "Предмет успешно удален");
                window.location = _subjectListPage;
            });
        }
    };
})();