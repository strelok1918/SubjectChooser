<script>
    $(document).ready(function() {
        var errors = <?php echo json_encode($errors);?>;
        var stage = <?php echo $step; ?>;
        if(stage == 2) {
            AlertHandler.init();
            AlertHandler.showAlert(errors, "Письмо отправлено на ваш E-Mail адрес.");
        }
    });
</script>
<?php $this->widget('application.extensions.email.debug'); ?>
<form class="form-horizontal" action = "<?php echo Yii::app()->createAbsoluteUrl('recovery'); ?>" method = "post" id = "recoveryForm">
    <div class="form-group">
        <label for="login" class="col-sm-2 control-label">Логин</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id = "login" name="login" placeholder="Username">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-info pull-right">Отправить</button>
        </div>
    </div>
</form>