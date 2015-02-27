<?php if(!isset($_GET['id'])) $_GET['id'] = 'new'; ?>

<script>
	var currentSubjectId = '<?php echo $_GET['id']; ?>';
	EditPageHandler.setSubjectListPage("<?php echo Yii::app()->createAbsoluteURL('admin/subjects'); ?>");
	responceHandler = EditPageHandler;
	$(document).ready(function(){
		responceHandler.fillForm(<?php echo $subjectData; ?>);
	});
</script>


<form class="form-horizontal" id = "subjectInfoForm">
	<div id = "subjectFormFields">
	</div>
	<div class="form-group">
		<div class="pull-right" style = "margin-right: 15px;">
			<button type="button" class="btn btn-success" onclick = "responceHandler.saveData()">Сохранить</button>
			<?php if($_GET['id'] != 'new') { ?> <button type="button" class="btn btn-danger" onclick = "responceHandler.showDeleteModal(<?php echo $_GET['id']; ?>)">Удалить</button> <?php } ?>
		</div>
	</div>
</form>