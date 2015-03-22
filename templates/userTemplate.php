<script type = "text/template" id = "subjectListItem">
	<div class="panel panel-default" style = "margin-bottom: 5px !important;" id = "subjectItem<%= id %>">
		<div class="panel-heading" id = "subjectTitle<%= id %>"><b style = "font-size:18px;"><%= title %></b> <span id = "caret<%= id %>" class="glyphicon glyphicon-chevron-down pull-right" onclick = "SubjectListPageProcessor.toggleData(<%= id %>)" style = "margin-top:5px;cursor: pointer;"></span></div>
		<div id = "subjectDetails<%= id %>" style = "display:none;">
			<ul class="list-group" style = "margin-bottom: 0 !important;">
				<%= value %>
			</ul>
			<div class ="panel-body">
				<%= button %>
			</div>
		</div>
	</div>
</script>

<script type = "text/template" id = "subjectDetailsListItem">
	<li class="list-group-item">
		<h4 class="list-group-item-heading"><%= title %></h4>
		<p class="list-group-item-text"><%= value %></p>
	</li>
</script>

<script type = "text/template" id = "subscribeButton">
	<button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#disciplineChooseModal" onclick="ModalHandler.fillModalData(<%= id %>)">Записаться</button>
</script>

<script type = "text/template" id = "dismissButton">
	<button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#deleteSubjectModal" onclick="ModalHandler.fillDismissModal(<%= id %>)">Отписаться</button>
</script>

<div class="modal" id = "disciplineChooseModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Выбор предмета</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
					<input type = "hidden" id = "subjectId">
					<div class = "form-group">
						<label for = "year" class="col-md-3 control-label">Год обучения</label>
						<div class="col-md-9">
							<select class="form-control" id = "year">
								<option><?php echo date("Y"); ?></option>
								<option><?php echo date("Y") + 1; ?></option>
							</select>
						</div>
					</div>
					<div class = "form-group">
						<label for = "year" class="col-md-3 control-label">Семестр</label>
						<div class="col-md-9">
							<select class="form-control" id = "semester">
								<option value = "1">I</option>
								<option value = "2">II</option>
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-success" onclick="ChooseHandler.saveChoose()">Сохранить</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="deleteSubjectModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Отмена выбора дисциплины</h4>
			</div>
			<div class="modal-body">
				<p>Отписаться от дисциплины?</p>
			</div>
			<div class="modal-footer">
				<input type = "hidden" id = "chooseId">
				<button type="button" class="btn btn-danger" onclick="ChooseHandler.dismissChoose($('#chooseId').val())">Отписаться</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
			</div>
		</div>
	</div>
</div>
