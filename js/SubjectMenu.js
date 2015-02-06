var SubjectMenu = (
    function() {
        return {
            fillSubjectList: function(subjects) {
                var subjectItem = _.template($('#subjectListItem').html());
                for(var key in subjects) {
                    if(subjects.hasOwnProperty(key)) {
                        $('#subjectMenu').append(subjectItem({
                            id : key,
                            title : subjects[key]
                        }));
                    }
                }
            }
        };
    }
)();