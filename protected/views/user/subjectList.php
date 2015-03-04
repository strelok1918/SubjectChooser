<div class="list-group" id = "subjectList"></div>
<script>
	var subjectList = <?php echo json_encode($subjects); ?>;
	console.log(subjectList);
	var subjectListItemDetails = _.template($('#subjectDetailsListItem').html());
	var listItem = _.template($('#subjectListItem').html());
	var data = "";
	for(var id in subjectList) {
		if(subjectList.hasOwnProperty(id)) {
			var attributeData = "";
			for(var attrId in subjectList[id].attributes) {
				if(subjectList[id].attributes.hasOwnProperty(attrId)) {
					attributeData += subjectListItemDetails({   'value': subjectList[id].attributes[attrId].value,
																'title': subjectList[id].attributes[attrId].title});
				}
			}

			data += listItem({  'id' : subjectList[id].id,
								'value': attributeData,
								'title': subjectList[id].title});
//			console.log(data);
		}
	}
	$('#subjectList').append(data);

	var toggleData = function(id) {
		$('#subjectDetails' + id).toggle(200, null);
		$('#caret' + id).toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
	}
</script>