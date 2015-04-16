var SubjectListPageProcessor = (function(){
    var _subjects,
        _subjectListItemDetails,
        _listItem;

    var compileTemplates = function(){
        _subjectListItemDetails = _.template($('#subjectDetailsListItem').html());
        _listItem = _.template($('#subjectListItem').html());
    };
    var compileSubjectData = function(subjectData) {
        var attributeData = "";
        for(var attrId in subjectData) {
            if(subjectData.hasOwnProperty(attrId)) {
                attributeData += _subjectListItemDetails({
                    'value': subjectData[attrId].value,
                    'title': subjectData[attrId].title});
            }
        }
        return attributeData;
    };
    return {
        init : function(subjectList){
            _subjects = subjectList;
            compileTemplates();
        },
        fillSubjectList : function(button) {
            $('#subjectList').empty();
            var data = "";
            for(var id in _subjects) {
                if(_subjects.hasOwnProperty(id)) {

                    data += _listItem({  'id' : _subjects[id].id,
                        'value': compileSubjectData(_subjects[id].attributes),
                        'button' : button({'id' : _subjects[id].id}),
                        'title': _subjects[id].title});
                }
            }
            $('#subjectList').append(data);
        },
        toggleData : function(id) {
            $('#subjectDetails' + id).toggle(200, null);
            $('#caret' + id).toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
        },
        filterSubjects : function(button) {
            $('#subjectList').empty();
            var year = $('#yearFilter').val();
            var semester = $('#semesterFilter').val();
            var data = "";
            for(var id in _subjects) {
                if(_subjects.hasOwnProperty(id)) {
                    var yearValid = (year) ? _subjects[id].attributes['year'].value == year : true;
                    var semesterValid = (semester) ? _subjects[id].attributes['semester'].value == semester : true;
                    if(yearValid && semesterValid) {
                        data += _listItem({  'id' : _subjects[id].id,
                            'value': compileSubjectData(_subjects[id].attributes),
                            'button' : button({'id' : _subjects[id].id}),
                            'title': _subjects[id].title});
                    }
                }
            }
            $('#subjectList').append(data);
        }
    };
})();