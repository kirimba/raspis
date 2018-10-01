<?php
function rus2translit($string) {//------функция транслита
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
} //-------------------------------------Функция транслита
function day($num111){//--------------------------День недели буквами
	switch ($num111){
    			case 0:
	        		$day111 = "Воскресенье";
	        		break;
    			case 1:
			        $day111 = "Понедельник";
			        break;
			    case 2:
			        $day111 = "Вторник";
			    	break;
			    case 3:
	        		$day111 = "Среда";
	        		break;
    			case 4:
			        $day111 = "Четверг";
			        break;
			    case 5:
			        $day111 = "Пятница";
			        break;
			    case 6:
			        $day111 = "Суббота";
			        break;
			    }
	return $day111;
}//------------------------------------------------День недели буквами

function name_monthes($num){//--------------------------Месяц буквами
$monthes= array(
1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
);
 return $monthes[$num];
}//------------------------------------------------Месяц буквами

function load_table_group($mysqli){
	if($rez = $mysqli->query( "SELECT * FROM grups")){
	    $list_grups = "";
		while($result = $rez->fetch_assoc()){
			$mas_name = array(
				'{start}'		=> date("d.m.Y",$result['start']),
				'{id_grup}'		=> $result['id_grup'],
				'{last-apdata}'	=> $result['last-apdata'],
				'{pin}'			=> $result['pin'],
				'{name}'		=> $result['name']
			);
			$list_grups = $list_grups.insert_template("list_group_list", $mas_name, "list_group");
		}
	}
	return $list_grups;
}

function insert_template($name, $mas, $categor=""){
	if($categor != "")
		$categor = "/".$categor."/";
	$body = file_get_contents("template/".$categor.$name.".htm");
	return strtr($body, $mas);
}

function show_raspisanie_on_edit($mysqli, $group_id){

    $list2['1'] = insert_template("para", array(), "raspisanie");
    if($group_id == '22')
        for ($i=0;$i<11;$i++ )
    $list2['1'] = $list2['1'].insert_template("para", array(), "raspisanie");
    $list2['1'] = array("{list_pars}"=>$list2['1']);
    $list2['2'] = array("{list_pars}"=>insert_template("para", array(), "raspisanie"));
    $list2['3'] = array("{list_pars}"=>insert_template("para", array(), "raspisanie"));
    $list2['4'] = array("{list_pars}"=>insert_template("para", array(), "raspisanie"));
    $list2['5'] = array("{list_pars}"=>insert_template("para", array(), "raspisanie"));
    $list2['6'] = array("{list_pars}"=>insert_template("para", array(), "raspisanie"));
    $list2['0'] = array("{list_pars}"=>insert_template("para", array(), "raspisanie"));
    $list1 = array(
        '{monday}'      => insert_template("day", $list2['1'], "raspisanie"),
        '{tuesday}'     => insert_template("day", $list2['2'], "raspisanie"),
        '{wednesday}'   => insert_template("day", $list2['3'], "raspisanie"),
        '{thursday}'    => insert_template("day", $list2['4'], "raspisanie"),
        '{friday}'      => insert_template("day", $list2['5'], "raspisanie"),
        '{saturday}'    => insert_template("day", $list2['6'], "raspisanie"),
        '{sunday}'      => insert_template("day", $list2['0'], "raspisanie")
    );
    $list = insert_template("list_raspisanie", $list1, "raspisanie");
    return $list;
}
function log_in_file($textLog){
    $file = './logAll.txt';
    $text = '[' . date('Y-m-d H:i:s') . '] := '; //Добавим актуальную дату
    $text .= $textLog."\n";//Выводим переданную переменную
    file_put_contents($file, $text, FILE_APPEND);
}
?>