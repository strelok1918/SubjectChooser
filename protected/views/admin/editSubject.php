<?php if(!isset($_GET['id'])) $_GET['id'] = 'new'; ?>

<script>
	$(document).ready(function(){
		EditSubjectFormProcessor.init();
		EditSubjectFormProcessor.setSubjectId('<?php echo $_GET['id']; ?>');
		EditSubjectFormProcessor.setSubjectListPage("<?php echo Yii::app()->createAbsoluteURL('admin/subjects'); ?>");
		EditSubjectFormProcessor.fillData(<?php echo $subjectData; ?>);
        if(EditSubjectFormProcessor.getSubjectId() == 'new') {
            $('#owner').val(['<?php echo Yii::app()->user->id; ?>']);
        }

        $("#owner").select2();
	});
</script>

<form class="form-horizontal" id = "subjectInfoForm">
	<div id = "attributes"></div>
    <div class="form-group">
        <label for="owner" class="col-md-2 control-label">Владелец</label>
        <div class="col-md-10">
            <select class="form-control" id = "owner" multiple>
                <?php
                    foreach($userList as $user) {
                        if($user['role'] == 'Admin' || $user['role'] == 'Moderator')
                            echo "<option value = '" . $user['id'] . "'>" . $user['first_name']. " " . $user['second_name'] . "</option>";
                    }
                ?>
            </select>
        </div>
    </div>
	<div>
		<div class="panel panel-default">
			<div class="panel-heading">Валидаторы</div>
				<div class="panel-body">
					<div id = "validators"></div>
					<div id = "customValidators"></div>

					<button type="button" class="btn btn-primary btn-sm pull-right" onclick = "CustomValidatorProcessor.addField()">Добавить валидатор</button>
				</div>
		</div>
	</div>

	<div class="pull-right" style = "margin-bottom: 10px;">
		<button type="button" class="btn btn-success" onclick = "EditSubjectFormProcessor.saveForm()">Сохранить</button>
		<?php if($_GET['id'] != 'new') { ?> <button type="button" class="btn btn-danger" onclick = "EditSubjectFormProcessor.showDeleteModal()">Удалить</button> <?php } ?>
    </div>

</form>