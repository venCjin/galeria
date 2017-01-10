<script>
	function doRating(stars)
	{
		$('#ocena').val(stars);

		for (var id = 1; id <= 10; id++)
		{
			selector = '#s' + id;
			$(selector).removeClass('star-1');
		}

		for (var id = 1; id <= stars; id++)
		{
			selector = '#s' + id;
			$(selector).addClass('star-1');
		}
	}
</script>
<?php
$pg_a = (isset($_SESSION['pg_a'])) ? $_SESSION['pg_a'] : 1;
$id_zdjecia = $_GET['id_zdjecia'];

$result = $db->query ("SELECT z.tytul, z.id_albumu, z.data, 
								u.login
						FROM zadjecia AS z
						JOIN uzytkownicy AS u ON z.id_uzytkownika=u.id
						WHERE zaakceptowane AND z.id=$id_zdjecia");
$row = $result->fetch_assoc();

$login = $row['login'];
$data = $row['data'];
$tytul = $row['tytul'];
$id_albumu = $row['id_albumu'];

/* POWROT */
if ($_GET[powrot]=="top")
{
	echo "<a class='powrot' href='index.php?strona=top-foto'><i class='fa fa-arrow-circle-left fa-lg' aria-hidden='true'></i><i class='fa fa-arrow-circle-o-left fa-lg' aria-hidden='true'></i>
Powrót</a>";
}
else if ($_GET[powrot]=="new")
{
	echo "<a class='powrot' href='index.php?strona=nowe-foto'><i class='fa fa-arrow-circle-left fa-lg' aria-hidden='true'></i><i class='fa fa-arrow-circle-o-left fa-lg' aria-hidden='true'></i>
Powrót</a>";
}
else
{
	echo "<a class='powrot' href='index.php?strona=album&id_albumu=$id_albumu&page=$pg_a'><i class='fa fa-arrow-circle-left fa-lg' aria-hidden='true'></i><i class='fa fa-arrow-circle-o-left fa-lg' aria-hidden='true'></i>
Powrót</a><br><br>";
}
/* ----- */

/* INFO O ZDJECIU */
echo "<div class='foto'>
		Dodany przez: $login<br>
		Data dodania zdjęcia: $data<br>";

if ($tytul!='')
{
	echo "Opis zdjęcia: $tytul";
	  
}

echo "</div><br>";
/* -------------- */

/* ZDJĘCIE */
echo "<div class='foto' style='width: 1220px;'><img src='img/$id_albumu/$id_zdjecia'></div><br>";
/* ------- */

/* OCENY */
if(isset($_SESSION["userData"]))
{
	$user = $_SESSION['userData']['id'];
	
	$result = $db->query ("SELECT *
					FROM zadjecia_oceny
					WHERE id_uzytkownika='$user' 
					AND id_zadjecia='$id_zdjecia'");

	@$user_ocenil = $result->num_rows;
	if (@$user_ocenil==0)
	{
		if((@$_POST['ocena']>=1) && (@$_POST['ocena']<=10))
		{
			$user_o = $_POST['ocena'];
			$result = $db->query ("INSERT INTO zadjecia_oceny VALUES ('$id_zdjecia','$user','$user_o')");
			$user_ocenil=1;
		}
		elseif(@isset($_POST['ocena']))
		{
			echo "<script type=\"text/javascript\">window.alert('Ejże! Nie majstruj przy ocenie. Zakres ocen to 1-10.');</script>";
		}
	}
}
else
{
	$user_ocenil=1;
}

$result = $db->query ("SELECT *
						FROM zadjecia_oceny
						WHERE id_zadjecia='$id_zdjecia'");

$ilosc_oceniajacych =$result->num_rows;

$suma_ocen = $db->query ("SELECT SUM(ocena)  as ile
						FROM zadjecia_oceny
						WHERE id_zadjecia='$id_zdjecia'");
$suma = $suma_ocen->fetch_assoc();

@$ocena =$suma['ile']/$ilosc_oceniajacych;

if($ocena=='') $ocena = '0';
echo "<div class='foto'>Ocena: ".round($ocena, 2)." (Liczba oceniających: ".$ilosc_oceniajacych.")<br>";

if (@$user_ocenil==0)
{
	echo "Oceń: 1-10<br>";
	
	/*-------------------------------------*/
	echo "<span class='rating'>";

	echo	'<span title="10" id="s10" onclick="doRating(10);" class="star"></span>';
	echo	'<span title="9" id="s9" onclick="doRating(9);" class="star"></span>';
	echo	'<span title="8" id="s8" onclick="doRating(8);" class="star"></span>';
	echo	'<span title="7" id="s7" onclick="doRating(7);" class="star"></span>';
	echo	'<span title="6" id="s6" onclick="doRating(6);" class="star"></span>';
	echo	'<span title="5" id="s5" onclick="doRating(5);" class="star"></span>';
	echo	'<span title="4" id="s4" onclick="doRating(4);" class="star"></span>';
	echo	'<span title="3" id="s3" onclick="doRating(3);" class="star"></span>';
	echo	'<span title="2" id="s2" onclick="doRating(2);" class="star"></span>';
	echo	'<span title="1" id="s1" onclick="doRating(1);" class="star"></span>';

	echo "</span>";
	/* ------------------------------*/
	echo "<form method='POST' action='index.php?strona=foto&id_zdjecia=".$id_zdjecia."'>
			<input type='hidden' name='ocena' id='ocena'></input>
			<input type='submit' value='Oceń!'></input>
			</form>";
}

echo "</div><br>";
/* ------- */

/* WYŚWIETLANIE KOMENTARZY */
echo "<div class='foto'>
		<h3>Komentarze</h3>";

$result = $db->query("SELECT u.login AS login, k.data AS data, k.komentarz AS kom
					FROM zadjecia_komentarze AS k
					JOIN uzytkownicy AS u
					ON u.id=k.id_uzytkownika
					WHERE id_zadjecia='$id_zdjecia'");

$ile = $result->num_rows;

if($ile>0)
{
	while ($row = $result->fetch_assoc()) 
	{
		$login = $row['login'];
		$data = $row['data'];
		$kom = $row['kom'];
		echo "<div class='kom'>
				$login • $data
				<br>
				<div class='komt'>$kom</div>
				</div><br>";
	}
}
else
{
	echo "<div class='kom'>Nie dodano jeszcze żadnych komentarzy.</div><br>";
}
/* -------------------- */

/* DODAWANIE KOMENTARZA */
if(isset($_SESSION["userData"]))
{
	echo "<form action='dodaj-komentarz.php' method='post' enctype='multipart/form-data' accept='text/html'>

			<label>
			Dodaj komentarz: 
			</label>

			<textarea cols='60' rows='5' name='komentarz' placeholder='Napisz komentarz'></textarea>
			<br>
			<input type='hidden' value='$id_zdjecia' name='id_zdjecia'></input>
			<input type='submit' value='Skomentuj'></input>

			</form>";
}
else
{
	echo "Musisz być <a href='index.php'>zalogowany</a>, by dodać komentarz.<br>";
}
echo "</div><br>";
/* -------------------- */

/* POWROT */
if ($_GET[powrot]=="top")
{
	echo "<a class='powrot' href='index.php?strona=top-foto'><i class='fa fa-arrow-circle-left fa-lg' aria-hidden='true'></i><i class='fa fa-arrow-circle-o-left fa-lg' aria-hidden='true'></i>
Powrót</a>";
}
else if ($_GET[powrot]=="new")
{
	echo "<a class='powrot' href='index.php?strona=nowe-foto'><i class='fa fa-arrow-circle-left fa-lg' aria-hidden='true'></i><i class='fa fa-arrow-circle-o-left fa-lg' aria-hidden='true'></i>
Powrót</a>";
}
else
{
	echo "<a class='powrot' href='index.php?strona=album&id_albumu=$id_albumu&page=$pg_a'><i class='fa fa-arrow-circle-left fa-lg' aria-hidden='true'></i><i class='fa fa-arrow-circle-o-left fa-lg' aria-hidden='true'></i>
Powrót</a><br><br>";
}
/* ----- */
?>