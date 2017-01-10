<?php
	error_reporting(0);
	session_start();
	
	/* CONN */
	global $db;
	$db = new mysqli('127.0.0.1', 'root', '', 'galeria');

	//BŁĄD POŁĄCZENIA Z BAZĄ DANYCH
	if ($db->connect_errno)
	{
		die ("<p class='error'>Nie udało się połączyć z bazą danych.<br>Błąd połączenia nr: " . $db->connect_errno . "<br>Opis błędu: " . $db->connect_error . "</p>");
	}

	$db->query('SET NAMES utf8');
	$db->query('SET CHARACTER SET utf8');
	$db->query("SET collation_connection = utf8_polish_ci");
?>