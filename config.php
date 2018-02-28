<?php
$cfg = array(
	'db_host' 			=> '', //Хост.
	'db_name'			=> '', //Имя.
	'db_user' 			=> '', //Имя юзера.
	'db_pass' 			=> '', //Пароль.
);
$maspar = "!1r2e3w4q!";
$mysqli = new mysqli($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name']);
if ($mysqli->connect_errno) {
	printf("Соединение не удалось");
exit();
}