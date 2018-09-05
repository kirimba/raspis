<?php
require("config.php");
if(isset($_POST['dell_group'])){
	if(isset($_POST['id']) && isset($_POST['pin'])){
		$id = htmlspecialchars($_POST['id']);
		$pin = htmlspecialchars($_POST['pin']);
		if($mysqli->query("DELETE FROM `grups` WHERE `id_grup`='$id' AND `pin`='$pin'")){
			echo "Ok";
		}
		else
			echo "Ошибка sql";
	}
}
?>