<?php
require("config.php");

if($mysqli->query("CREATE TABLE `grups` (
  `id_grup` int(10) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `start` int(15) NOT NULL,
  `last-apdata` text COLLATE utf8_unicode_ci NOT NULL,
  `pin` int(5) NOT NULL DEFAULT '1111',
  `time-start-par` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"))
	echo "<p>Таблица grups создана</p>";
else
	echo "<p>Ошибка созлания grups</p>";
if($mysqli->query("CREATE TABLE `raspis` (
  `id` int(10) NOT NULL,
  `id_grup` int(10) NOT NULL,
  `time` varchar(15) NOT NULL,
  `para` varchar(5) NOT NULL,
  `den` int(1) NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `weeks` varchar(100) NOT NULL,
  `auditor` varchar(100) NOT NULL,
  `prepod` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;"))
	echo "<p>Таблица raspis создана</p>";
else
	echo "<p>Ошибка созлания raspis</p>";
$mysqli->close();
?>