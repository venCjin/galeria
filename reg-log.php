<div class="reg-log">
	<div id="reg">

		<h2>Rejestracja</h2>

		<form method="post" action="index.php?strona=rejestracja">
			<div class="input-group margin-bottom-sm">
				<span class="input-group-addon"><i class="fa fa-user fa-fw" aria-hidden="true"></i></span>
				<input class="form-control" minlength="6" maxlength="20" type="text" name="login" value="<?php echo @$_GET["userLogin"];?>" placeholder="Login" required>
			</div>
		
			<div class="input-group margin-bottom-sm">
				<span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden="true"></i></span>
				<input class="form-control" minlength="6" maxlength="20" type="password" name="password" placeholder="Hasło" required>
			</div>

			<div class="input-group margin-bottom-sm">
				<span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden="true"></i></span>
				<input class="form-control" minlength="6" maxlength="20" type="password" name="password_v" placeholder="Hasło (ponownie)" required>
			</div>
		
			<div class="input-group margin-bottom-sm">
	  			<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i></span>
				<input class="form-control" maxlength="128" type="email" name="email" value="<?php echo @$_GET["userEmail"];?>" placeholder="Email" required>
			</div>
			<input type="submit" value="Zarejestruj">
		</form>

		<?php
			if (isset($_SESSION["errors"]))
			{
				foreach ($_SESSION["errors"] as $error)
				{
					echo '<p class="error"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> ' . $error . '</p>';
				}
				session_destroy();
				session_start();
			}
		?>

	</div>

	<div id="log">

		<h2>Logowanie</h2>

		<form method="post" action="index.php">
			<div class="input-group margin-bottom-sm">
				<span class="input-group-addon"><i class="fa fa-user fa-fw" aria-hidden="true"></i></span>
				<input class="form-control" type="text" name="L_login" placeholder="Login" required>
			</div>
		
			<div class="input-group margin-bottom-sm">
				<span class="input-group-addon"><i class="fa fa-key fa-fw" aria-hidden="true"></i></span>
				<input class="form-control" type="password" name="L_password" placeholder="Hasło" required>
			</div>
		
			<input type="submit" value="Zaloguj">
		</form>

		<?php
			$login = $db->real_escape_string(htmlspecialchars(strip_tags(trim(@$_POST['L_login']))));
			$password = @$_POST['L_password'];
			$password = md5($password);
			$auth = $db->query("SELECT * 
								FROM uzytkownicy 
								WHERE BINARY login = '$login' 
								AND haslo = '$password'")->fetch_assoc();

			if ($_POST)
			{
				if (isset($auth))
				{
					if ($auth['aktywny'] == 1)
					{
						$_SESSION["userData"] = $auth;
						header("Location: index.php?strona=galeria");
						exit;
					}
					else
					{	
						echo '<p class="error"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i>Konto podanego użytkownika zostało zablokowane</p>';	
					}
				}
				else
				{	
					echo '<p class="error"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i>Niepoprawne dane</p>';
				}
			}
		?>

	</div>
</div>