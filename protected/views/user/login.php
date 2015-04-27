<script>
    $(document).ready(function(){
        AlertHandler.init();
        var errors = JSON.parse(<?php echo json_encode($errors);?>);
        if(errors.length)
            AlertHandler.showAlert(errors);
    });
</script>

    <form class="form-horizontal" name = "loginData" action = "<?php echo Yii::app()->createAbsoluteUrl("user/login"); ?>" method = "post">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Логин</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="login" name = "loginData[username]" placeholder="Login">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name = "loginData[password]" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id = "rememberMe" value="1" name = "loginData[rememberMe]"> Запомнить меня
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-info pull-right">Войти</button>
            </div>
        </div>
    </form>
