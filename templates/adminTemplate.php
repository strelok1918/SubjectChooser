<script type = "text/template" id = "formInputText">
	<div class="form-group">
		<label for="input<%= id %>" class="col-md-2 control-label"><%= title %></label>
		<div class="col-md-10">
            <input type="text" class="form-control" id="input<%= id %>" value = "<%= value %>">
		</div>
	</div>
</script>


<script type = "text/template" id = "formValidatorTemplate">
	<div class="form-group">
		<label for="input" class="col-md-2 control-label"><%= title %></label>

		<div class="input-group col-md-10" style = "padding:0 15px;">
			<div class="input-group-btn">
				<select class="form-control" id = "validatorOperator<%= id %>" style = "width: 65px; border-top-left-radius: 4px; border-bottom-left-radius: 4px">
					<%    for(var key in operators) {
							item = operators[key];	%>
						<option value="<%= item.value %>" <% if(selectedOperator == item.value){ print('selected'); } %>><%= item.title %></option>
					<%     }; %>
				</select>
			</div>
			<input class="form-control" id = "validatorValue<%= id %>" type="text" value = "<%= value %>">
		</div>
	</div>
</script>

<script type = "text/template" id = "customValidatorTemplate">
	<div class="form-group">
		<span class = "glyphicon glyphicon-remove pull-right" style ="color : #c71c22; font-size:30px; margin-right: 15px; margin-top: 4px;" onclick = "CustomValidatorProcessor.deleteField(<%= id %>)"></span>

        <div class="btn-group col-md-3  pull-right" data-toggle="buttons">
            <label class="btn btn-default col-xs-6 <% if(display == '1'){ print('active'); } %>">
                <input type="checkbox" autocomplete="off" id = "validDisplay<%= id %>" <% if(display == '1'){ print('checked'); } %>> Вывод
            </label>
            <label class="btn btn-default col-xs-6 <% if(save == '1'){ print('active'); } %>">
                <input type="checkbox" autocomplete="off" id = "validSave<%= id %>" <% if(save == '1'){ print('checked'); } %>> Сохранение
            </label>
        </div>
        <div class="col-md-8 pull-right">
            <input type = "text" class = "form-control" id = "customValidator<%= id %>" placeholder = "SQL Text" value = "<%= value %>">
        </div>
	</div>
</script>

<script type = "text/template" id = "statListItem">
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><b><%= subject_title %></b><span class="pull-right badge"><%= count %></span></h3>
	</div>
	<ul class="list-group">
		<%= groups %>
	</ul>
</div>
</script>

<script type = "text/template" id = "statGroupItem">
	<div class="list-group-item">
		<h4 class="list-group-item-heading"><%= title %><span class="pull-right badge"><%= count %></span></h4>
		<p class="list-group-item-text">
		<ol>
			<%= student_list %>
		</ol>
		</p>
	</div>
</script>

<script type = "text/template" id = "statUserItem">
	<li><%= first_name %>  <%= second_name %>  (<%= semester %> семестр, <%= year %>)</li>
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
				<button type="button" class="btn btn-danger" onclick="DeleteHandler.deleteSubject()">Удалить</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
			</div>
		</div>
	</div>
</div>

