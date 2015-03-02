<div class="list-group" id = "subjectList"></div>
<script>
	var subjectList = <?php echo json_encode($subjects); ?>;
	var subjectListItem = _.template($('#subjectListItem').html());
	var data = "";
	for(var id in subjectList) {
		if(subjectList.hasOwnProperty(id)) {
			data += subjectListItem({'id': id, 'title': subjectList[id]});
		}
	}
	$('#subjectList').append(data);
</script>