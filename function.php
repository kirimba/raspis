<?php
/**
 * @param $string
 * @return string
 */
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
/**
 * @param $num
 * @return string
 */
function day($num){//--------------------------День недели буквами
	switch ($num){
    			case 0:
	        		$day = "Воскресенье";
	        		break;
    			case 1:
			        $day = "Понедельник";
			        break;
			    case 2:
			        $day = "Вторник";
			    	break;
			    case 3:
	        		$day = "Среда";
	        		break;
    			case 4:
			        $day = "Четверг";
			        break;
			    case 5:
			        $day = "Пятница";
			        break;
			    case 6:
			        $day = "Суббота";
			        break;
                default:
                    $day = "Неверные данные";
			    }
	return $day;
}//------------------------------------------------День недели буквами

/**
 * @param $num
 * @return string
 */
function name_monthes($num){//--------------------------Месяц буквами
$monthes= array(
1 => 'Января', 2 => 'Февраля', 3 => 'Марта', 4 => 'Апреля',
5 => 'Мая', 6 => 'Июня', 7 => 'Июля', 8 => 'Августа',
9 => 'Сентября', 10 => 'Октября', 11 => 'Ноября', 12 => 'Декабря'
);
 return $monthes[$num];
}//------------------------------------------------Месяц буквами

/**
 * @param $mysqli
 * @return string
 */
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
			$list_grups .= insert_template("list_group_list", $mas_name, "list_group");
		}
	}
	return $list_grups;
}

/**
 * @param $name
 * @param $mas
 * @param string $categor
 * @return string
 */
function insert_template($name, $mas, $categor=""){
	if($categor != "")
		$categor = "/".$categor."/";
	$body = file_get_contents("template/".$categor.$name.".htm");
	return strtr($body, $mas);
}

/**
 * @param $mysqli
 * @param $group_id
 * @return string
 */
function show_raspisanie_on_edit($mysqli, $group_id){
    $categoria = "raspisanie";
    if($rez = $mysqli->query("SELECT * FROM raspis WHERE id_grup = $group_id ORDER BY `para` ASC")) {
        $list3 = array();
        if (($rez->num_rows) > 0) {
            while ($result = $rez->fetch_assoc()) {
                $prepod = str_replace('<span' ,'<span data-toggle="tooltip"', $result['prepod']);
                $list4 = array(
                    '{id}'      => $result['para'],
                    '{time}'    => $result['time'],
                    '{name}'    => $result['name'],
                    '{type}'    => $result['type'],
                    '{auditor}' => $result['auditor'],
                    '{prepod}'  => $prepod,
                    '{weeks}'  => $result['weeks'],
                );
                $list3[$result['den']] .= insert_template("para", $list4, $categoria);
            }
        }
    }
    for($i=0; $i<7; $i++) {
        if (!empty($list3[$i])) {
            $list2[$i] = array("{list_pars}" => $list3[$i]);
        } else {
            $list2[$i] = array("{list_pars}" => insert_template("no_par", array(), $categoria));
        }
    }
    $list1 = array(
        '{monday}'      => insert_template("day", $list2[1], $categoria),
        '{tuesday}'     => insert_template("day", $list2[2], $categoria),
        '{wednesday}'   => insert_template("day", $list2[3], $categoria),
        '{thursday}'    => insert_template("day", $list2[4], $categoria),
        '{friday}'      => insert_template("day", $list2[5], $categoria),
        '{saturday}'    => insert_template("day", $list2[6], $categoria),
        '{sunday}'      => insert_template("day", $list2[0], $categoria)
    );
    $list = insert_template("list_raspisanie", $list1, $categoria);
    return $list;
}

/**
 * @param $textLog
 */
function log_in_file($textLog){
    $file = './logAll.txt';
    $text = '[' . date('Y-m-d H:i:s') . '] := '; //Добавим актуальную дату
    $text .= $textLog."\n";//Выводим переданную переменную
    file_put_contents($file, $text, FILE_APPEND);
}
?>