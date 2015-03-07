<?php if(!isset($_GET['id'])) $_GET['id'] = 'new'; ?>

<script>
	var currentSubjectId = '<?php echo $_GET['id']; ?>';
	EditPageHandler.setSubjectListPage("<?php echo Yii::app()->createAbsoluteURL('admin/subjects'); ?>");
	responceHandler = EditPageHandler;
	$(document).ready(function(){
		responceHandler.init();
		responceHandler.fillForm(<?php echo $subjectData; ?>);
	});
</script>


<form class="form-horizontal" id = "subjectInfoForm">
	<div id = "subjectFormFields">
	</div>
	<div>
		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading">Валидаторы</div>
				<div class="panel-body">
					<div id = "validators"></div>
					<div id = "customValidators"></div>

					<button type="button" class="btn btn-primary btn-sm" onclick = "responceHandler.addValidatorField()">Добавить валидатор</button>
				</div>
		</div>
	</div>

	<div class="pull-right" style = "margin-bottom: 10px;">
		<button type="button" class="btn btn-success" onclick = "responceHandler.saveData()">Сохранить</button>
		<?php if($_GET['id'] != 'new') { ?> <button type="button" class="btn btn-danger" onclick = "responceHandler.showDeleteModal(<?php echo $_GET['id']; ?>)">Удалить</button> <?php } ?>
	</div>

</form>