var SubjectStatistics = (function(){
    var _data;

    var _subjectTemplate,
        _userTemplate,
        _groupTemplate;

    var _subjectsVisible = {},
        _groupsVisible = {},
        _studentsVisible = {},
        _yearsVisible = {};

    var siftSubjects = function() {
        var result = {};
        var semester ={ '1' : $('#1semester').prop('checked'),
                        '2' : $('#2semester').prop('checked')};
        var year = $('#yearFilter').val();
        var subjects = $('#subjectFilter').val();
        var users = $('#studentFilter').val();
        var groups = $('#groupFilter').val();

        for(var key in _data) {
            if(_data.hasOwnProperty(key)) {
                var item = _data[key],
                    semesterValid =  (year || (semester[1] || semester[2])) ? semester[item.semester] : true,
                    userValid = (users) ? _studentsVisible[item.user_id] : true,
                    groupValid = (groups) ? _groupsVisible[item.group_id] : true,
                    yearValid = (year) ? _yearsVisible[item.year] : true,
                    subjectValid = (subjects) ? _subjectsVisible[item.subject_id] : true;

                if(semesterValid && yearValid && userValid && groupValid && subjectValid) {
                    if(!result.hasOwnProperty(item.subject_id)) {
                        result[item.subject_id] = {'title' : item.title, 'groups' : {}};
                    }
                    if(!result[item.subject_id].groups.hasOwnProperty(item.group_id)) {
                        result[item.subject_id].groups[item.group_id] = {'title' : item.group, 'users' : []};
                    }
                    result[item.subject_id].groups[item.group_id].users.push({  'user_id' : item.user_id,
                                                                                'first_name' : item.first_name,
                                                                                'second_name' : item.second_name,
                                                                                'year' : item.year,
                                                                                'semester' : item.semester });
                }
            }
        }
        return result;
    };

    var fillSubjectlist = function(subjects) {
        var result = "";
        for(var subjectId in subjects) {
            if(subjects.hasOwnProperty(subjectId)) {
                var count = 0;
                var groups = "";
                for(var groupId in subjects[subjectId].groups) {

                    if(subjects[subjectId].groups.hasOwnProperty(groupId)) {
                        var users = "";
                        count += subjects[subjectId].groups[groupId].users.length;
                        for(var userId in subjects[subjectId].groups[groupId].users) {
                            users += _userTemplate({'first_name' : subjects[subjectId].groups[groupId].users[userId].first_name,
                                                    'second_name' : subjects[subjectId].groups[groupId].users[userId].second_name,
                                                    'year' : subjects[subjectId].groups[groupId].users[userId].year,
                                                    'semester' : subjects[subjectId].groups[groupId].users[userId].semester});
                        }
                        groups += _groupTemplate({
                           'title' : subjects[subjectId].groups[groupId].title,
                           'count' : subjects[subjectId].groups[groupId].users.length,
                           'student_list' : users
                        });
                    }
                }
                result += _subjectTemplate({'subject_title' : subjects[subjectId].title, 'count': count, 'groups': groups});
            }
        }
        return result;
    };
    var compileTemplates = function() {
        _subjectTemplate = _.template($('#statListItem').html());
        _userTemplate = _.template($('#statUserItem').html());
        _groupTemplate = _.template($('#statGroupItem').html());
    };

    var fillFields = function() {
        var subjects = {};
        var years = {};
        var groups = {};
        var students = {};

        for(var key in _data) {
            if(_data.hasOwnProperty(key)) {
                subjects[_data[key].subject_id] = _data[key].title;
                _subjectsVisible[_data[key].subject_id] = false;

                years[_data[key].year] = _data[key].year;
                _yearsVisible[_data[key].year] = false;
                if(!groups.hasOwnProperty(_data[key].group_id)) {
                    groups[_data[key].group_id] = { 'title' : _data[key].group, 'students' : {}};
                    _groupsVisible[_data[key].group_id] = false;
                }

                groups[_data[key].group_id].students[_data[key].user_id] = _data[key].first_name + " " + _data[key].second_name;
                _studentsVisible[_data[key].user_id] = false;
            }
        }

        var groupList = "",
            userList = "";
        for(var key in groups) {
            groupList += "<option value = '" + key + "'> " + groups[key].title + "</option>";
            userList += "<optgroup label = " + groups[key].title + " id = 'usersGroup" + key+ "'>";
            for(var userId in groups[key].students) {
                userList += "<option value = '" + userId + "'> " + groups[key].students[userId] + "</option>";
            }
            userList += "</optgroup>";
        }
        $('#subjectFilter').append(createList(subjects));
        $('#yearFilter').append(createList(years));
        $('#groupFilter').append(groupList);
        $('#studentFilter').append(userList);
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
    return {
        init : function(data) {
            _data = data;
            compileTemplates();
            fillFields();
        },
        filterSubjects : function() {
            var subjects = siftSubjects();
            $('#subjectsList').empty();
            $('#subjectsList').append(fillSubjectlist(subjects));
        },
        selectYear : function(id) {
            _yearsVisible[id] = !_yearsVisible[id];
        },
        selectSubject : function(id) {
            _subjectsVisible[id] = !_subjectsVisible[id];
        },
        selectGroup : function(id) {
            _groupsVisible[id] = !_groupsVisible[id];
        },
        selectUser : function(id) {
            _studentsVisible[id] = !_studentsVisible[id];
        }
    };
})();
