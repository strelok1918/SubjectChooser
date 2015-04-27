<?php
    if(isset($errors) && !empty($errors)) {
        print_r($errors);
    }

?>
<script>
    $(document).ready(function(){
        var groupData = <?php echo json_encode($groups); ?>;
        var data = [];
        for(var key in groupData) {
            data.push({
                'id' : groupData[key].id,
                'text' : groupData[key].title
            });
        }
        $('#group').select2({
            data : data,
            placeholder: "Группа"
        });
        $('#group').val(null);
        $('#registerForm').validate({
            rules : {
                login: {
                    required : true,
                    maxlength : 20,
                    minlength: 5,
                    remote : "<?php echo Yii::app()->createAbsoluteUrl('user/checkUser'); ?>",
//                    message : "Логин уже используется."
                },
                mail : {
                    required : true,
                    email : true,
                    remote : "<?php echo Yii::app()->createAbsoluteUrl('user/checkMail'); ?>",
                },
                password: {
                    required: true,
                    minlength: 5,
                    maxlength : 20
                },
                passwordRepeat: {
                    required: true,
                    minlength: 5,
                    maxlength : 20,
                    equalTo: "#password"
                },
                first_name: {
                    required : true,
                    maxlength : 50
                },
                second_name: {
                    required : true,
                    maxlength : 50
                },
                group : {
                    required : true,
                    min : 1
                },
                acquisition_year : {
                    required: true,
                    number: true,
                    range : [2000, <?php echo date("Y"); ?> ]
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
                $(element).closest('.form-group').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            messages : {
                login : {
                    remote : "Логин уже используется."
                },
                mail: {
                    remote : "Почтовый адрес уже используется."
                }
            }

        });
        var userData = <?php  echo json_encode($userData); ?>;

        if(!jQuery.isEmptyObject(userData)) {

            fillForm(userData);
            var errors = JSON.parse("<?php echo json_encode($errors);?>");
            AlertHandler.init();
            AlertHandler.showAlert(errors, "Пользователь успешно зарегистрирован.");
        }



    });
    function fillForm(data) {
        $('#login').val(data.login);
        $('#email').val(data.mail);
        $('#second_name').val(data.second_name);
        $('#first_name').val(data.first_name);
        $('#group').val(data.group);
        $('#year').val(data.acquisition_year);
    }

</script>
<style>
    .form-control::-webkit-input-placeholder { font-size: 14px; }
    .form-control:-moz-placeholder { font-size: 14px; }
    .form-control::-moz-placeholder { font-size: 14px; }
    .form-control:-ms-input-placeholder { font-size: 14px; }
</style>

<form class="form-horizontal" action = "<?php echo Yii::app()->createAbsoluteUrl("user/register"); ?>" method = "post" id = "registerForm">
    <div class="form-group">
        <label for="login" class="col-sm-2 control-label">Логин</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id = "login" name="login" placeholder="Логин">

        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Пароль</label>
        <div class="col-sm-10">
            <input type="password" class="form-control input-sm" id = "password" name="password" placeholder="Пароль">
        </div>
    </div>
    <div class="form-group">
        <label for="passwordRepeat" class="col-sm-2 control-label">Повторите пароль</label>
        <div class="col-sm-10">
            <input type="password" class="form-control input-sm" id="passwordRepeat" name="passwordRepeat" placeholder="Повторите пароль">
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Адрес E-Mail</label>
        <div class="col-sm-10">
            <input type="email" class="form-control input-sm" id = "email" name="mail" placeholder="E-Mail">
        </div>
    </div>
    <div class="form-group">
        <label for="second_name" class="col-sm-2 control-label">Фамилия</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id = "second_name" name="second_name" placeholder="Фамилия">
        </div>
    </div>
    <div class="form-group">
        <label for="first_name" class="col-sm-2 control-label">Имя</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id = "first_name" name="first_name" placeholder="Имя">
        </div>
    </div>
    <div class="form-group">
        <label for="group" class="col-sm-2 control-label">Группа</label>
        <div class="col-sm-10">
            <select class="form-control input-sm" id = "group" name="group" placeholder="Группа" class="required">
                <option></option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="year" class="col-sm-2 control-label">Год поступления</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id = "year" name="acquisition_year" placeholder="Год поступления">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-info pull-right">Регистрация</button>
        </div>
    </div>
</form>
