<script>
	$(document).ready(function(){
		var userData = <?php echo json_encode($info); ?>;

		$('#second_name').val(userData.second_name);
		$('#first_name').val(userData.first_name);
		$('#group').val(userData.group);
		$('#acquisition_year').val(userData.acquisition_year);
		$('#mail').val(userData.mail);
	});
	function collectData() {
		return  {
			'first_name' : $('#first_name').val(),
			'second_name' : $('#second_name').val(),
			'acquisition_year' : $('#acquisition_year').val(),
			'group' : $('#group').val(),
			'mail' : $('#mail').val(),
		};
	}
	function submitUserInfoForm() {
		$.ajax({
			url : '<?php echo Yii::app()->createAbsoluteUrl("user/saveUserData"); ?>',
			type : 'POST',
			data : {data : collectData()}
		}).done(function(responce){
			var data = JSON.parse(responce);
			AlertHandler.showAlert(data.erorrs, "Изменения сохранены");
		});
	}
</script>

<form class="form-horizontal">
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">Фамилия</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="second_name" name = "info[second_name]" placeholder="Фамилия">
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">Имя</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="first_name" name = "info[first_name]" placeholder="Имя">
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">E-Mail</label>
		<div class="col-sm-10">
			<input type="email" class="form-control" id="mail" name = "info[mail]" placeholder="E-Mail">
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">Группа</label>
		<div class="col-sm-10">
			<select class="form-control" id = "group">
				<?php
					foreach($groupList as $group) {
						$selected = ($group['id'] == $info['group'])? "selected" : "";
						echo "<option value = '" .$group['id'] ."' " . $selected." >" .$group['title'] . "</option>";
					}
				?>
			</select>
<!--			<input type="text" class="form-control" id="group" name = "info[group]" placeholder="Группа">-->
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">Год поступления</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="acquisition_year" name = "info[year]" placeholder="Год поступления">
		</div>
	</div>

	<!--<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">Старый пароль</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="old_password" placeholder="Пароль">
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="new_password" placeholder="Пароль">
		</div>
	</div>
	<div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">Повторите пароль</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="new_password_repeat" placeholder="Пароль">
		</div>
	</div>-->
	<button type="button" class="btn btn-success pull-right" onclick = "submitUserInfoForm()">Сохранить</button>
</form>