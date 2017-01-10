<?php
$pg_a = (isset($_SESSION['pg_a'])) ? $_SESSION['pg_a'] : 1;
$pg_g = (isset($_SESSION['pg_g'])) ? $_SESSION['pg_g'] : 1;


echo "<a class='powrot' href='index.php?strona=galeria&page=$pg_g'><i class='fa fa-arrow-circle-left fa-lg' aria-hidden='true'></i><i class='fa fa-arrow-circle-o-left fa-lg' aria-hidden='true'></i>
Powrót</a>";
?>

<div id="galeria">
	<?php
		//ILOŚĆ ALBUMÓW
		$id_albumu = $_GET['id_albumu'];
		$result = $db->query ("SELECT z.id
								FROM albumy AS a
								JOIN zadjecia AS z
								ON a.id=z.id_albumu
								WHERE z.zaakceptowane AND a.id=$id_albumu
								GROUP BY z.id");
		$ile = $result->num_rows;

		//STRONNICOWANIE
		$pom = 20;
		$pages = ceil($ile/$pom);
		$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
		$sqlpage = $pom*($page-1);

		//WYSWIETLANE MINIATUR
		$result = $db->query ("SELECT a.id AS id_a,	z.id AS id_z, z.tytul AS opis, z.data AS data, u.login AS autor
								FROM albumy AS a
								JOIN zadjecia AS z ON a.id=z.id_albumu
								JOIN uzytkownicy AS u ON z.id_uzytkownika=u.id
								WHERE z.zaakceptowane AND a.id=$id_albumu
								ORDER BY a.tytul
								limit $sqlpage,$pom");

		while($row = $result->fetch_assoc())
		{
			$id_albumu = $row['id_a'];
			$id_zdjecia = $row['id_z'];
			$autor = $row['autor'];
			$data = $row['data'];
			$opis = $row['opis'];
			echo "<div class='dymek'>
			<a href='index.php?strona=foto&id_zdjecia=$id_zdjecia'>
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

<div class="page">
	<label class="sort-label">Strony: </label>
	<?php
		//STRONNICOWANIE - PRZYCISKI
		for($i=1; $i<=$pages; $i++)
		{
			echo "<a id='pg$i' class='button' href='index.php?strona=album&id_albumu=$id_albumu&page=$i'>$i</a>";
		}
	?>
	<div style="clear: both;"></div>
</div>

<br>

<?php
echo "<a class='powrot' href='index.php?strona=galeria&page=$pg_g'><i class='fa fa-arrow-circle-left fa-lg' aria-hidden='true'></i><i class='fa fa-arrow-circle-o-left fa-lg' aria-hidden='true'></i>
Powrót</a>";
?>

<script type="text/javascript">
<?php
	if(@isset($_GET['page']))
	{
		echo "$('#pg".$_GET['page']."').css('background-color','#4E986F');";
		$_SESSION['pg_a'] = $_GET['page'];
	}
	else
	{
		echo "$('#pg1').css('background-color','#4E986F');";
	}
?>
</script>