<div id="galeria">
	<?php
		//WYSWIETLANE MINIATUR
		$result = $db->query ("SELECT a.id AS id_a,	z.id AS id_z, z.tytul AS opis, z.data AS data, u.login AS autor
								FROM albumy AS a
								JOIN zadjecia AS z ON a.id=z.id_albumu
								JOIN uzytkownicy AS u ON z.id_uzytkownika=u.id
								WHERE z.zaakceptowane
								ORDER BY z.data DESC
								limit 20");

		while($row = $result->fetch_assoc())
		{
			$id_albumu = $row['id_a'];
			$id_zdjecia = $row['id_z'];
			$autor = $row['autor'];
			$data = $row['data'];
			$opis = $row['opis'];
			echo "<div class='dymek'>
			<a href='index.php?strona=foto&powrot=new&id_zdjecia=$id_zdjecia'>
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