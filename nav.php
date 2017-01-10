<nav>
	<a id="gal" class='button' href='index.php?strona=galeria'><i class='fa fa-home'></i>	Galeria</a>

	<a id="top-f" class='button' href='index.php?strona=top-foto'><i class='fa fa-star'></i>	Najlepiej oceniane</a>

	<a id="new-f" class='button' href='index.php?strona=nowe-foto'><i class='fa fa-certificate'></i>	Najnowsze</a>

	<?php
		//niezalogowany
		if(!isset($_SESSION["userData"]))
		{
			echo "<a class='button' href='index.php?log_err'><i class='fa fa-folder' aria-hidden='true'></i>	Załóż album</a>";
			echo "<a class='button' href='index.php?log_err'><i class='fa fa-plus-square' aria-hidden='true'></i>	Dodaj zdjęcie</a>";
			echo "<a id='b-log' class='button' href='index.php'><i class='fa fa-user fa-fw' aria-hidden='true'></i>	Zaloguj się</a>";
			echo "<a id='b-reg' class='button' href='index.php?strona=reg-log'><i class='fa fa-sign-in' aria-hidden='true'></i>	Rejestracja</a>";
		}
		//zalogowany
		else
		{
			echo "<a id='add-a' class='button' href='index.php?strona=dodaj-album'><i class='fa fa-folder' aria-hidden='true'></i>	Załóż album</a>";
			echo "<a id='add-z' class='button' href='index.php?strona=dodaj-foto'><i class='fa fa-plus-square' aria-hidden='true'></i>	Dodaj zdjęcie</a>";
			echo "<a id='acc' class='button' href='index.php?strona=konto'><i class='fa fa-user fa-fw' aria-hidden='true'></i>	Moje konto</a>";
			echo "<a class='button' href='index.php?logout'><i class='fa fa-sign-out' aria-hidden='true'></i>	Wyloguj się</a>";
		}

		if((@$_SESSION["userData"]["uprawnienia"]=='moderator')OR(@$_SESSION["userData"]["uprawnienia"]=='administrator'))
		{	echo "<a class='button' href='admin/index.php'><i class='fa fa-unlock-alt' aria-hidden='true'></i>	Panel admina</a>";	}
	?>
	<div style="clear: both;"></div>
</nav>

<script type="text/javascript">
<?php
	switch (@$_GET['strona'])
	{
		case 'galeria':
			echo '$("#gal").css("background-color","#4E986F");';
			break;

		case 'top-foto':
			echo '$("#top-f").css("background-color","#4E986F");';
			break;

		case 'nowe-foto':
			echo '$("#new-f").css("background-color","#4E986F");';
			break;

		case 'dodaj-album':
			echo '$("#add-a").css("background-color","#4E986F");';
			break;

		case 'dodaj-foto':
			echo '$("#add-z").css("background-color","#4E986F");';
			break;

		case 'konto':
			echo '$("#acc").css("background-color","#4E986F");';
			break;

		case 'reg-log':
			echo '$("#b-reg").css("background-color","#4E986F");';
			break;

		case 'album':
		case 'foto':
			break;

		default:
			echo '$("#b-log").css("background-color","#4E986F");';
			break;
	}
?>
</script>

<?php
	echo "<br>";
	if (isset($_GET['log_err']))
	{
		echo '<p class="error" style="width: 100%; text-align:center;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Aby dodawać albumy i zdjęcia muszisz być zalogowany</p>';
	}
?>