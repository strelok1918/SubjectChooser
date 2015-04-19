<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
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

		$cs->registerScriptFile($baseUrl.'/js/common/AlertHandler.js');
		$cs->registerScriptFile($baseUrl.'/js/user/AjaxController.js');
		$cs->registerScriptFile($baseUrl.'/js/user/Choosehandler.js');
		$cs->registerScriptFile($baseUrl.'/js/user/ModalHandler.js');

		$cs->registerScriptFile($baseUrl.'/js/user/SubjectListPageProcessor.js');
        $cs->registerScriptFile($baseUrl.'/js/user/SubjectListFilter.js');

		require_once($baseUrl . '/templates/userTemplate.php');
		require_once($baseUrl . '/templates/commonTemplate.php');

	?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script>
		$(document).ready(function(){
			AlertHandler.init();
			$('[href = "' + window.location.href + '"]').parent().addClass('active');
		});
	</script>
</head>

<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<ul class="nav navbar-nav">
				<li><a href="<?php echo Yii::app()->createAbsoluteUrl("user/subjectList"); ?>">Список предметов <span class="sr-only">(current)</span></a></li>
				<li><a href="<?php echo Yii::app()->createAbsoluteUrl("user/mySubjects"); ?>">Мои предметы</a></li>
                <?php
                    if(Yii::app()->user->role == "Admin") {
                        echo "<li><a href='". Yii::app()->createAbsoluteUrl('admin/subjects')."'>Admin Panel</a></li>";
                    }

                ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?php echo Yii::app()->createAbsoluteUrl("user/editInfo"); ?>"><b><?php echo Yii::app()->user->first_name . " " . Yii::app()->user->second_name; ?> </b></a></li>
				<li><a href="<?php echo Yii::app()->createAbsoluteUrl("user/logout"); ?>">Выход</a></li>
			</ul>
		</div>
	</nav>

	<div class = "col-md-12">
		<div id = "messageBox"></div>
		<?php echo $content; ?>
	</div>
</body>
</html>
