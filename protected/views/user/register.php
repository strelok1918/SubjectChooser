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
        $('#groups').select2({
            data : data,
            placeholder: "Группа"
        });
        $('#groups').val(null);
    });
</script>
<form class="form-horizontal" action = "<?php echo Yii::app()->createAbsoluteUrl("user/register"); ?>" method = "post">
    <div class="form-group">
        <label for="login" class="col-sm-2 control-label">Логин</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id = "login" name="info[login]" placeholder="Логин">
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Пароль</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id = "password" name="info[password]" placeholder="Пароль">
        </div>
    </div>
    <div class="form-group">
        <label for="passwordRepeat" class="col-sm-2 control-label">Повторите пароль</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="passwordRepeat" placeholder="Повторите пароль">
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Адрес E-Mail</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id = "email" name="info[mail]" placeholder="E-Mail">
        </div>
    </div>
    <div class="form-group">
        <label for="second_name" class="col-sm-2 control-label">Фамилия</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id = "second_name" name="info[second_name]" placeholder="Фамилия">
        </div>
    </div>
    <div class="form-group">
        <label for="first_name" class="col-sm-2 control-label">Имя</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id = "first_name" name="info[first_name]" placeholder="Имя">
        </div>
    </div>
    <div class="form-group">
        <label for="group" class="col-sm-2 control-label">Группа</label>
        <div class="col-sm-10">
            <select class="form-control" id = "groups" name="info[group]" placeholder="Группа"></select>
        </div>
    </div>
    <div class="form-group">
        <label for="year" class="col-sm-2 control-label">Год поступления</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id = "year" name="info[acquisition_year]" placeholder="Год поступления">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Sign in</button>
        </div>
    </div>
</form>
