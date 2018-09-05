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
		while($result = $rez->fetch_assoc()){
			$list_grups = $list_grups.'<tr><td>'.$result['id_grup'].'</td><td id="group_name_'.$result['id_grup'].'">'.$result['name'].'</td>';
			$list_grups = $list_grups.'<td>'.$result['start'].'</td><td>'.$result['last-apdata'].'</td><td>'.$result['pin'].'</td>';
			$list_grups = $list_grups.'<td class="text-center" style="padding: 3.5px 8px;"><div class="btn-group" style="width:100%;"><button type="button" class="btn btn-default btn-sm" style="width:50%;"><span class="glyphicon glyphicon-edit"></span></button><button type="button" class="btn btn-default btn-sm" style="width:50%;" onclick="dell_group('.$result['id_grup'].','.$result['pin'].')"><span class="glyphicon glyphicon-remove"></span></button></div></td></tr>';
		}
	}
	return $list_grups;
}
?>