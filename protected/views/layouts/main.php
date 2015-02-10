<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php
		$baseUrl = Yii::app()->baseUrl;
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl. '/plugins/jquery/jquery-1.11.2.min.js', CClientScript::POS_HEAD);
		$cs->registerScriptFile($baseUrl.'/plugins/bootstrap/js/bootstrap.min.js');
		$cs->registerScriptFile($baseUrl.'/js/SubjectProcessor.js');
		$cs->registerScriptFile($baseUrl.'/js/SubjectMenu.js');
		$cs->registerScriptFile($baseUrl.'/js/ResponceHandlerMenu.js');
		$cs->registerScriptFile($baseUrl.'/js/ResponceHandlerEditPage.js');
		$cs->registerScriptFile($baseUrl.'/plugins/underscore/underscore.js', CClientScript::POS_HEAD);

		$cs->registerCssFile($baseUrl.'/plugins/bootstrap/css/bootstrap.min.css');
		$cs->registerCssFile($baseUrl.'/css/subjectMenu.css');
		require_once($baseUrl . '/templates/subject.php');
	?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<script>
	var responceHandler;
	$(document).ready(function(){
		SubjectProcessor.init('<?php echo Yii::app()->createAbsoluteUrl("site/saveSubject"); ?>', '<?php echo Yii::app()->createAbsoluteUrl("site/deleteSubject"); ?>');
	});
</script>
<body>
	<div class = "row">
		<div class = "col-md-2">
			<div class="list-group">
				<a href="<?php echo Yii::app()->createAbsoluteUrl('site/subjects'); ?>" class="list-group-item list-group-item-info">Список дисциплин </a>
				<a href="#" class="list-group-item">Attribute editor </a>
			</div>
		</div>
		<div class = "col-md-9">
			<div id = "messageBox"></div>
			<?php echo $content; ?>
		</div>

	</div>
</body>
</html>
