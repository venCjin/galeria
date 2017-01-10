<h2>
	<b>Tworzenie albumu</b>
</h2>

<br>

Podaj nazwę albumu (nie dłuższą niż 100 znaków):

<form method="POST" action="index.php?strona=dodaj-album">
	<div class="input-group folder">
		<span class="input-group-addon"><i class='fa fa-folder' aria-hidden='true'></i></span>
		<input class="form-control folder" maxlength="100" type="text" name="nazwa_albumu" placeholder="Nazwa albumu" required>
	</div>

	<input type="submit" value="Stwórz!">
</form>

<?php
if (isset($_POST['nazwa_albumu']))
{
	if (strlen($_POST['nazwa_albumu'])<101)
		{
			$folder = $db->real_escape_string(htmlspecialchars(trim(strip_tags($_POST['nazwa_albumu']))));
			$uzytkownik = $_SESSION["userData"]["id"];

			function insert_join($folder, $uzytkownik)
			{
				global $db;

				$result = $db->query("INSERT INTO albumy (id, tytul, data, id_uzytkownika) VALUES(NULL, '$folder', CURRENT_DATE, '$uzytkownik')");

				if (!$result)
				{
		     		return false;
		   		} 
		   		else 
		   		{
		    		return $db->insert_id;
				}
			}

			$id_folderu=insert_join($folder, $uzytkownik);

			if (!$id_folderu) 
			{
				echo "<p class='error'><i style='color: #EB3232;' class='fa fa-exclamation-circle' aria-hidden='true'></i>	Błąd podczas tworzenia albumu.
					<br>
					<b>Folder o nazwie: <i>$folder</i> nie został stworzony.</b></p>";
			}
			else
			{
			echo "<br>".$id_folderu."<br>";
			mkdir ("img/".$id_folderu, 0777);

			echo "<b>Folder o nazwie: <i>$folder</i> został stworzony!</b>";

			$_SESSION["id_albumu"] = $id_folderu;
			header("Location: index.php?strona=dodaj-foto");
			}
		}
	else
		{
			echo "<i style='color: #EB3232;' class='fa fa-exclamation-circle' aria-hidden='true'></i><b>Za długa nazwa!</b>";
		}
}
?>