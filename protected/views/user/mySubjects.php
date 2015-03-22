<script>
	$(document).ready(function(){
		AjaxController.init("<?php echo Yii::app()->createAbsoluteURL('user/saveChoose'); ?>", "<?php echo Yii::app()->createAbsoluteURL('user/dismissChoose'); ?>");
		var button  = _.template($('#dismissButton').html());
		SubjectListPageProcessor.fillSubjectList( <?php echo json_encode($subjects); ?>, button);
	});
</script>
<div class="panel panel-default">
	<div class="panel-body">
		<form class="form-inline">
			<div class="form-group">
				<label for="exampleInputName2">Name</label>
				<input type="text" class="form-control input-sm" id="exampleInputName2" placeholder="Jane Doe">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail2">Email</label>
				<input type="email" class="form-control input-sm" id="exampleInputEmail2" placeholder="jane.doe@example.com">
			</div>
			<button type="submit" class="btn btn-default btn-sm"">Send invitation</button>
		</form>
	</div>
</div>
<div class="list-group" id = "subjectList"></div>