<script>
	$(document).ready(function(){
		SubjectMenuPageProcessor.fillData(<?php echo $subjects; ?>);
	});
</script>

<ul class="list-group" id = "subjectMenu"></ul>

<a type="button" class="btn btn-info pull-right col-md-2" href = "<?php echo Yii::app()->createAbsoluteUrl('admin/editSubject'); ?>">Добавить дисциплину</a>