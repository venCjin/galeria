<?php
	/* DODAJ-KOMENTARZ */
	require 'conn.php';

	$user_kom = $db->real_escape_string(trim(strip_tags($_POST['komentarz'])));

	if (strlen($user_kom)>0)
	{
		$user = $_SESSION["userData"]["id"];
		$id_zdjecia = $_POST['id_zdjecia'];
		
		$result = $db->query("INSERT INTO zadjecia_komentarze
			(id_zadjecia, id_uzytkownika, data, komentarz, zaakceptowany) 
			VALUES ('$id_zdjecia','$user',CURRENT_DATE,'$user_kom',1)");
	}
	header("Location: index.php?strona=foto&id_zdjecia=$id_zdjecia");
?>