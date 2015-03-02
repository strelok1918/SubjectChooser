<script type = "text/template" id = "subjectListItem">
	<a href="<?php echo Yii::app()->createAbsoluteUrl("user/subjectDetails", array('id' => ''))?><%= id %>" class="list-group-item"> <%= title %> </a>
</script>