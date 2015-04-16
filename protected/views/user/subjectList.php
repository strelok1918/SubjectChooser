<div class="list-group" id = "subjectList"></div>

<script>
	$(document).ready(function(){
		AjaxController.init("<?php echo Yii::app()->createAbsoluteURL('user/saveChoose'); ?>", "<?php echo Yii::app()->createAbsoluteURL('user/dismissChoose'); ?>");
		var button  = _.template($('#subscribeButton').html());
		SubjectListPageProcessor.init(<?php echo json_encode($subjects); ?>);
		SubjectListPageProcessor.fillSubjectList(button);
	});
</script>