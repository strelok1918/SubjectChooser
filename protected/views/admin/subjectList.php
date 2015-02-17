<script>
	responceHandler = MenuHandler;
	$(document).ready(function(){
		SubjectMenu.fillSubjectList(<?php echo $subjects; ?>);
	});
</script>

<ul class="list-group" id = "subjectMenu"></ul>

<a type="button" class="btn btn-success btn-lg btn-block" href = "<?php echo Yii::app()->createAbsoluteUrl('admin/editSubject'); ?>">Добавить дисциплину</a>