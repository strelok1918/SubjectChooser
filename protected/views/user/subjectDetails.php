<?php
//	print_r($data);
?>
<script>
	$(document).ready(function(){
		var subjectData = <?php echo json_encode($data['attributes']); ?> ;
		var item = _.template($('#subjectDetailsListItem').html());
		var data = "";
		for(var key in subjectData) {
			if(subjectData.hasOwnProperty(key)) {
				data += item({
					'title' : subjectData[key].attribute_title,
					'value' : subjectData[key].attribute_value
				});
			}
		}
		$('#subjectInfoBlock').prepend(data);
	});
</script>
<h1 class="text-center"> <?php echo $data['title']; ?></h1>
<div class = " row col-md-offset-2 col-md-8">
	<div id = "subjectInfoBlock" class = "list-group">


	</div>
	<div class = "">
		<button type="button" class="btn btn-warning pull-right">Записаться</button>
	</div>
<div>
