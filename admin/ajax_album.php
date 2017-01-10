<?php
require '/xampp/htdocs/Suchinski/conn.php';

//WYSWIETLANE MINIATUR
$id_albumu = $_GET['id_albumu'];
$result = $db->query ("SELECT *
						FROM zadjecia 
						WHERE id_albumu=$id_albumu
						ORDER BY id");

$ile = $result->num_rows;

if($ile)
	{
		echo "<div id='galeria'>";
		while($row = $result->fetch_assoc())
			{
				$id_zdjecia = $row['id'];
				echo "<a class='dymek'><img class='miniatura' src='../img/$id_albumu/$id_zdjecia' width='180px' height='180px'></a>";
			}
		echo "<div style='clear: both;'></div></div>";
	}
?>
