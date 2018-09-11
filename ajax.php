<?php
session_start();
require("config.php");
require("function.php");
if(isset($_POST['dell_group'])){
	if(isset($_POST['id']) && isset($_POST['pin'])){
		$id = htmlspecialchars($_POST['id']);
		$pin = htmlspecialchars($_POST['pin']);
		if($mysqli->query("DELETE FROM `grups` WHERE `id_grup`='$id' AND `pin`='$pin'")){
			if($mysqli->affected_rows == '1'){
				if($mysqli->query("DELETE FROM `raspis` WHERE `id_grup`='$id'"))
					echo "Ok";
				else
					echo "Ошибка 3";
			}else
				echo "Ошибка 2";
		}else
			echo "Ошибка 1";
	}
}
if(isset($_POST['body_list_group'])){
	if(isset($_SESSION['mast']) && $_SESSION['mast'] == $maspar){
		echo "Ok".load_table_group($mysqli);
	}else{
		echo "Ошибка -1";
	}
}
if(isset($_POST['clear_group'])){
	if(isset($_POST['id']) && isset($_POST['pin'])){
		$id = htmlspecialchars($_POST['id']);
		$pin = htmlspecialchars($_POST['pin']);
		if($result_c = $mysqli->query("SELECT * FROM `grups` WHERE `id_grup`='$id' AND `pin`='$pin'")){
			if($result_c->num_rows == '1'){
				if($mysqli->query("DELETE FROM `raspis` WHERE `id_grup`='$id'"))
					echo "Ok";
				else
					echo "Ошибка 3";
			}else
				echo "Ошибка 2";
		}else
			echo "Ошибка 1";
	}
}
if(isset($_POST['edit_group'])){
	if(isset($_POST['id']) && isset($_POST['pin']) && isset($_POST['pin_old']) && isset($_POST['name']) && isset($_POST['date'])){
		$id = htmlspecialchars($_POST['id']);
		$pin = htmlspecialchars($_POST['pin']);
		$pin_old = htmlspecialchars($_POST['pin_old']);
		$name = htmlspecialchars($_POST['name']);
		$date = htmlspecialchars($_POST['date']);
		if($result_c = $mysqli->query("SELECT * FROM `grups` WHERE `id_grup`='$id' AND `pin`='$pin_old'")){
			if($result_c->num_rows == '1'){
				if($mysqli->query("UPDATE `grups` SET `name`='$name',`start`='$date',`pin`='$pin' WHERE `id_grup`='$id'"))
					echo "Ok";
				else
					echo "Ошибка 3";
			}else
				echo "Ошибка 2";
		}else
			echo "Ошибка 1";
	}
}
if(isset($_POST['myalert'])){
	if(isset($_POST['type']) && isset($_POST['text']) && isset($_POST['cla'])){
		$mas_name = array(
				'{type}'		=> htmlspecialchars($_POST['type']),
				'{text}'		=> $_POST['text'],
				'{class}'		=> $_POST['cla']
			);
		echo insert_template('alert1', $mas_name);
	}
}
?>