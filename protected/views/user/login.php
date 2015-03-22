<html>
	<head>

		<link rel = "stylesheet" href = "/plugins/bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="/plugins/jquery/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="/plugins/underscore/underscore.js"></script>
		<script type="text/javascript" src="/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/common/AlertHandler.js"></script>
		<?php require_once(Yii::app()->baseUrl . '/templates/commonTemplate.php'); ?>
		<title>Login page</title>
		<script>
			$(document).ready(function(){
				AlertHandler.init();
				AlertHandler.showAlert(<?php echo $errors;?>);
			});
		</script>
	</head>
	<body>
		<div id = "messageBox"> </div>
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
						<button type="submit" class="btn btn-info">Войти</button>
					</div>
				</div>
			</form>
	</body>
</html>