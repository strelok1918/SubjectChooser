<script type = "text/template" id = "formInputText">
	<div class="form-group">
		<label for="input<%= id %>" class="col-md-2 control-label"><%= title %></label>
		<div class="col-md-10">
			<input type="text" class="form-control" id="input<%= id %>" value = "<%= value %>">
		</div>
	</div>
</script>

<script type = "text/template" id = "subjectListItem">
	<li class="list-group-item" id = "subjectItem<%=id %>">
		<span class = "subjectItemTitle"><%= title %></span>
		<div class = "pull-right">
			<img src = "<?php echo Yii::app()->baseUrl; ?>/images/icons/info.png" class = "subjectItemIcon">
			<img src = "<?php echo Yii::app()->baseUrl; ?>/images/icons/edit.png" class = "subjectItemIcon" onclick = "location.href = '<?php echo Yii::app()->createAbsoluteUrl('admin/editSubject', array ('id' => '' )); ?><%= id %>'">
			<img src = "<?php echo Yii::app()->baseUrl; ?>/images/icons/delete.png"onclick = "SubjectMenu.showDeleteDialog(<%= id %>)" class = "subjectItemIcon">
		</div>
	</li>
</script>

<script type = "text/template" id = "savedSuccessMessage">
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert"
		        aria-hidden="true">
			&times;
		</button>
		<%= message %>
	</div>
</script>

<div class="modal fade" id="deleteSubjectModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Удаление дисциплины</h4>
			</div>
			<div class="modal-body">
				<p>Удалить дисциплину <span id = "deleteDialogSubjectTitle"></span>?</p>
			</div>
			<div class="modal-footer">
				<input type = "hidden" id = "dropSubjectId">
				<button type="button" class="btn btn-danger" onclick="responceHandler.deleteSubject($('#dropSubjectId').val())">Удалить</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
			</div>
		</div>
	</div>
</div>