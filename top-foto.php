<div id="galeria">
	<?php
		//WYSWIETLANE MINIATUR
		$result = $db->query ("SELECT a.id AS id_a,	z.id AS id_z, z.tytul AS opis, z.data AS data, u.login AS autor, AVG(zo.ocena) AS zoo
								FROM zadjecia AS z
								JOIN albumy AS a ON a.id=z.id_albumu
								JOIN uzytkownicy AS u ON z.id_uzytkownika=u.id
								JOIN zadjecia_oceny AS zo ON zo.id_zadjecia=z.id
								WHERE z.zaakceptowane
								GROUP BY zo.id_zadjecia
								ORDER BY zoo DESC
								limit 20");

		while($row = $result->fetch_assoc())
		{
			$id_albumu = $row['id_a'];
			$id_zdjecia = $row['id_z'];
			$autor = $row['autor'];
			$data = $row['data'];
			$opis = $row['opis'];
			echo "<div class='dymek'>
			<a href='index.php?strona=foto&powrot=top&id_zdjecia=$id_zdjecia'>
			<span><div><p>Dodany przez: $autor<br>Data dodania zdjęcia: $data";
			if ($opis!='') 
			{
				if (strlen($opis)>110) 
				{
					$opis = substr($opis, 0, 110);
					$opis = $opis."...";
				}
				echo "<br>Opis zdjęcia: $opis";
			}
			echo "</p></div></span>
			<img class='miniatura' src='img/$id_albumu/$id_zdjecia' width='180px' height='180px'>
			</a>
			</div>";
		}
	?>
	<div style="clear: both;"></div>
</div>