var SubjectListPageProcessor = (function(){
    return {
        fillSubjectList : function(subjectList, button) {
            var subjectListItemDetails = _.template($('#subjectDetailsListItem').html());
            var listItem = _.template($('#subjectListItem').html());
            var data = "";
            for(var id in subjectList) {
                if(subjectList.hasOwnProperty(id)) {
                    var attributeData = "";
                    for(var attrId in subjectList[id].attributes) {
                        if(subjectList[id].attributes.hasOwnProperty(attrId)) {
                            attributeData += subjectListItemDetails({
                                'value': subjectList[id].attributes[attrId].value,
                                'title': subjectList[id].attributes[attrId].title});
                        }
                    }
                    data += listItem({  'id' : subjectList[id].id,
                        'value': attributeData,
                        'button' : button({'id' : subjectList[id].id}),
                        'title': subjectList[id].title});
                }
            }
            $('#subjectList').append(data);
        },
        toggleData : function(id) {
            $('#subjectDetails' + id).toggle(200, null);
            $('#caret' + id).toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
        }
    };
})();