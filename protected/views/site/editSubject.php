<?php
	if(!isset($_GET['id'])) {
		$_GET['id'] = 'new';
	}
?>

<script>
	var dataFields = {};
	responceHandler = ResponceHandlerEditPage;
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
		SubjectProcessor.saveSubject(subjectId).done(function(data){
			var responce = JSON.parse(data);
			console.log(responce);
			console.log($.isEmptyObject(responce));
			var message = "";
			if($.isEmptyObject(responce)) {
				message = _.template($('#savedSuccessMessage').html());
			}
			$('#messageBox').prepend(message({message : "Изменения сохранены."}));
		});
	}
</script>


<!--<div class="alert alert-danger alert-dismissable">-->
<!--	<button type="button" class="close" data-dismiss="alert"-->
<!--	        aria-hidden="true">-->
<!--		&times;-->
<!--	</button>-->
<!--	Error ! Change few things.-->
<!--</div>-->

<form class="form-horizontal" id = "subjectInfoForm">
	<div class="form-group">
		<div class="pull-right" style = "margin-right: 15px;">
			<button type="button" class="btn btn-success" onclick = "saveData('<?php echo $_GET['id']; ?>')">Сохранить</button>
<!--			<button type="button" class="btn btn-success">Сохранить и закрыть</button>-->
<!--			<button type="button" class="btn btn-info">Очистить форму</button>-->
			<?php if($_GET['id'] != 'new') { ?> <button type="button" class="btn btn-danger" onclick = "SubjectProcessor.showModal(<?php echo $_GET['id']; ?>)">Удалить</button> <?php } ?>
		</div>
	</div>
</form>