<h2>
	<b>Dodawanie zdjęć</b>
</h2>

Wybierz album do którego chcesz dodać zdjęcie:

<br>

<form method='POST' action='index.php?strona=dodaj-foto'>
	<!--xxx <select name='id_albumu' onchange="myFun(this.value)"> -->
	<div class="input-group folder">
	<select class="form-control folder" name='id_albumu' onchange="this.form.submit()">
		<?php
		$id_u = $_SESSION["userData"]["id"];
		if (isset($_POST["id_albumu"])) 
		{
			$_SESSION["id_albumu"] = $_POST["id_albumu"];
		}
		
		echo "<option selected='true' disabled='disabled'>---Wybierz album---</option>";

		$result = $db->query ("SELECT *
								FROM albumy
								WHERE id_uzytkownika='$id_u'
								ORDER BY tytul");

		while($row = $result->fetch_assoc())
		{
			if($_SESSION["id_albumu"]==$row["id"]) $selected = ' selected ';
			else $selected = ' ';
			echo "<option class='form-control folder'".$selected."value='".$row["id"]."'>".$row["tytul"]."</option>";
		}
		?>

	</select>
	</div>

</form>

<?php
	if (@isset($_GET['err']))
	{
		echo '<p class="error" style="width: 100%; text-align:center;"><i style="color: #EB3232;" class="fa fa-exclamation-circle" aria-hidden="true"></i> Nie udało się przesłać pliku</p>';
	}
?>

<br><br>Dodaj zdjęcie i opis(opcjonalny, nie dłuższy niż 100 znaków):

<form method='POST' enctype="multipart/form-data" action='upload.php'>

	<input type="hidden" name="id_albumu" <?php echo "value='".@$_SESSION["id_albumu"]."'"; ?>>

	<div class="input-group folder">
		<span class="input-group-addon"><i class="fa fa-font fa-fw" aria-hidden="true"></i></span>
		<input class="form-control folder" type="text" name="opis" maxlength="255" placeholder="Opis(opcjonalny)">
	</div>

	<div class="input-group margin-bottom-sm">
		<span class="input-group-addon"><i class="fa fa-file-image-o" aria-hidden="true"></i></span>
		<div class="form-control folder light"><input id="input_file" type="file" name="zdjecie" required></div>
	</div>

	<input type="submit" value="Wyślij!">

</form>

<br>
<!--xxx
<script>
function myFun(id)
{
	$.ajax(
	{
		url: 'xxx.php',
		data: {id_albumu: id},
		success: function(h)
		{
			$("#album").html(h)
		}
	})
}
</script>
-->
<?php
if (isset($_SESSION["id_albumu"]))
{
	$id_albumu = $_SESSION["id_albumu"];

	$result = $db->query ("SELECT *
							FROM zadjecia
							WHERE id_albumu='$id_albumu'
							ORDER BY id");

	$ile = $result->num_rows;

	if($ile)
	{
		echo "<div id='galeria'>";

		while($row = $result->fetch_assoc())
		{
			$id_zdjecia = $row['id'];
			echo "<a class='dymek'><img class='miniatura' src='img/$id_albumu/$id_zdjecia' width='180px' height='180px'></a>";
		}

		echo "<div style='clear: both;'></div></div>";
	}
}
?>