<script>
	$(document).ready(function() {
        var userData = <?php echo json_encode($info); ?>;

        $('#second_name').val(userData.second_name);
        $('#first_name').val(userData.first_name);
        $('#group').val(userData.group);
        $('#mail').val(userData.mail);
        $('#group').select2({});

        $('#userForm').validate({
            rules: {
                mail: {
                    required: true,
                    email: true,
                    remote: "<?php echo Yii::app()->createAbsoluteUrl('user/checkMail'); ?>",
                },
                first_name: {
                    required: true,
                    maxlength: 50
                },
                second_name: {
                    required: true,
                    maxlength: 50
                },

                new_password: {
                    minlength: 5,
                    maxlength : 20
                },
                new_password_repeat: {
                    minlength: 5,
                    maxlength : 20,
                    equalTo: "#new_password"
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error');
                $(element).closest('.form-group').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            messages: {
                mail: {
                    remote: "Почтовый адрес уже используется."
                }
            }
        });
    });
	function collectData() {
		var result =  {
			'first_name' : $('#first_name').val(),
			'second_name' : $('#second_name').val(),
			'group' : $('#group').val(),
			'mail' : $('#mail').val(),
		};
        if($('#new_password').val().length) {
            result['password'] = $('#new_password').val();
        }
        return result;
	}
	function submitUserInfoForm() {
        if(!$('#userForm').valid()) return false;
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
<style>
    .form-control::-webkit-input-placeholder { font-size: 14px; }
    .form-control:-moz-placeholder { font-size: 14px; }
    .form-control::-moz-placeholder { font-size: 14px; }
    .form-control:-ms-input-placeholder { font-size: 14px; }
</style>
<form class="form-horizontal" id = "userForm" method = "post">
    <div class="panel panel-default">

            <ul class="list-group">
                <li class="list-group-item">

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Фамилия</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control input-sm" id="second_name" name = "second_name" placeholder="Фамилия">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Имя</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control input-sm" id="first_name" name = "first_name" placeholder="Имя">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">E-Mail</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control input-sm" id="mail" name = "mail" placeholder="E-Mail">
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
                </li>
                <li class="list-group-item">

<!--                    <div class="form-group">-->
<!--                        <label for="inputPassword3" class="col-sm-2 control-label">Старый пароль</label>-->
<!--                        <div class="col-sm-10">-->
<!--                            <input type="text" class="form-control" id="old_password" placeholder="Пароль">-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control input-sm" id="new_password" name = "new_password" placeholder="Пароль">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Повторите пароль</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control input-sm" id="new_password_repeat" name ="new_password_repeat" placeholder="Пароль">
                        </div>
                    </div
                </li>

    </div>
    <button type="button" class="btn btn-success pull-right" onclick = "submitUserInfoForm()">Сохранить</button>
</form>