<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php
		$baseUrl = Yii::app()->baseUrl;
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl. '/plugins/jquery/jquery-1.11.2.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile($baseUrl. '/plugins/jquery-ui/jquery-ui.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile($baseUrl.'/plugins/bootstrap/js/bootstrap.min.js');
		$cs->registerScriptFile($baseUrl.'/plugins/select2/js/select2.min.js');

		$cs->registerScriptFile($baseUrl.'/js/common/AlertHandler.js');
		$cs->registerScriptFile($baseUrl.'/js/admin/AjaxController.js');
		$cs->registerScriptFile($baseUrl.'/js/admin/AttributeProcessor.js');
		$cs->registerScriptFile($baseUrl.'/js/admin/CustomValidatorProcessor.js');
		$cs->registerScriptFile($baseUrl.'/js/admin/ValidatorProcessor.js');
		$cs->registerScriptFile($baseUrl.'/js/admin/SubjectStatistics.js');
		$cs->registerScriptFile($baseUrl.'/js/admin/EditSubjectFormProcessor.js');
		$cs->registerScriptFile($baseUrl.'/js/admin/SubjectMenuPageProcessor.js');

		$cs->registerScriptFile($baseUrl.'/plugins/underscore/underscore.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile($baseUrl.'/plugins/jtable/jquery.jtable.js');
		$cs->registerScriptFile($baseUrl.'/plugins/jtable/localization/jquery.jtable.ru.js');

		$cs->registerCssFile($baseUrl.'/plugins/jtable/themes/lightcolor/blue/jtable.css');
		$cs->registerCssFile($baseUrl.'/plugins/jquery-ui/jquery-ui.min.css');
		$cs->registerCssFile($baseUrl.'/plugins/jquery-ui/jquery-ui.theme.min.css');
		$cs->registerCssFile($baseUrl. '/plugins/bootstrap/css/bootstrap.min.css');
		$cs->registerCssFile($baseUrl. '/plugins/select2/css/select2.min.css');

		$cs->registerCssFile($baseUrl.'/css/subjectMenu.css');
		require_once($baseUrl . '/templates/adminTemplate.php');
		require_once($baseUrl . '/templates/commonTemplate.php');
	?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<script>
	var DeleteHandler;
	$(document).ready(function(){
		SubjectMenuPageProcessor.init();
		AlertHandler.init();
		AjaxController.init('<?php echo Yii::app()->createAbsoluteUrl("admin/saveSubject"); ?>', '<?php echo Yii::app()->createAbsoluteUrl("admin/deleteSubject"); ?>');
		$('[href = "' + window.location.href + '"]').addClass('list-group-item-info');

		if(<?php echo (int)(!isset($_GET['id'])); ?>) {
			DeleteHandler = SubjectMenuPageProcessor;
		} else {
			DeleteHandler = EditSubjectFormProcessor;
		}
	});
</script>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl("user/subjectList"); ?>">Список предметов <span class="sr-only">(current)</span></a></li>
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl("user/mySubjects"); ?>">Мои предметы</a></li>
                <li class = "active"><a href="<?php echo Yii::app()->createAbsoluteUrl("admin/subjects"); ?>" >Admin Panel</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl("user/editInfo"); ?>"><b><?php echo Yii::app()->user->first_name . " " . Yii::app()->user->second_name; ?> </b></a></li>
                <li><a href="<?php echo Yii::app()->createAbsoluteUrl("user/logout"); ?>">Выход</a></li>
            </ul>
        </div>
    </nav>
	<div class = "row" style = "margin-right:0px !important;">
		<div class = "col-md-2" style = "margin-left:5px; margin-right:-5px;">
			<div class="list-group">
				<a href="<?php echo Yii::app()->createAbsoluteUrl('admin/subjects'); ?>" class="list-group-item">Редактор дисциплин </a>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('admin/attributes'); ?>" class="list-group-item">Редактор атрибутов</a>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('admin/validators'); ?>" class="list-group-item">Редактор валидаторов</a>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('admin/users'); ?>" class="list-group-item">Редактор пользователей</a>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('admin/groups'); ?>" class="list-group-item">Редактор групп</a>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('admin/stat'); ?>" class="list-group-item">Статистика</a>
			</div>
		</div>
		<div class = "col-md-10">
			<div id = "messageBox"></div>
			<?php echo $content; ?>
		</div>

	</div>
</body>
</html>
