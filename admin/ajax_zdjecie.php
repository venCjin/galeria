<?php
require '/xampp/htdocs/Suchinski/conn.php';

//WYSWIETLANE MINIATUR
$id_zdjecia = $_GET['id_zdjecia'];

$row = $db->query ("SELECT id_albumu
						FROM zadjecia 
						WHERE id=$id_zdjecia")->fetch_assoc();

$id_albumu = $row["id_albumu"];

				echo "<div id='galeria' style='width:192px; height:192px;'><a class='dymek'><img class='miniatura' src='../img/$id_albumu/$id_zdjecia' width='180px' height='180px'></a></div>";
?>