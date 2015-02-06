<script type = "text/template" id = "formInputText">
	<div class="form-group">
		<label for="input<%= id %>" class="col-md-2 control-label"><%= title %></label>
		<div class="col-md-10">
			<input type="text" class="form-control" id="input<%= id %>" value = "<%= value %>">
		</div>
	</div>
</script>
<?php
	if(!isset($_GET['id'])) {
		$_GET['id'] = 'new';
	}
?>

<script>
	var dataFields = {};
	$(document).ready(function(){
		fillForm(<?php echo $subjectData; ?>);
	});

	function fillForm(subjectData) {
		var inputText = _.template($('#formInputText').html());
		var formData = "";

		dataFields[0] = 0;
		formData += inputText({
			'id' : 0,
			'title' : 'Title',
			'value' : subjectData.title
		});

		for(var key in subjectData.attributes) {
			if(subjectData.attributes.hasOwnProperty(key)) {
				dataFields[key] = subjectData.attributes[key].attribute_id || null;
				formData += inputText({
					'id' : key,
					'title' : subjectData.attributes[key].attribute_title,
					'value' : subjectData.attributes[key].attribute_value
				});
			}
		}
		$('#subjectInfoForm').prepend(formData);
	}

	function deleteSubject(subjectId) {
		$.ajax({
			url : '<?php echo Yii::app()->createAbsoluteUrl('site/deleteSubject'); ?>',
			data : {id : subjectId},
			type: 'GET'
		}).done(function(){

		});
	}

	function collectData() {
		var formData = [];
		for(var key in dataFields){
			if(dataFields.hasOwnProperty(key)) {
				formData.push({
						value:	$('#input' + key).val(),
						type_id : key,
						attribute_id :  dataFields[key]
					});
			}
		}
		return formData;
	}

	function saveData(subjectId) {
		$.ajax({
			url : '<?php echo Yii::app()->createAbsoluteUrl('site/saveSubject'); ?>',
			type : 'POST',
			data : {
				id : subjectId,
				data : collectData()
			}
		}).done(function(){

		});
	}
</script>


<form class="form-horizontal" id = "subjectInfoForm">
	<div class="form-group">
		<div class="pull-right">
			<button type="button" class="btn btn-success" onclick = "saveData('<?php echo $_GET['id']; ?>')">Save</button>
			<button type="button" class="btn btn-success">Save and Close</button>
			<button type="button" class="btn btn-danger" onclick = "deleteSubject(<?php echo $_GET['id']; ?>)">Delete</button>
		</div>
	</div>
</form>