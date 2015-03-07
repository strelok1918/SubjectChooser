<?php
//	print_r($data);
?>
<script>
	$(document).ready(function(){
		var subjectData = <?php echo json_encode($data['attributes']); ?> ;
		var item = _.template($('#subjectDetailsListItem').html());
		var data = "";
		for(var key in subjectData) {
			if(subjectData.hasOwnProperty(key)) {
				data += item({
					'title' : subjectData[key].attribute_title,
					'value' : subjectData[key].attribute_value
				});
			}
		}
		$('#subjectInfoBlock').prepend(data);
		$('#myModal').on('shown.bs.modal', function () {
			$('#myInput').focus()
		});
	});
</script>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
	Launch demo modal
</button>

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
								<option>2014</option>
								<option>2015</option>
							</select>
						</div>
					</div>
					<div class = "form-group">
						<label for = "year" class="col-md-3 control-label">Семестр</label>
						<div class="col-md-9">
							<select class="form-control">
								<option>1</option>
								<option>2</option>
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary">Сохранить</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->