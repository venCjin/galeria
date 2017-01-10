<?php
	$_SESSION["errors"] = NULL;

	if ($_POST)
		{
			$login = $db->real_escape_string(htmlspecialchars(trim(strip_tags($_POST['login']))));

			$password = $_POST['password'];
			$passwordVerify = $_POST['password_v'];

			$email = $db->real_escape_string(htmlspecialchars(trim(strip_tags($_POST['email']))));
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);

			$checkLogin = $db->query("SELECT COUNT(*) FROM uzytkownicy WHERE login = '$login'")->fetch_row();

			$errors = array();
			if (empty($login) || empty($email) || empty($password) || empty($passwordVerify))
				{
					$errors[] = 'Proszę wypełnić wszystkie pola';
				}

			if (!preg_match('/^[a-ząęóśłżźćńA-ZĄĘÓŚŁŻŹĆŃ0-9]/', $login))
				{
					$errors[] = 'Podany login nie skłąda się wyłącznie z liter i cyfr';
				}

			if ((strlen($login) < 6) OR (strlen($login) > 20))
				{
					$errors[] = 'Login ma mieć długość 6-20 znaków';
				}

			if (!preg_match('/[a-z]/', $password))
				{
					$errors[] = 'Podane hasło nie zawiera przynajmniej jednej małej litery';
				}

			if (!preg_match('/[A-Z]/', $password))
				{
					$errors[] = 'Podane hasło nie zawiera przynajmniej jednej wielkiej litery';
				}

			if (!preg_match('/[0-9]/', $password))
				{
					$errors[] = 'Podane hasło nie zawiera przynajmniej jednej cyfry';
				}

			if ((strlen($password) < 6) OR (strlen($password) > 20))
				{
					$errors[] = 'Hasło  ma mieć długość 6-20 znaków';
				}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$errors[] = 'Podany adres e-mail jest niepoprawny';
				}

			if ($checkLogin[0] > 0)
				{
					$errors[] = 'Ten login jest już zajęty';
				}

			if ($password != $passwordVerify)
				{
					$errors[] = 'Podane hasła się nie zgadzają';
				}

			if (!empty($errors))
				{
					$_SESSION["errors"] = $errors;

					header("Location: index.php?userLogin=$login&userEmail=$email");
				}
			else
				{
					$password = md5($password);

					$result = $db->query("INSERT INTO uzytkownicy (login, email, haslo, zarejestrowany, uprawnienia, aktywny) VALUES('$login', '$email', '$password', CURRENT_DATE, 'uzytkownik', 1)");

					if (!$result)
						{
							$errors[] = "Wystąpił błąd przy rejestrowaniu użytkownika.<br>Opis błędu: " . $db->error;
							$_SESSION["errors"] = $errors;
							header("Location: index.php?userLogin=$login&userEmail=$email");
						}
					else
						{
							$auth = $db->query("SELECT * FROM uzytkownicy WHERE login = '$login' AND haslo = '$password'")->fetch_assoc();
							$_SESSION["userData"] = $auth;

							header("Location: index.php?strona=rejestracja-ok");
						}
				}
		}
?>