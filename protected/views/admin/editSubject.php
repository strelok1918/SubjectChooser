<?php if(!isset($_GET['id'])) $_GET['id'] = 'new'; ?>

<script>
	$(document).ready(function(){
		EditSubjectFormProcessor.init();
		EditSubjectFormProcessor.setSubjectId('<?php echo $_GET['id']; ?>');
		EditSubjectFormProcessor.setSubjectListPage("<?php echo Yii::app()->createAbsoluteURL('admin/subjects'); ?>");
		EditSubjectFormProcessor.fillData(<?php echo $subjectData; ?>);
	});
</script>


<form class="form-horizontal" id = "subjectInfoForm">
	<div id = "attributes"></div>
	<div>
		<div class="panel panel-default">
			<div class="panel-heading">Валидаторы</div>
				<div class="panel-body">
					<div id = "validators"></div>
					<div id = "customValidators"></div>

					<button type="button" class="btn btn-primary btn-sm" onclick = "CustomValidatorProcessor.addField()">Добавить валидатор</button>
				</div>
		</div>
	</div>

	<div class="pull-right" style = "margin-bottom: 10px;">
		<button type="button" class="btn btn-success" onclick = "EditSubjectFormProcessor.saveForm()">Сохранить</button>
		<?php if($_GET['id'] != 'new') { ?> <button type="button" class="btn btn-danger" onclick = "EditSubjectFormProcessor.showDeleteModal()">Удалить</button> <?php } ?>
	</div>

</form>