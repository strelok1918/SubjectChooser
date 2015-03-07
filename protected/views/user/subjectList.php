<div class="modal" id = "disciplineChoose">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Выбор предмета</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
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
							<select class="form-control">
								<option>I</option>
								<option>II</option>
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-success">Сохранить</button>
			</div>
		</div>
	</div>
</div>


<div class="list-group" id = "subjectList"></div>
<script>
	var subjectList = <?php echo json_encode($subjects); ?>;
	console.log(subjectList);
	var subjectListItemDetails = _.template($('#subjectDetailsListItem').html());
	var listItem = _.template($('#subjectListItem').html());
	var data = "";
	for(var id in subjectList) {
		if(subjectList.hasOwnProperty(id)) {
			var attributeData = "";
			for(var attrId in subjectList[id].attributes) {
				if(subjectList[id].attributes.hasOwnProperty(attrId)) {
					attributeData += subjectListItemDetails({   'value': subjectList[id].attributes[attrId].value,
																'title': subjectList[id].attributes[attrId].title});
				}
			}

			data += listItem({  'id' : subjectList[id].id,
								'value': attributeData,
								'title': subjectList[id].title});
//			console.log(data);
		}
	}
	$('#subjectList').append(data);

	var toggleData = function(id) {
		$('#subjectDetails' + id).toggle(200, null);
		$('#caret' + id).toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
	}
</script>