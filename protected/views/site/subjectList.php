<script>
	responceHandler = ResponceHandlerMenu;
	$(document).ready(function(){
		SubjectMenu.fillSubjectList(<?php echo $subjects; ?>);
	});


</script>

<ul class="list-group" id = "subjectMenu"></ul>

<a type="button" class="btn btn-success btn-lg btn-block" href = "<?php echo Yii::app()->createAbsoluteUrl('site/editSubject'); ?>">Добавить дисциплину</a>