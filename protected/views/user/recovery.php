<form class="form-horizontal" action = "<?php echo Yii::app()->createAbsoluteUrl('recovery'); ?>" >
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Адрес E-Mail</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id = "email" name="mail" placeholder="E-Mail">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-info pull-right">Отправить</button>
        </div>
    </div>
</form>