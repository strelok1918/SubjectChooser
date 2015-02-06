<script type = "text/template" id = "subjectListItem">
	<li class="list-group-item" id = "subjectItem<%=id %>"><%= title %>
		<div class = "pull-right">
			<span class="glyphicon glyphicon-info-sign"></span>
			<!-- @TODO parameter with url format: path -->
			<a href = "<?php echo Yii::app()->createAbsoluteUrl('site/editSubject') . "&id="; ?><%= id %>" class = "glyphicon glyphicon-pencil" > </a>
			<span class = "glyphicon glyphicon-remove" style = "cursor: pointer;" onclick = "deleteSubject(<%= id %>)"> </span>
		</div>
	</li>
</script>

<script>
	$(document).ready(function(){
		SubjectMenu.fillSubjectList(<?php echo $subjects; ?>);
	});

	function deleteSubject(subjectId) {
		$.ajax({
			url : '<?php echo Yii::app()->createAbsoluteUrl('site/deleteSubject'); ?>',
			data : {id : subjectId},
			type: 'GET'
		}).done(function(){
			$('#subjectItem' + subjectId).remove();
		});
	}
</script>

<ul class="list-group" id = "subjectMenu">

</ul>

<a type="button" class="btn btn-success btn-lg btn-block" href = "<?php echo Yii::app()->createAbsoluteUrl('site/editSubject'); ?>">Add subject</a>