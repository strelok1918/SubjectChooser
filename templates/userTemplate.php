<script type = "text/template" id = "subjectListItem">
	<div class="panel panel-default" style = "margin-bottom: 5px !important;">
		<div class="panel-heading" id = "subjectTitle<%= id %>"><b style = "font-size:18px;"><%= title %></b> <span id = "caret<%= id %>" class="glyphicon glyphicon-chevron-down pull-right" onclick = "toggleData(<%= id %>)" style = "margin-top:5px;cursor: pointer;"></span></div>
		<div id = "subjectDetails<%= id %>" style = "display:none;">
			<ul class="list-group" style = "margin-bottom: 0 !important;">
				<%= value %>
			</ul>
			<div class ="panel-body">
				<button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#disciplineChoose">Записаться</button>
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