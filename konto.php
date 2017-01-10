<nav class="subNav">
	<a id="navMd" class='button' onclick="f(1)">
	<i class='fa fa-user'></i>	Moje dane
	</a>

	<a id="navMa" class='button' onclick="f(2)">
	<i class='fa fa-folder'></i>	Moje albumy
	</a>

	<a id="navMz" class='button' onclick="f(3)">
	<i class='fa fa-file-image-o'></i>	Moje zdjęcia
	</a>

	<div style="clear: both;"></div>
</nav>

<article id="mDane">
	
	<?php
		$id_u = $_SESSION["userData"]["id"];

		if (isset($_POST['zm_d']))
		{
			if (strlen($_POST['password'])>0)
			{
				$current_pwd = $db->query("SELECT haslo FROM uzytkownicy WHERE id='$id_u'")->fetch_row;
				if($_POST['current_password'] != $current_pwd[0])
				{
					$errors[] = 'Aktualne hasło niepoprawne';
				}

				$password = $_POST['password'];
				$password_v = $_POST['password_v'];

				if (!preg_match('/[a-z]/', $password))
				{
					$errors[] = 'Podane hasło nie zawiera przynajmniej jednej małej litery';
				}

				if (!preg_match('/[A-Z]/', $password))
				{
					$errors[] = 'Podane hasło nie zawiera przynajmniej jednej wielkiej litery';
				}

				if (!preg_match('/[0-9]/', $password))
				{
					$errors[] = 'Podane hasło nie zawiera przynajmniej jednej cyfry';
				}

				if ((strlen($password) < 6) OR (strlen($password) > 20))
				{
					$errors[] = 'Hasło  ma mieć długość 6-20 znaków';
				}
				
				if ($password !== $password_v)
				{
					$errors[] = 'Podane hasła nie są indentyczne';
				}

				if (!empty($errors))
				{				
					foreach ($errors as $error)
					{
						echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> ' . $error . '</p>';
					}
					unset($errors);
				}			
				else
				{
					$password = md5($password);

					$result = $db->query("UPDATE uzytkownicy 
											SET haslo='$password' 
											WHERE id='$id_u'");
					if (!$result)
					{
						echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Zmiana hasła nie powiodła się. Spróbuj ponownie.</p>';
					}
					else
					{
						echo '<p class="success">Hasło zostało zmienione</p>';
					}
				}
			}
			elseif (strlen($_POST['email'])>0)
			{
				$email = $db->real_escape_string(htmlspecialchars(trim(strip_tags($_POST['email']))));
				$email = filter_var($email, FILTER_SANITIZE_EMAIL);

				if (!filter_var($email, FILTER_VALIDATE_EMAIL))
					{
						$errors[] = 'Podany adres e-mail jest niepoprawny';
					}

				if (!empty($errors))
				{				
					foreach ($errors as $error)
					{
						echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> ' . $error . '</p>';
					}
					unset($errors);
				}			
				else
				{
					$result = $db->query("UPDATE uzytkownicy 
											SET email='$email' 
											WHERE id='$id_u'");
					if (!$result)
					{
						echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Zmiana emailu nie powiodła się. Spróbuj ponownie.</p>';
					}
					else
					{
						echo '<p class="success">Email został zmieniony</p>';
					}
				}
			}
			else
			{
				echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i>	Nie podałeś ani hasła ani emailu!</p>';
			}

		}
	?>

	<form method="post" action="index.php?strona=konto">

		<div class="input-group margin-bottom-sm">
			<span class="input-group-addon">
				<i class="fa fa-key fa-fw" aria-hidden="true"></i>
			</span>
			<input class="form-control" minlength="6" maxlength="20" type="password" name="current_password" placeholder="Aktualne hasło">
		</div>
		
		<div class="input-group margin-bottom-sm">
			<span class="input-group-addon">
				<i class="fa fa-key fa-fw" aria-hidden="true"></i>
			</span>
			<input class="form-control" minlength="6" maxlength="20" type="password" name="password" placeholder="Nowe hasło">
		</div>
		
		<div class="input-group margin-bottom-sm">
			<span class="input-group-addon">
				<i class="fa fa-key fa-fw" aria-hidden="true"></i>
			</span>
			<input class="form-control" minlength="6" maxlength="20" type="password" name="password_v" placeholder="Nowe hasło (ponownie)">
		</div>

		<div class="input-group margin-bottom-sm">
			<span class="input-group-addon">
				<i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i>
			</span>
			<input class="form-control" maxlength="128" type="email" name="email" placeholder="Nowy email">
		</div>

		<input type="submit" name="zm_d" value="Zmień">

	</form>

</article>

<article id="mAlbum">
	<?php
		if (isset($_POST['zm_a']))
		{
			if ($_POST['id_albumu']>0)
			{
				$tytul_a = $_POST['tytul_a'];
				$result = $db->query("UPDATE albumy 
										SET tytul='$tytul_a' 
										WHERE id=".$_POST['id_albumu']);
	
				if (!$result)
				{
					echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Zmiana nazwy albumu nie powiodła się. Spróbuj ponownie.</p>';
				}
				else
				{
					echo '<p class="success">Nazwa albumu została zmieniona</p>';
				}
			}
			else
			{
				echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Nie wybrano albumu</p>';
			}
		}
		if (isset($_POST['usn_a']))
		{
			if ($_POST['id_albumu']>0)
			{
				$result = $db->query("DELETE FROM zadjecia 
											WHERE id_albumu=".$_POST['id_albumu']);
				
				if ($result)
				{
					$result = $db->query("DELETE FROM albumy 
												WHERE id=".$_POST['id_albumu']);
		
					if ($result)
					{
						$path = "img/".$_POST['id_albumu'];
						if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
						{
						    exec(sprintf("rd /s /q %s", escapeshellarg($path)));
						}
						else
						{
						    exec(sprintf("rm -rf %s", escapeshellarg($path)));
						}
						echo '<p class="success">Album został usunięty</p>';
					}
					else
					{
						echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Usunięcie albumu nie powiodło się. Spróbuj ponownie.</p>';
					}
				}
				else
				{
					echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Usunięcie zdjęć z albumu nie powiodło się. Spróbuj ponownie.</p>';
				}
			}
			else
			{
				echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Nie wybrano albumu</p>';
			}
		}
	?>

	<form method="post" action="index.php?strona=konto">
		<div class="input-group margin-bottom-sm">
			<select class="form-control folder" name="id_albumu" onchange="ajax_a(this.value)">
				<option selected='true' disabled='disabled'>---Wybierz album---</option>
				<?php
					$result = $db->query ("SELECT  *
											FROM albumy
											WHERE id_uzytkownika='$id_u'
											ORDER BY id");
					
					while($row = $result->fetch_assoc())
					{
						echo "<option value='".$row["id"]."'>".$row["tytul"]."</option>";
					}
				?>
			</select>
		</div>

		<div class="input-group margin-bottom-sm">
			<span class="input-group-addon">
				<i class="fa fa-folder fa-fw" aria-hidden="true"></i>
			</span>
			<input class="form-control" maxlength="100" type="text" name="tytul_a" placeholder="Nowa nazwa albumu">
		</div>

		<input type="submit" name="zm_a" value="Zmień">
		<input type="submit" name="usn_a" value="Usuń" onclick="return confirm('Czy na pewno chcesz usunąć ten album? \nWraz z nim zostaną usunięte wszystkie zdjęcia, które zawiera.');">

	</form>

	<script>
	function ajax_a(id)
	{
		$.ajax
		({
			url: 'ajax_album.php',
			data: {id_albumu: id},
			success: function(h)
			{
				$("#album").html(h)
			}
		})
	}
	</script>
	
	<div id="album" style="position:relative;"></div>

</article>

<article id="mZdjecia">
	<?php
		if (isset($_POST['zm_z']))
		{
			if ($_POST['id_zdjecia']>0)
			{
				$tytul_z = $_POST['tytul_z'];
				$result = $db->query("UPDATE zadjecia 
										SET tytul='$tytul_z' 
										WHERE id=".$_POST['id_zdjecia']);
	
				if (!$result)
				{
					echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Zmiana opisu zdjęcia nie powiodła się. Spróbuj ponownie.</p>';
				}
				else
				{
					echo '<p class="success">Opis zdjęcia został zmieniony</p>';
				}
			}
			else
			{
				echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Nie wybrano zdjęcia</p>';
			}
		}
		if (isset($_POST['usn_z']))
		{
			if ($_POST['id_zdjecia']>0)
			{
				$row = $db->query("SELECT id_albumu
										FROM zadjecia
										WHERE id=".$_POST['id_zdjecia'])->fetch_assoc();
				
				$result = $db->query("DELETE FROM zadjecia 
											WHERE id=".$_POST['id_zdjecia']);
	
				if (!$result)
				{
					echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Usunięcie zdjęcia nie powiodło się. Spróbuj ponownie.</p>';
				}
				else
				{
					unlink("img/".$row['id_albumu']."/".$_POST['id_zdjecia']);
					echo '<p class="success">Zdjęcie zostało usunięte</p>';
				}
			}
			else
			{
				echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Nie wybrano zdjęcia</p>';
			}
		}
	?>
	
	<form method="post" action="index.php?strona=konto">
		<div class="input-group margin-bottom-sm">
			<select class="form-control folder" name="id_zdjecia" onchange="ajax_z(this.value)">
				<option selected='true' disabled='disabled'>---Wybierz zdjęcie---</option>
				<?php
					$result = $db->query ("SELECT *
											FROM zadjecia
											WHERE id_uzytkownika='$id_u'
											ORDER BY id");
	
					while($row = $result->fetch_assoc())
					{
						echo "<option value='".$row["id"]."'>".$row["tytul"]."</option>";
					}
				?>
			</select>
		</div>

		<div class="input-group margin-bottom-sm">
			<span class="input-group-addon">
				<i class="fa fa-font fa-fw" aria-hidden="true"></i>
			</span>
			<input class="form-control" maxlength="255" type="text" name="tytul_z" placeholder="Nowy opis zdjecia">
		</div>

		<input type="submit" name="zm_z" value="Zmień">
		<input type="submit" name="usn_z" value="Usuń" onclick="return confirm('Czy na pewno chcesz usunąć to zdjęcie?');">

	</form>

	<script>
	function ajax_z(id)
	{
		$.ajax
		({
			url: 'ajax_zdjecie.php',
			data: {id_zdjecia: id},
			success: function(i)
			{
				$("#zdjecie").html(i)
			}
		})
	}
	</script>
	
	<div id="zdjecie"></div>

</article>

<script type="text/javascript">
	$("#mDane").css("display","none");
	$("#mAlbum").css("display","none");
	$("#mZdjecia").css("display","none");

	<?php
		if (isset($_POST['zm_d']))
		{
			echo '$("#navMd").addClass("green");';
			echo '$("#mDane").css("display","block");';
		}
		
		if ((isset($_POST['zm_a'])) || (isset($_POST['usn_a'])))
		{
			echo '$("#navMa").addClass("green");';
			echo '$("#mAlbum").css("display","block");';
		}
		
		if ((isset($_POST['zm_z'])) || (isset($_POST['usn_z'])))
		{
			echo '$("#navMz").addClass("green");';
			echo '$("#mZdjecia").css("display","block");';
		}

	?>

	function f(n) 
	{
		if (n==1)
		{
			$("#navMd").addClass("green");
			$("#mDane").css("display","block");
		}
		else
		{
			$("#navMd").removeClass("green");
			$("#mDane").css("display","none");
		}
		
		if (n==2)
		{
			$("#navMa").addClass("green");
			$("#mAlbum").css("display","block");
		}
		else
		{
			$("#navMa").removeClass("green");
			$("#mAlbum").css("display","none");
		}
		
		if (n==3)
		{
			$("#navMz").addClass("green");
			$("#mZdjecia").css("display","block");
		}
		else
		{
			$("#navMz").removeClass("green");
			$("#mZdjecia").css("display","none");
		}
	}
</script>