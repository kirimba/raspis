<?php
session_start();
require("config.php");
require("function.php");
if(isset($_POST['dell_group'])){
	if(isset($_POST['id']) && isset($_POST['pin'])){
		$id = htmlspecialchars($_POST['id']);
		$pin = htmlspecialchars($_POST['pin']);
		if($mysqli->query("DELETE FROM `grups` WHERE `id_grup`='$id' AND `pin`='$pin'")){
			if($mysqli->query("DELETE FROM `raspis` WHERE `id_grup`='$id'")){
			echo "Ok";
		}else
			echo "Ошибка sql_2";
		}
		else
			echo "Ошибка sql_1";
	}
}
if(isset($_POST['bod_list_droup'])){
	if(isset($_SESSION['mast']) && $_SESSION['mast'] == $maspar){
		echo "Ok".load_table_group($mysqli);
	}else{
		echo "error";
	}
}
?>