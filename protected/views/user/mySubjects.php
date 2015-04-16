<script>
		var button;
		$(document).ready(function(){
		AjaxController.init("<?php echo Yii::app()->createAbsoluteURL('user/saveChoose'); ?>", "<?php echo Yii::app()->createAbsoluteURL('user/dismissChoose'); ?>");
		button = _.template($('#dismissButton').html());
		SubjectListPageProcessor.init(<?php echo json_encode($subjects); ?>);
		SubjectListPageProcessor.fillSubjectList(button);
	});
</script>
<div class="panel panel-default">
	<div class="panel-body">
		<form class="form-inline" onsubmit = "return false;">
			<div class="form-group">
				<label for="yearFilter">Год</label>
				<input type="text" class="form-control input-sm" id="yearFilter" placeholder="Год">
			</div>
			<div class="form-group">
				<label for="semesterFilter">Семестр</label>
				<select class="form-control input-sm" id = "semesterFilter">
					<option value = "" selested></option>
					<option value = "1">I</option>
					<option value = "2">II</option>
				</select>
			</div>
			<button type="button" class="btn btn-default btn-sm" onclick = "SubjectListPageProcessor.filterSubjects(button)">Выбрать</button>
			<button type="button" class="btn btn-default btn-sm" onclick = "SubjectListPageProcessor.fillSubjectList(button)">Clear</button>
		</form>
	</div>
</div>
<div class="list-group" id = "subjectList"></div>