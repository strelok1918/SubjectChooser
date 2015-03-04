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
		$cs->registerScriptFile($baseUrl.'/plugins/underscore/underscore.js', CClientScript::POS_HEAD);

		$cs->registerCssFile($baseUrl.'/plugins/jquery-ui/jquery-ui.min.css');
		$cs->registerCssFile($baseUrl.'/plugins/jquery-ui/jquery-ui.theme.min.css');
		$cs->registerCssFile($baseUrl.'/plugins/bootstrap/css/bootstrap.min.css');
		require_once($baseUrl . '/templates/userTemplate.php');
	?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><b>Marchenko Igor</b></a></li>
				<li><a href="#">Logout</a></li>
			</ul>
		</div>
	</nav>

	<div class = "col-md-12">
		<?php echo $content; ?>
	</div>
</body>
</html>
