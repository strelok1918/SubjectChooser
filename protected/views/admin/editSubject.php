<?php if(!isset($_GET['id'])) $_GET['id'] = 'new'; ?>

<script>
	EditPageHandler.setSubjectListPage("<?php echo Yii::app()->createAbsoluteURL('admin/subjects'); ?>");
	responceHandler = EditPageHandler;
	$(document).ready(function(){
		responceHandler.fillForm(<?php echo $subjectData; ?>);
	});
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
			<button type="button" class="btn btn-success" onclick = "responceHandler.saveData('<?php echo $_GET['id']; ?>')">Сохранить</button>
			<?php if($_GET['id'] != 'new') { ?> <button type="button" class="btn btn-danger" onclick = "responceHandler.showDeleteModal(<?php echo $_GET['id']; ?>)">Удалить</button> <?php } ?>
		</div>
	</div>
</form>