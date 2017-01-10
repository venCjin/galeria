<div id="galeria">
	<?php
		//ILOŚĆ ALBUMÓW
		$result = $db->query ("SELECT a.id AS ile
								FROM albumy AS a
								JOIN zadjecia AS z
								ON a.id=z.id_albumu
								WHERE z.zaakceptowane
								GROUP BY a.id
								HAVING SUM(z.zaakceptowane)>0");
		$ile = $result->num_rows;

		//STRONNICOWANIE
		$pom = 20;
		$pages = ceil($ile/$pom); 
		$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
		$sqlpage = $pom*($page-1);

		//SORTOWANIE
		switch (@$_GET['sort']) 
		{
			case 'nick':
				$_SESSION['sort'] = 'u.login';
				break;

			case 'data':
				$_SESSION['sort'] = 'a.data';
				break;
			
			case 'tytul':
				$_SESSION['sort'] = 'a.tytul';
				break;
		}

		if(!isset($_SESSION['sort'])) 
		{
			$_SESSION['sort'] = 'a.tytul';
		}

		$sort = $_SESSION['sort'];

		//WYSWIETLANE MINIATUR
		$result = $db->query ("SELECT 
									a.id AS id_a, z.id AS id_z, a.tytul AS tytul, a.data AS data,
									u.login AS login
								FROM albumy AS a
									JOIN uzytkownicy AS u ON a.id_uzytkownika=u.id
									JOIN zadjecia AS z ON a.id=z.id_albumu
								WHERE z.zaakceptowane
								GROUP BY a.id
								ORDER BY $sort
								limit $sqlpage,$pom");

		while($row = $result->fetch_assoc())
		{
			$id_albumu = $row['id_a'];
			$id_zdj = $row['id_z'];
			$tytul = $row['tytul'];
			$login = $row['login'];
			$data = $row['data'];
			echo "<div class='dymek'>
			<a href='index.php?strona=album&id_albumu=$id_albumu'>
			<span><div><p>Tytuł galerii: $tytul<br>Autor: $login<br>Data utworzenia: $data</p></div></span>
			<img class='miniatura' src='img/$id_albumu/$id_zdj' width='180px' height='180px'>
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
			echo "<a id='pg$i' class='button' href='index.php?strona=galeria&page=$i'>$i</a>";
		}
	?>
	
	<div style="clear: both;"></div>

	<label class="sort-label">Sortowanie: </label>
	<a id="sort-t" class="button" href='index.php?strona=galeria&sort=tytul'>tytul albumu</a>
	<a id="sort-n" class="button" href='index.php?strona=galeria&sort=nick'>nick autora</a>
	<a id="sort-d" class="button" href='index.php?strona=galeria&sort=data'>data dodania</a>

	<div style="clear: both;"></div>
</div>

<script type="text/javascript">
<?php
	switch (@$_SESSION['sort'])
	{
		case 'u.login':
			echo '$("#sort-n").css("background-color","#4E986F");';
			break;

		case 'a.data':
			echo '$("#sort-d").css("background-color","#4E986F");';
			break;

		case 'a.tytul':
			echo '$("#sort-t").css("background-color","#4E986F");';
			break;
	}

	if(@isset($_GET['page']))
	{
		echo "$('#pg".$_GET['page']."').css('background-color','#4E986F');";
		$_SESSION['pg_g'] = $_GET['page'];
	}
	else
	{
		echo "$('#pg1').css('background-color','#4E986F');";
	}
?>
</script>