<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>C4Yucatan - Iniciar Sesion</title>
	<?php
		View::addStyle('view/principal/css/login.css');
		View::addStyle('public/css/cssLib.css');
	?>
</head>
<body>
	<form method="POST" class="form-signin">
		<div class="form-container clear">
			<img class="sign-in-img" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png">
			<div class="form-title">Favor de Iniciar Sesion</div>
			<input type="text" name="username" class="form-input" placeholder="Nombre de usuario">
			<input type="password" name="password" class="form-input" placeholder="Contraseña">
			<div class="col-sm-12 text-center text-warning bold margin-form">
				<?php 
					if(isset($_SESSION["loginError"]))
					{
						echo $_SESSION["loginError"];
						unset($_SESSION["loginError"]);	
					}
				?>
			</div>
			<div class="col-sm-12 text-center margin-form">
				<button class="btn btn-main btn-lg" id="btnIniciar" name="btnIniciar">Iniciar Sesion</button>
			</div>
		</div>
	</form>
</body>
</html>
