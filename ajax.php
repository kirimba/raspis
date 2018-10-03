<?php
session_start();
require("config.php");
require("function.php");
$null = true;
if(isset($_POST['dell_group'])){
	if(isset($_POST['id']) && isset($_POST['pin'])){
		$id = htmlspecialchars($_POST['id']);
		$pin = htmlspecialchars($_POST['pin']);
		if($mysqli->query("DELETE FROM `grups` WHERE `id_grup`='$id' AND `pin`='$pin'")){
			if($mysqli->affected_rows == '1'){
				if($mysqli->query("DELETE FROM `raspis` WHERE `id_grup`='$id'")){
                    echo "Ok";
                    $null = false;
                }else{
                    echo "Ошибка 3";
                    $null = false;
                }
            }else {
                echo "Ошибка 2";
                $null = false;
            }
        }else {
            echo "Ошибка 1";
            $null = false;
        }
	}
}
if(isset($_POST['body_list_group'])){
	if(isset($_SESSION['mast']) && $_SESSION['mast'] == $maspar){
		echo "Ok".load_table_group($mysqli);
        $null = false;
	}else{
		echo "Ошибка -1";
        $null = false;
	}
}
if(isset($_POST['clear_group'])){
	if(isset($_POST['id']) && isset($_POST['pin'])){
		$id = htmlspecialchars($_POST['id']);
		$pin = htmlspecialchars($_POST['pin']);
		if($result_c = $mysqli->query("SELECT * FROM `grups` WHERE `id_grup`='$id' AND `pin`='$pin'")){
			if($result_c->num_rows == '1'){
				if($mysqli->query("DELETE FROM `raspis` WHERE `id_grup`='$id'")){
                    echo "Ok";
                    $null = false;
				}else{
                    echo "Ошибка 3";
                    $null = false;
                }
            }else {
                echo "Ошибка 2";
                $null = false;
            }
        }else {
            echo "Ошибка 1";
            $null = false;
        }
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
			if($result_c->num_rows == '1') {
                if ($mysqli->query("UPDATE `grups` SET `name`='$name',`start`='$date',`pin`='$pin' WHERE `id_grup`='$id'")){
                    echo "Ok";
                    $null = false;
                }
                else{
                    echo "Ошибка 3";
                    $null = false;
                }
			}else {
                echo "Ошибка 2";
                $null = false;
            }
		}else {
            echo "Ошибка 1";
            $null = false;
		}
	}
}
if(isset($_POST['myalert'])){
	if(isset($_POST['type']) && isset($_POST['text']) && isset($_POST['cla'])){
		$mas_name = array(
				'{type}'		=> htmlspecialchars($_POST['type']),
				'{text}'		=> $_POST['text'],
				'{class}'		=> $_POST['cla']
			);
        log_in_file($mas_name['{text}']);
		echo insert_template('alert1', $mas_name);
        $null = false;
	}
}
if(isset($_POST['raspisanie'])){
	if(isset($_POST['pas']) && isset($_POST['text'])){
		$pas = htmlspecialchars($_POST['pas']);
		if($pas == $maspar){
			echo "ок";
			$null = false;
		}
	}
}
if(isset($_POST['raspisanie_show'])){
    if(isset($_POST['id']) && (isset($_SESSION['mast']) && $_SESSION['mast'] == $maspar)){
        $id = htmlspecialchars($_POST['id']);
        $result = show_raspisanie_on_edit($mysqli, $id);
        if(substr($result, 0, 4) == "<div") {
            echo 'Ok' . $result;
            $null = false;
        }else {
            echo "Ошибка 1";
            $null = false;
        }
    }else {
        echo "Ощибка 2";
        $null = false;
    }
}
if(isset($_POST['add_par'])){ //------------------------------Добавление пары
    if(isset($_POST['name_par'], $_POST['type_par'], $_POST['num_par'], $_POST['day_par'], $_POST['aud_par'], $_POST['week_par'], $_POST['prepod_par1'], $_POST['prepod_par2'], $_POST['time_par1'], $_POST['time_par2'])) {

        if (isset($_COOKIE['id']) && (isset($_SESSION['mast']) && $_SESSION['mast'] == $maspar)) {
            $id_grup = htmlspecialchars($_COOKIE['id']);
            $flag = true;
        } elseif (isset($_COOKIE['id'])) {
            $flag = false;
            $id_grup = htmlspecialchars($_COOKIE['id']);
            if ($rez = $mysqli->query("SELECT pin FROM grups WHERE id_grup = $id_grup LIMIT 1")) {
                if (($rez->num_rows) == 1) {
                    $result = $rez->fetch_row();
                    $pin = $result[0];
                    $rez->free();
                    if (isset($_COOKIE['pin' . $id_grup]) && ($_COOKIE['pin' . $id_grup] == $pin)) {
                        $flag = true;
                    }
                }
            }
        } else {
            $flag = false;
        }
        if ($flag) {
            $name_par = htmlspecialchars($_POST['name_par']);
            $type_par = htmlspecialchars($_POST['type_par']);
            $num_par = htmlspecialchars($_POST['num_par']);
            $day_par = htmlspecialchars($_POST['day_par']);
            $week_par = htmlspecialchars($_POST['week_par']);
            $aud_par = htmlspecialchars($_POST['aud_par']);
            $prepod_par1 = htmlspecialchars($_POST['prepod_par1']);
            $prepod_par2 = htmlspecialchars($_POST['prepod_par2']);
            $time_par1 = htmlspecialchars($_POST['time_par1']);
            $time_par2 = htmlspecialchars($_POST['time_par2']);
            $time_par = '(' . $time_par1 . '-' . $time_par2 . ')';
            $prepod_par = '<span title="' . $prepod_par2 . '"><i>' . $prepod_par1 . '</i></span>';
            if ($mysqli->query("INSERT INTO `raspis` (`id_grup`, `time`, `para`, `den`, `name`, `type`, `weeks`, `auditor`, `prepod`) VALUES ('$id_grup', '$time_par', '$num_par', '$day_par', '$name_par', '$type_par', '$week_par', '$aud_par', '$prepod_par')")) {
                echo "Ok";
                $null = false;
            } else {
                echo "Ошибка добавления";
                $null = false;
            }
        } else {
            echo "Ошибка доступа";
            $null = false;
        }
    }
}//------------------------------Добавление пары
if($null)
echo "--Ошибка--";
?>