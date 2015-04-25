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
                    minlength: 5
                },
                mail : {
                    required : true,
                    email : true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                passwordRepeat: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                first_name: {
                    required : true
                },
                second_name: {
                    required : true
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
            }

        });
    });
</script>

<form class="form-horizontal" action = "<?php echo Yii::app()->createAbsoluteUrl("user/register"); ?>" method = "post" id = "registerForm">
    <div class="form-group">
        <label for="login" class="col-sm-2 control-label">Логин</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id = "login" name="login" placeholder="Логин">

        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Пароль</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id = "password" name="password" placeholder="Пароль">
        </div>
    </div>
    <div class="form-group">
        <label for="passwordRepeat" class="col-sm-2 control-label">Повторите пароль</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="passwordRepeat" name="passwordRepeat" placeholder="Повторите пароль">
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Адрес E-Mail</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id = "email" name="mail" placeholder="E-Mail">
        </div>
    </div>
    <div class="form-group">
        <label for="second_name" class="col-sm-2 control-label">Фамилия</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id = "second_name" name="second_name" placeholder="Фамилия">
        </div>
    </div>
    <div class="form-group">
        <label for="first_name" class="col-sm-2 control-label">Имя</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id = "first_name" name="first_name" placeholder="Имя">
        </div>
    </div>
    <div class="form-group">
        <label for="group" class="col-sm-2 control-label">Группа</label>
        <div class="col-sm-10">
            <select class="form-control" id = "group" name="group" placeholder="Группа" class="required">
                <option value="0" selected>Группа</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="year" class="col-sm-2 control-label">Год поступления</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id = "year" name="acquisition_year" placeholder="Год поступления">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Sign in</button>
        </div>
    </div>
</form>
