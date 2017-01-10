<?php
require 'conn.php';

if ($_POST["id_albumu"]>0)
{
	$allowed = array ('image/svg+xml', 'image/tiff', 'image/gif', 'image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');

	if (in_array($_FILES['zdjecie']['type'], $allowed))
	{
		include_once "class.img.php";

		$img = new Image($_FILES['zdjecie']['tmp_name']);

		$img->SetMaxSize(1200);

		//SQL - BD
		$opis = $_POST["opis"];
		$id_albumu = $_POST["id_albumu"];
		$user = $_SESSION["userData"]["id"];

		function insert($opis, $id_albumu, $user) 
		{
			global $db;
			$result = $db->query("INSERT INTO zadjecia ( tytul, id_albumu, data, id_uzytkownika, zaakceptowane) 
							VALUES ( '$opis', '$id_albumu', CURRENT_DATE, '$user', 0)");

			if (!$result) 
			{
				header("Location: index.php?strona=dodaj-foto&err&sql_error");
				die;
			} 
			else 
			{
				return $db->insert_id;
			}
		}

		$id_zdjecia = insert($opis, $id_albumu, $user);
		// zapisanie zdjęcia do katalogu
		$lokalizacja = 'img/'.$id_albumu.'/'.$id_zdjecia;
		$img->Save($lokalizacja);

		$_SESSION["id_albumu"] = $id_albumu;
		unset($_FILES);
		header("Location: index.php?strona=dodaj-foto");
	}
	else //NIE JEST GRAFIKĄ
	{
		header("Location: index.php?strona=dodaj-foto&err&is_not_graphic");
	}
}
else //NIE WYBRANO ALBUMU
{
	header("Location: index.php?strona=dodaj-foto&err&brak_id_albumu");
}
?>