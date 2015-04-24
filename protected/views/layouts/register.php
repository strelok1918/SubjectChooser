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
        $cs->registerScriptFile($baseUrl.'/plugins/select2/js/select2.min.js');

        $cs->registerCssFile($baseUrl.'/plugins/jquery-ui/jquery-ui.min.css');
        $cs->registerCssFile($baseUrl.'/plugins/jquery-ui/jquery-ui.theme.min.css');
        $cs->registerCssFile($baseUrl.'/plugins/bootstrap/css/bootstrap.min.css');
        $cs->registerCssFile($baseUrl. '/plugins/select2/css/select2.min.css');
        ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <?php echo $content; ?>
    </body>
</html>