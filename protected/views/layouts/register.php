<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl. '/plugins/jquery/jquery-1.11.2.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl. '/plugins/jquery-ui/jquery-ui.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl.'/plugins/bootstrap/js/bootstrap.min.js');
        $cs->registerScriptFile($baseUrl.'/plugins/underscore/underscore.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl.'/plugins/select2/js/select2.full.min.js');
        $cs->registerScriptFile($baseUrl. '/plugins/validation/jquery.validate.min.js');
        $cs->registerScriptFile($baseUrl. '/plugins/validation/localization/messages_ru.js');
        $cs->registerScriptFile($baseUrl.'/js/common/AlertHandler.js');

        $cs->registerCssFile($baseUrl.'/plugins/jquery-ui/jquery-ui.min.css');
        $cs->registerCssFile($baseUrl.'/plugins/jquery-ui/jquery-ui.theme.min.css');
        $cs->registerCssFile($baseUrl.'/plugins/bootstrap/css/bootstrap.min.css');
        $cs->registerCssFile($baseUrl. '/plugins/select2/css/select2.min.css');

//        $cs->registerCssFile($baseUrl. '/plugins/select2/css/select2.bootstrap.css');

        require_once(Yii::app()->baseUrl . '/templates/commonTemplate.php');
        ?>


        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
    <script>
        $(document).ready(function() {
            $('[href = "' + window.location.href + '"]').parent().addClass('active');
        });
    </script>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl("login"); ?>">Логин <span class="sr-only">(current)</span></a></li>
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl("register"); ?>">Регистрация</a></li>
<!--                <li><a href="--><?php //echo Yii::app()->createAbsoluteUrl("recovery"); ?><!--">Восстановление пароля</a></li>-->
            </ul>

        </div>
    </nav>
        <div id = "messageBox"> </div>
        <div class="panel panel-default col-md-10 col-md-offset-1">
            <div class="panel-body">
                <?php echo $content; ?>
            </div>
        </div>

    </body>
</html>