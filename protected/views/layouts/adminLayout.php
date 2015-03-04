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
		$cs->registerScriptFile($baseUrl.'/js/SubjectProcessor.js');
		$cs->registerScriptFile($baseUrl.'/js/SubjectMenu.js');
		$cs->registerScriptFile($baseUrl.'/js/MenuHandler.js');
		$cs->registerScriptFile($baseUrl.'/js/EditPageHandler.js');
		$cs->registerScriptFile($baseUrl.'/plugins/underscore/underscore.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile($baseUrl.'/plugins/jtable/jquery.jtable.js');
		$cs->registerScriptFile($baseUrl.'/plugins/jtable/localization/jquery.jtable.ru.js');

		$cs->registerCssFile($baseUrl.'/plugins/jtable/themes/jqueryui/jtable_jqueryui.css');
		$cs->registerCssFile($baseUrl.'/plugins/jquery-ui/jquery-ui.min.css');
		$cs->registerCssFile($baseUrl.'/plugins/jquery-ui/jquery-ui.theme.min.css');
		$cs->registerCssFile($baseUrl. '/plugins/bootstrap/css/bootstrap.min.css');
//		$cs->registerCssFile('http://bootswatch.com/cerulean/bootstrap.min.css');
		$cs->registerCssFile($baseUrl.'/css/subjectMenu.css');
		require_once($baseUrl . '/templates/adminTemplate.php');
	?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<script>
	var responceHandler;
	$(document).ready(function(){
		SubjectProcessor.init('<?php echo Yii::app()->createAbsoluteUrl("admin/saveSubject"); ?>', '<?php echo Yii::app()->createAbsoluteUrl("admin/deleteSubject"); ?>');
		$('[href = "' + window.location.href + '"]').addClass('list-group-item-info');
	});
</script>
<body>
	<nav class="navbar navbar-default" style="border-radius: 0 !important;margin-bottom:5px;">
		<div class="container-fluid">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><b>Marchenko Igor</b></a></li>
				<li><a href="#">Logout</a></li>
			</ul>
		</div>
	</nav>
	<div class = "row" style = "margin-right:0px !important;">
		<div class = "col-md-2" style = "margin-left:5px; margin-right:-5px;">
			<div class="list-group">
				<a href="<?php echo Yii::app()->createAbsoluteUrl('admin/subjects'); ?>" class="list-group-item">Редактор дисциплин </a>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('admin/attributes'); ?>" class="list-group-item">Редактор атрибутов</a>
				<a href="<?php echo Yii::app()->createAbsoluteUrl('admin/validators'); ?>" class="list-group-item">Редактор валидаторов</a>
			</div>
		</div>
		<div class = "col-md-10">
			<div id = "messageBox"></div>
			<?php echo $content; ?>
		</div>

	</div>
</body>
</html>
