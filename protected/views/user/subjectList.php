<div class="list-group" id = "subjectList"></div>
<script>
	var subjectList = <?php echo json_encode($subjects); ?>;
	var subjectListItem = _.template($('#subjectListItem').html());
	var data = "";
	for(var id in subjectList) {
		console.log(id, subjectList[id]);
		data += subjectListItem({'title': subjectList[id]});
	}
	$('#subjectList').append(data);
</script>