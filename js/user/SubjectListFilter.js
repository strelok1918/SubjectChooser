var SubjectListFilter = (function(){
    var _subjectList,
        _dismissButton;
    var _yearsVisible = {},
        _subjectsVisible = {};

    var compileTemplates = function() {
        _dismissButton = _.template($('#dismissButton').html());
    };
    var siftSubjects = function() {
        var result = [];
        var semester ={ '1' : $('#1semester').prop('checked'),
            '2' : $('#2semester').prop('checked')};
        var year = $('#yearFilter').val();
        var subjects = $('#subjectFilter').val();
        for(var key in _subjectList) {
            if(_subjectList.hasOwnProperty(key)) {
                var item = _subjectList[key],
                    semesterValid =  (year || (semester[1] || semester[2])) ? semester[item.attributes.semester.value] : true,
                    yearValid = (year) ? _yearsVisible[item.attributes.year.value] : true,
                    subjectValid = (subjects) ? _subjectsVisible[_subjectList[key].title] : true;
                if(semesterValid && yearValid && subjectValid) {
                   result.push(item)
                }
            }
        }

        return result;
    };
    var createList = function(list) {
        var result = "";
        for(var key in list) {
            if(list.hasOwnProperty(key)) {
                result += "<option value = '" + key + "'> " + list[key] + "</option>";
            }
        }
        return result;
    };

    var fillFields = function() {
        var years = {},
            subjects = {};
        for(var key in _subjectList) {
             if(_subjectList.hasOwnProperty(key)) {
                 years[_subjectList[key].attributes.year.value] = _subjectList[key].attributes.year.value;
                 subjects[_subjectList[key].title] = _subjectList[key].title;
                 _yearsVisible[_subjectList[key].attributes.year.value] = false;
                 _subjectsVisible[_subjectList[key].title] = false;
             }
        }
        $('#subjectFilter').append(createList(subjects));
        $('#yearFilter').append(createList(years));
    };
    return {
        init: function(data) {
            compileTemplates();
            _subjectList = data;
            //console.log(data);
            fillFields();
            SubjectListPageProcessor.init();
            SubjectListPageProcessor.fillSubjectList(data, _dismissButton);
        },
        selectYear : function(id) {
            _yearsVisible[id] = !_yearsVisible[id];
        },
        selectSubject : function(id) {
            _subjectsVisible[id] = !_subjectsVisible[id];
        },
        filterSubjects : function() {
            SubjectListPageProcessor.fillSubjectList(siftSubjects(), _dismissButton);
        }
    };
})();