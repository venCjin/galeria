<!DOCTYPE html>
<html>

	<head>
		<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon"/>
		<link rel="icon" href="../img/favicon.ico" type="image/x-icon"/>
		<title>GALERIA - Suchiński</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
		<link rel="stylesheet" type="text/css" href="../css/jbootstrap.css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
		<!--[if lt IE 9]>
			<script src="../js/html5shiv.js"></script>
			<script src="../js/respond.min.js"></script>
		<![endif]-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik&amp;subset=latin-ext"/>
		<script src="../js/jquery-3.1.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/style.css"/>
	</head>

<body>

	<?php
		require '/xampp/htdocs/Suchinski/conn.php';
		
		if (isset($_SESSION["userData"]["login"]))
		echo '<header>Witaj, <b>'.$_SESSION["userData"]["login"].'</b>!</header>';
		
		if ((@$_SESSION["userData"]["uprawnienia"]!=='administrator') && (@$_SESSION["userData"]["uprawnienia"]!=='moderator'))
		{	header("Location: ../index.php"); exit;	}
	?>

	<nav class="subNav">
		<?php

			if (@$_SESSION["userData"]["uprawnienia"]=='administrator')
			{
				echo	"<a id='A' class='button' onclick='f(1)'>
						<i class='fa fa-folder'></i>	Albumy
						</a>

						<a id='U' class='button' onclick='f(4)'>
						<i class='fa fa-user'></i>	Użytkownicy
						</a>";
			}
		?>
		<a id="Z" class='button' onclick='f(2)'>
		<i class='fa fa-file-image-o'></i>	Zdjęcia
		</a>

		<a id="K" class='button' onclick='f(3)'>
		<i class='fa fa-comments-o'></i>	Komentarze
		</a>

		<a class='powrot button' href='../index.php?strona=galeria'>
		<i class='fa fa-arrow-circle-left fa-lg' aria-hidden='true'></i>
		<i class='fa fa-arrow-circle-o-left fa-lg' aria-hidden='true'></i>
		Powrót do GALERII</a>

		<div style="clear: both;"></div>
	</nav>

	<section>
		<?php
			if (@$_SESSION["userData"]["uprawnienia"]=='administrator')
			{
				//ALBUMY
				echo '<article id="tAlbumy">';
				
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
							
							$result = $db->query("DELETE FROM albumy 
														WHERE id=".$_POST['id_albumu']);
	
							if (!$result)
							{
								echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Usunięcie albumu nie powiodło się. Spróbuj ponownie.</p>';
							}
							else
							{
								$path = "../img/".$_POST['id_albumu'];
								if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
								{
								    exec(sprintf("rd /s /q %s", escapeshellarg($path)));
								}
								else
								{
								    exec(sprintf("rm -rf %s", escapeshellarg($path)));
								}
								echo '<p class="success">'.$path.'Album został usunięty'.escapeshellarg($path).'</p><br>'.sprintf("rm -rf %s", escapeshellarg($path));
							}
						}
						else
						{
							echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Nie wybrano albumu</p>';
						}
					}
				
					echo '<form method="post" action="index.php">

						<div class="input-group margin-bottom-sm">
						<select class="form-control" name="id_albumu" onchange="ajax_a(this.value)">
						<option selected="true" disabled="disabled">---Wybierz album---</option>';

								$result = $db->query ("SELECT  *
														FROM albumy
														ORDER BY id");

								while($row = $result->fetch_assoc())
								{
									echo "<option value='".$row["id"]."'>".$row["tytul"]."</option>";
								}

					echo '</select>
						</div>

						<div class="input-group margin-bottom-sm">
							<span class="input-group-addon">
								<i class="fa fa-folder fa-fw" aria-hidden="true"></i>
							</span>
							<input class="form-control" maxlength="100" type="text" name="tytul_a" placeholder="Nowa nazwa albumu">
						</div>

						<input type="submit" name="zm_a" value="Zmień">
						<input type="submit" name="usn_a" value="Usuń" onclick="return confirm(\'Czy na pewno chcesz usunąć ten album?\');">

					</form>
					
					<script>
					function ajax_a(id)
					{
						$.ajax
						({
							url: "ajax_album.php",
							data: {id_albumu: id},
							success: function(h)
							{
								$("#album").html(h)
							}
						})
					}
					</script>
					
					<div id="album" style="position:relative;"></div>
	
				</article>';



				//USERS
				echo '<article id="tUzytkownicy">';
				if(isset($_POST['zm_upr_u']))
				{
					$result = $db->query("UPDATE uzytkownicy 
											SET uprawnienia='".$_POST['user_upr']."'
											WHERE id=".$_POST['user_id']);

					if (!$result)
					{
						echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Zmiana uprawnień użytkownika nie powiodło się. Spróbuj ponownie.</p>';
					}
					else
					{
						echo '<p class="success">Uprawnienia zostały zmienione</p>';
					}
				}
				
				if(isset($_POST['zabl_u']))
				{
					$result = $db->query("UPDATE uzytkownicy 
											SET aktywny=0 
											WHERE id=".$_POST['user_id']);

					if (!$result)
					{
						echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Zablokowanie użytkownika nie powiodło się. Spróbuj ponownie.</p>';
					}
					else
					{
						echo '<p class="success">Użytkownik został zablokowany</p>';
					}
				}
				
				if(isset($_POST['usn_u']))
				{
					#usuwanie kom - sql
					$result = $db->query("DELETE FROM zadjecia_komentarze 
										WHERE id_uzytkownika=".$_POST['user_id']);
					
					#usuwanie zdjec - sql
					$result = $db->query("DELETE FROM zadjecia 
										WHERE id_uzytkownika=".$_POST['user_id']);
					
					#usuwanie albumow - sql + fizycznie
					$result = $db->query("SELECT id FROM albumy 
													WHERE id_uzytkownika=".$_POST['user_id']);
					
					//foreach($result->fetch_row() as $id_albumu)
					while($id_albumu = $result->fetch_row())
					{
						$path = "../img/".$id_albumu[0];
						if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
						{
						    exec(sprintf("rd /s /q %s", escapeshellarg($path)));
						}
						else
						{
						    exec(sprintf("rm -rf %s", escapeshellarg($path)));
						}
						//echo '<p class="success">Album został usunięty</p>';
					}
					
					$result = $db->query("DELETE FROM albumy 
													WHERE id_uzytkownika=".$_POST['user_id']);
					
					#usuwanie uzytkownika - sql
					$result = $db->query("DELETE FROM uzytkownicy 
													WHERE id=".$_POST['user_id']);
					
					if (!$result)
					{
						echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i>Usunięcie użytkownika nie powiodło się. Spróbuj ponownie.</p>';
					}
					else
					{
						echo '<p class="success">Użytkownik został usunięty</p>';
						unset($_POST['user_id']);
					}
				}
					
				echo '<form method="post" action="index.php">
						
						<div class="input-group margin-bottom-sm">
						
							<select class="form-control" name="user_type" onchange="this.form.submit()">
								<option selected="true" disabled="disabled">---Wybierz typ użytkownika---</option>
								<option id="u1" value="all">Wszyscy</option>
								<option id="u2" value="administrator">Administratorzy</option>
								<option id="u3" value="moderator">Moderatorzy</option>
								<option id="u4" value="uzytkownik">Użytkownicy</option>

							</select>';

						echo '</div>';
				
				if(isset($_POST['user_type']))
				{
						
					
					echo '<div class="input-group margin-bottom-sm">
						
						<select class="form-control" name="user_id" onchange="this.form.submit()">
							<option selected="true" disabled="disabled">---Wybierz użytkownika---</option>';

							switch ($_POST['user_type']) 
							{
								case 'all':
									$who = '';
									
									echo '<script type="text/javascript">
											$("#u1").prop("selected", true);
										</script>';
									break;
								
								case 'administrator':
									$who = "WHERE uprawnienia='administrator'";
									
									echo '<script type="text/javascript">
											$("#u2").prop("selected", true);
										</script>';
									break;

								case 'moderator':
									$who = "WHERE uprawnienia='moderator'";
									
									echo '<script type="text/javascript">
											$("#u3").prop("selected", true);
										</script>';
									break;

								case 'uzytkownik':
									$who = "WHERE uprawnienia='uzytkownik'";
									
									echo '<script type="text/javascript">
											$("#u4").prop("selected", true);
										</script>';
									break;
							}
								$result = $db->query ("SELECT  *
														FROM uzytkownicy
														 ".$who);

								while($row = $result->fetch_assoc())
								{
									$selected = '';
									if ($_POST['user_id']==$row["id"])
									{
										$selected = 'selected="true"';
										switch ($row["uprawnienia"])
										{
											case 'uzytkownik':
												$tu = 'tu4';
												break;
											
											case 'moderator':
												$tu = 'tu3';
												break;
											
											case 'administrator':
												$tu = 'tu2';
												break;
										}
									}
									echo "<option ".$selected." value='".$row["id"]."'>".$row["login"]."</option>";
								}

					echo '</select>
						</div>';
						
						if (isset($_POST['user_id']))
						{
							echo '<input type="submit" name="zabl_u" value="Zablokuj">
								<input type="submit" name="usn_u" value="Usuń" onclick="return confirm(\'Czy na pewno chcesz usunąć tego użytkownika? Wraz z nim zostaną usunięte wszystkie jego albumy, zdjęcia i komentarze.\');">';
								
							echo '<div class="input-group folder">Zmień typ użytkownika:<select class="form-control" name="user_upr">';
							
								echo "<option id='tu4' value='uzytkownik'>Użytkownik</option>";
								echo "<option id='tu3' value='moderator'>Moderator</option>";
								echo "<option id='tu2' value='administrator'>Administrator</option>";
								
								echo '<script type="text/javascript">
													$("#'.$tu.'").prop("selected", true);
												</script>';
								
							echo '</select></div>';
		
							echo '<input type="submit" name="zm_upr_u" value="Zmień uprawnienia">';
						}
				}
				echo '</form></article>';
			}
		?>
		<article id="tZdjecia">
			<?php
			//ZDJECIA
				if (isset($_POST['akcpt_z']))
				{
					if ($_POST['id_zdjecia']>0)
					{
						$tytul_z = $_POST['tytul_z'];
						$result = $db->query("UPDATE zadjecia 
												SET zaakceptowane=1 
												WHERE id=".$_POST['id_zdjecia']);
	
						if (!$result)
						{
							echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Zaakceptowanie zdjęcia nie powiodła się. Spróbuj ponownie.</p>';
						}
						else
						{
							echo '<p class="success">Zdjęcia zostało zaakceptowane</p>';
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
							unlink("../img/".$row['id_albumu']."/".$_POST['id_zdjecia']);
							echo '<p class="success">Zdjęcie zostało usunięte</p>';
						}
					}
					else
					{
						echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Nie wybrano zdjęcia</p>';
					}
				}
			?>
			
			<form method="post" action="index.php">
				
				<div class="input-group margin-bottom-sm">
					
					<select class="form-control" name="z_type" onchange="this.form.submit()">
						<option selected="true" disabled="disabled">---Wybierz typ zdjęcia---</option>
						<option id="z1" value="all">Wszystkie</option>
						<option id="z2" value="to_acpt">Do akceptacji</option>
					</select>
					
				</div>

			<?php
			if (isset($_POST['z_type']))
			{
				echo '<div class="input-group margin-bottom-sm">
					<select class="form-control" name="id_zdjecia" onchange="ajax_z(this.value)">
					<option selected="true" disabled="disabled">---Wybierz zdjęcie---</option>';
						
					switch ($_POST['z_type'])
					{
						case 'all':
							$z_type = '';
							
							echo '<script type="text/javascript">
									$("#z1").prop("selected", true);
								</script>';
							break;
						
						case 'to_acpt':
							$z_type = 'WHERE zaakceptowane=0';
							
							echo '<script type="text/javascript">
									$("#z2").prop("selected", true);
								</script>';
							break;
					}
					
					$result = $db->query ("SELECT *
											FROM zadjecia
											$z_type
											ORDER BY id");

					while($row = $result->fetch_assoc())
					{
						if (strlen($row["tytul"])>50) 
						{
							$row["tytul"] = substr($row["tytul"], 0, 50);
							$row["tytul"] = $row["tytul"]."...";
						}
						echo "<option value='".$row["id"]."'>".$row["tytul"]."</option>";
					}

				echo	"</select>
					</div>";

				if ($_POST['z_type'] == 'to_acpt')
				{
					echo	"<input type='submit' name='akcpt_z' value='Zaakceptuj'>";
				}

				echo	"<input type='submit' name='usn_z' value='Usuń' onclick='return confirm(".'"Czy na pewno chcesz usunąć to zdjęcie?"'.");'>
					
				
				
				<script>
					function ajax_z(id)
					{
						$.ajax
						({
							url: 'ajax_zdjecie.php',
							data: {id_zdjecia: id},
							success: function(i)
							{
								$('#zdjecie').html(i)
							}
						})
					}
				</script>
				
				<div id='zdjecie'></div>";
			}
			?>
			</form>
			

		</article>
		
		<article id="tKomentarze">
			<?php
			//KOMENTARZE
			if (@$_SESSION["userData"]["uprawnienia"]=='administrator')
			{
				if (isset($_POST['zm_k']))
				{
					if ($_POST["k_id"]>0)
					{
						$result = $db->query ("UPDATE zadjecia_komentarze
												SET	komentarz='".$_POST["chg_k"]."' WHERE id=".$_POST["k_id"]);
												
						if ($result)
						{
							echo '<p class="success">Komentarz został zmieniony</p>';
						}
						else
						{
							echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Zmiana komentarza nie powiodła się. Spróbuj ponownie.</p>';
						}
					}
					else
					{
						echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Nie wybrano komentarza</p>';
					}
				}
			}
			if (isset($_POST['usn_k']))
			{
				if ($_POST["k_id"]>0)
				{
					$result = $db->query ("DELETE
											FROM zadjecia_komentarze
											WHERE id=".$_POST["k_id"]);
											
					if ($result)
					{
						echo '<p class="success">Komentarz został usunięty</p>';
					}
					else
					{
						echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Usunięcie komentarza nie powiodło się. Spróbuj ponownie.</p>';
					}
				}
				else
				{
					echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Nie wybrano komentarza</p>';
				}
			}
			if (isset($_POST['akcpt_k']))
			{
				if ($_POST["k_id"]>0)
				{
					$result = $db->query ("UPDATE zadjecia_komentarze SET
											zaakceptowany=1
											WHERE id=".$_POST["k_id"]);
											
					if ($result)
					{
						echo '<p class="success">Komentarz został zaakceptowany</p>';
					}
					else
					{
						echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Zaakceptowanie komentarza nie powiodło się. Spróbuj ponownie.</p>';
					}
				}
				else
				{
					echo '<p class="error" style="margin: 0 0 5px 0;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Nie wybrano komentarza</p>';
				}
			}
			?>
			
			<form method="post" action="index.php">
				
				<div class="input-group margin-bottom-sm">
					
					<select class="form-control" name="k_type" onchange="this.form.submit()">
						<option selected="true" disabled="disabled">---Wybierz typ komentarza---</option>
						<option id="k1" value="all">Wszystkie</option>
						<option id="k2" value="to_acpt">Do akceptacji</option>
					</select>
					
				</div>
				
			
			
			<?php
			if (isset($_POST['k_type']))
			{
				echo '<div class="input-group margin-bottom-sm">
					<select class="form-control" name="k_id" onchange="this.form.submit()">
						<option selected="true" disabled="disabled">---Wybierz komentarz---</option>';
							
						switch ($_POST['k_type'])
						{
							case 'all':
								$k_type = '';
								
								echo '<script type="text/javascript">
										$("#k1").prop("selected", true);
									</script>';
								break;
							
							case 'to_acpt':
								$k_type = 'WHERE zaakceptowany=0';
								
								echo '<script type="text/javascript">
										$("#k2").prop("selected", true);
									</script>';
								break;
						}
						
						$result = $db->query ("SELECT *
												FROM zadjecia_komentarze ".$k_type);
	
						while($row = $result->fetch_assoc())
						{
							$selected ='';
							if (@$_POST["k_id"]==$row["id"])
							{
								$selected='selected="true"';
								$kom = $row["komentarz"];
							}
							if (strlen($row["komentarz"])>50) 
							{
								
								$row["komentarz"] = substr($row["komentarz"], 0, 50);
								$row["komentarz"] = $row["komentarz"]."...";
							}
							echo "<option $selected value='".$row["id"]."'>".$row["komentarz"]."</option>";
						}
							
				echo "</select>
					</div>";

				if ($_POST['k_type'] == 'to_acpt')
				{
					echo	"<input type='submit' name='akcpt_z' value='Zaakceptuj'>";
				}

				echo "<input type='submit' name='usn_k' value='Usuń' onclick='return confirm(".'"Czy na pewno chcesz usunąć ten komentarz?"'.");'>";
				
				if (@isset($_POST["k_id"]))
				{
					if (@$_SESSION["userData"]["uprawnienia"]=='administrator')
					{
						echo '<div class="margin-top-sm"><textarea class="folder" name="chg_k" cols="60" rows="5">'.$kom.'</textarea></div><input type="submit" value="Zmień" name="zm_k">';
					}
					else
					{
						echo '<br><div class="kom margin-top-sm">Treść komentarza:<div class="komt">'.$kom.'</div></div>';
					}
				}
			}
			?>
			</form>
		</article>
		
	</section>

	<footer>Jarosław Suchiński 4Ta</footer>

	<script type="text/javascript">
		$("#tAlbumy").css("display","none");
		$("#tZdjecia").css("display","none");
		$("#tKomentarze").css("display","none");
		$("#tUzytkownicy").css("display","none");

	<?php
		if ((isset($_POST['usn_u'])) || (isset($_POST['zabl_u'])) || (isset($_POST['zm_upr_u'])) || (isset($_POST['user_type'])))
		{
			echo '$("#U").addClass("green");';
			echo '$("#tUzytkownicy").css("display","block");';
		}
		
		if ((isset($_POST['zm_a'])) || (isset($_POST['usn_a'])))
		{
			echo '$("#A").addClass("green");';
			echo '$("#tAlbumy").css("display","block");';
		}
		
		if ((isset($_POST['akcpt_z'])) || (isset($_POST['usn_z'])) || (isset($_POST['z_type'])))
		{
			echo '$("#Z").addClass("green");';
			echo '$("#tZdjecia").css("display","block");';
		}
		
		if ((isset($_POST['zm_k'])) || (isset($_POST['usn_k'])) || (isset($_POST['akcpt_k'])) || (isset($_POST['k_type'])) || (isset($_POST['k_id'])))
		{
			echo '$("#K").addClass("green");';
			echo '$("#tKomentarze").css("display","block");';
		}
	?>

		function f(n)
		{
			<?php
				if (@$_SESSION["userData"]["uprawnienia"]=='administrator')
				{
					echo 	
					'if (n==1)
					{
						$("#A").addClass("green");
						$("#tAlbumy").css("display","block");
					}
					else
					{
						$("#A").removeClass("green");
						$("#tAlbumy").css("display","none");
					}
					
					if (n==4)
					{
						$("#U").addClass("green");
						$("#tUzytkownicy").css("display","block");
					}
					else
					{
						$("#U").removeClass("green");
						$("#tUzytkownicy").css("display","none");
					}';
				}
			?>

			if (n==2)
			{
				$("#Z").addClass("green");
				$("#tZdjecia").css("display","block");
			}
			else
			{
				$("#Z").removeClass("green");
				$("#tZdjecia").css("display","none");
			}
			
			if (n==3)
			{
				$("#K").addClass("green");
				$("#tKomentarze").css("display","block");
			}
			else
			{
				$("#K").removeClass("green");
				$("#tKomentarze").css("display","none");
			}
		}
	</script>

</body>
</html>