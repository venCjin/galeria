SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `galeria`;

USE `galeria`;

CREATE TABLE IF NOT EXISTS `albumy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tytul` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `data` date NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=41 ;

INSERT INTO `albumy` (`id`, `tytul`, `data`, `id_uzytkownika`) VALUES
(1, 'Numery', '2016-09-10', 1),
(2, 'Gry', '2016-10-10', 2),
(3, 'Zeszyty', '2016-10-31', 8),
(4, 'LOREMGIPSUM_DOLORXSITDAMETDDCONSECTETURFFDIPISCING0ELIT.<>VESTIBULUMLUCTUSLSAPIEN7ACMENIMMCRAMAMET.M', '2016-11-07', 2),
(36, 'jeszcze jeden#!@#$%^&amp;*()_&lt;:&gt;}?', '2016-11-23', 8),
(38, 'Album admina', '2016-11-28', 1),
(39, 'ja', '2016-12-15', 11),
(40, '&quot;''Welcome''&quot;', '2016-12-15', 13);

CREATE TABLE IF NOT EXISTS `uzytkownicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_polish_ci NOT NULL,
  `zarejestrowany` date NOT NULL,
  `uprawnienia` enum('uzytkownik','moderator','administrator') COLLATE utf8_polish_ci NOT NULL,
  `aktywny` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=19 ;

INSERT INTO `uzytkownicy` (`id`, `login`, `haslo`, `email`, `zarejestrowany`, `uprawnienia`, `aktywny`) VALUES
(1, 'admin', 'e64b78fc3bc91bcbc7dc232ba8ec59e0', 'admin@email.com', '2016-09-09', 'administrator', 1),
(2, 'mod', 'ad148a3ca8bd0ef3b48c52454c493ec5', 'mod@mail.com', '2016-09-09', 'moderator', 1),
(8, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@user.com', '2016-11-11', 'uzytkownik', 1),
(11, 'suchy26', 'b144ef4a51d09eb8878c77bdc4ee8e6e', 'sajdndjk@dws.pl', '2016-12-15', 'uzytkownik', 1),
(12, 'Damik34', 'b87518a0a50ebca721049bfa97ec5804', 'xdxdxd@xd.xd', '2016-12-15', 'uzytkownik', 1),
(13, 'Użyszkodnik', '6a2c42a912526ae7f5f0b165b2abac35', 'wel.come@w.pl', '2016-12-15', 'uzytkownik', 1),
(15, 'MagicznyCwelu', '7ea27371fe8eb9eda89ae3a5f889ce8e', 'xD@tlen.pl', '2016-12-15', 'uzytkownik', 1),
(17, 'cotoasdA', '621cc0b403f184ac53bae5217d6e3c05', 'xD@xD.pl', '2016-12-15', 'uzytkownik', 1),
(18, 'afroneta', '6e725742b2f7c32a71d0cacd510fc883', 'tenshi15@o2.pl', '2016-12-18', 'uzytkownik', 1);

CREATE TABLE IF NOT EXISTS `zadjecia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tytul` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `id_albumu` int(11) NOT NULL,
  `data` date NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `zaakceptowane` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=35 ;

INSERT INTO `zadjecia` (`id`, `tytul`, `id_albumu`, `data`, `id_uzytkownika`, `zaakceptowane`) VALUES
(1, 'Jedynka', 1, '2016-09-10', 1, 1),
(2, 'Dwójka', 1, '2016-09-10', 1, 1),
(3, 'Trójka', 1, '2016-09-10', 1, 1),
(4, 'Czwórka', 1, '2016-09-10', 1, 1),
(5, 'Piątka', 1, '2016-09-10', 1, 1),
(6, 'Szóstka', 1, '2016-09-10', 1, 1),
(7, 'Siódemka', 1, '2016-09-10', 1, 1),
(8, 'Ósemka', 1, '2016-09-10', 1, 1),
(9, 'Dziewiątka', 1, '2016-09-10', 1, 1),
(10, 'Wiedźmak', 2, '2016-09-30', 2, 1),
(11, 'GTA V', 2, '2016-10-10', 2, 1),
(12, 'zdj2', 3, '2016-10-31', 8, 1),
(13, 'zdj1', 3, '2016-10-31', 8, 1),
(15, 'aaa', 4, '2016-11-07', 2, 1),
(16, 'bbb', 4, '2016-11-07', 2, 1),
(17, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam molestie enim at lectus mattis commodo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam pharetra non justo ac euismod. Pellentesque leo amet.', 4, '2016-11-07', 2, 1),
(23, 'h1', 37, '2016-11-23', 8, 1),
(24, '', 37, '2016-11-23', 8, 0),
(25, '', 4, '2016-11-24', 2, 1),
(26, 'wave', 4, '2016-11-24', 2, 0),
(27, 'Ważne', 38, '2016-11-28', 1, 0),
(29, 'bubles', 38, '0000-00-00', 1, 0),
(32, 'wer', 38, '2016-12-15', 1, 1),
(34, 'Opis', 40, '2016-12-15', 13, 1);

CREATE TABLE IF NOT EXISTS `zadjecia_komentarze` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_zadjecia` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `data` date NOT NULL,
  `komentarz` text COLLATE utf8_polish_ci NOT NULL,
  `zaakceptowany` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=8 ;

INSERT INTO `zadjecia_komentarze` (`id`, `id_zadjecia`, `id_uzytkownika`, `data`, `komentarz`, `zaakceptowany`) VALUES
(1, 10, 1, '2016-11-26', 'Super!', 1),
(2, 10, 8, '2016-11-26', 'Mi również się podoba :)', 1),
(3, 10, 10, '2016-11-27', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque in condimentum tellus. Fusce posuere ultricies mi a aliquam. Duis nec bibendum massa. Donec posuere tempor libero, iaculis gravida felis tempor id. Maecenas ligula libero, efficitur eu feugiat eget, scelerisque id mi. Etiam eget condimentum metus. Quisque suscipit, magna ac efficitur faucibus, justo magna bibendum urna, et tincidunt purus dui sit amet arcu. Morbi cursus ligula a commodo laoreet. Donec interdum leo sem, a lacinia diam sagittis sit amet. In lorem augue, tincidunt non nunc quis, mattis hendrerit nisl. Nam semper, quam nec commodo tincidunt, ligula velit varius nisi, non eleifend leo lorem eget ligula.', 1),
(4, 11, 1, '2016-11-28', 'Ble ble ble ...', 1),
(5, 34, 13, '2016-12-15', 'Ładne foto.', 1),
(6, 34, 17, '2016-12-15', 'xD', 1),
(7, 15, 1, '2016-12-16', 'https://github.com/venCjin/galeria', 1);

CREATE TABLE IF NOT EXISTS `zadjecia_oceny` (
  `id_zadjecia` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `ocena` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `zadjecia_oceny` (`id_zadjecia`, `id_uzytkownika`, `ocena`) VALUES
(10, 5, 7),
(10, 1, 10),
(10, 2, 10),
(10, 8, 9),
(10, 10, 1),
(11, 1, 7),
(17, 2, 9),
(30, 11, 10),
(31, 11, 9),
(34, 13, 9),
(32, 13, 10),
(34, 16, 10),
(34, 19, 9),
(34, 20, 9),
(34, 23, 10),
(32, 19, 5);