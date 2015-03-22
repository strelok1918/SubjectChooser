var AjaxController = (
    function() {
        var _deleteActionURL = "";
        var _saveActionURL = "";
        return {
            init: function(saveURL, deleteURL) {
                _saveActionURL = saveURL;
                _deleteActionURL = deleteURL;
            },
            deleteSubject: function(subjectId) {
                return $.ajax({
                    url : _deleteActionURL,
                    data : {id : subjectId},
                    type: 'GET'
                });
            },
            saveSubject : function(subjectId, data) {
                return $.ajax({
                    url : _saveActionURL,
                    type : 'POST',
                    data : {
                        id : subjectId,
                        data : data
                    }
                });
            }

        };
    }
)();