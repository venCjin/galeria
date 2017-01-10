<!DOCTYPE html>
<html>

	<head>
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
	<link rel="icon" href="img/favicon.ico" type="image/x-icon"/>
		<title>GALERIA - Suchiński</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
		<link rel="stylesheet" type="text/css" href="css/jbootstrap.css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
		<!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
		<![endif]-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik&amp;subset=latin-ext"/>
		<script src="js/jquery-3.1.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
	</head>

<body>

	<?php
		require 'conn.php';

		if(isset($_GET["logout"]))
		{
			session_destroy();
			session_start();
		}		

		if (isset($_SESSION["userData"]["login"]))
		echo '<header>Witaj, <b>'.$_SESSION["userData"]["login"].'</b>!</header>';
		include 'nav.php';
	?>

	<section>
		<?php
			if (@$_GET['strona']!='dodaj-foto') unset($_SESSION["id_albumu"]);
			if (isset($_GET['strona'])) include_once $_GET['strona'] . '.php';
			else include_once 'reg-log.php';
			if (@$_GET['strona']!='foto' && @$_GET['strona']!='album') unset($_SESSION['pg_a']);
			if (@$_GET['strona']!='foto' && @$_GET['strona']!='album' && @$_GET['strona']!='galeria') unset($_SESSION['pg_g']);
			
			//echo '<video src="http://i1.kwejk.pl/k/obrazki/2017/01/2f5d9b28b0c8262fc6838bd330931530.mp4" autoplay="" loop=""><source src="http://i1.kwejk.pl/k/obrazki/2017/01/2f5d9b28b0c8262fc6838bd330931530.mp4" type="video/mp4"></video>';
		?>
		<div style="clear:both;"></div>
		
	</section>

	<footer>Jarosław Suchiński 4Ta</footer>

</body>
</html>