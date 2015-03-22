var AjaxController = (function(){
    var _saveChooseURL,
        _dismissChooseURL;

    return {
        init: function(saveChooseURL, dismissChooseURL) {
            _saveChooseURL = saveChooseURL;
            _dismissChooseURL = dismissChooseURL;
        },
        dismissChoose : function(id) {
            return $.ajax({
                url : _dismissChooseURL,
                type : 'POST',
                data : {data : id}
            });
        },
        saveChoose : function(data) {
            return $.ajax({
                url : _saveChooseURL,
                type : 'POST',
                data : {data : data}
            });
        }
    };
})();