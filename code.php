<?php
session_start();
if(isset($_GET['id'])){//-------------------------Куки id и названия группы
	$id = htmlspecialchars($_GET['id']);
	setcookie( "id", $id, time()+(60*60*24*30), '/');
	header("Location:/");
}//-----------------------------------------------Куки id и названия группы
elseif(isset($_COOKIE['id'])){//-----------Куки id группы
	$id = htmlspecialchars($_COOKIE['id']);
	setcookie( "id", $id, time()+(60*60*24*30), '/');
}//----------------------------------------Куки id группы
if(isset($_POST['pingrup'])){//-------------Пин группы в куки
	$pin = htmlspecialchars($_POST['pingrup']);
	if($pin == $maspar){
		$_SESSION['mast'] = TRUE;	
	}elseif(isset($_COOKIE['id'])){
		$pin1 = 'pin'.$_COOKIE['id'];
		setcookie( $pin1, $pin, time()+(60*60*24), '/');
	}
	unset($pin, $pin1);
	header("Location:/");
}//-----------------------------------------Пин группы в куки
if(isset($_GET['p'])){//---------------------------Выбор группы
	$vibr_grup = true;
}//------------------------------------------------Выбор группы

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

if(isset($_POST['name-grup'], $_POST['data-tart-grup'], $_POST['pin-grup'])){ //----Добаление группы
	$name_grup = htmlspecialchars($_POST['name-grup']);
	$data_start = htmlspecialchars($_POST['data-tart-grup']);
	$pin_grup = (int)htmlspecialchars($_POST['pin-grup']);
	$data_start1 = explode('-', $data_start);
	$data_start = mktime(0,0,0,$data_start1['1'],$data_start1['2'], $data_start1['0']);
	if($mysqli->query("INSERT INTO `grups` (`name`, `start`, `pin`) VALUES ('$name_grup', '$data_start', '$pin_grup')"))
	$alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Группа добавлена</div>';
	else
	$alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ошибка добавления</div>';
}//-------------------------Добаление группы

if($_SESSION['mast']){//Добавление группы и пар из Бонч
	if(isset($_POST['data-tart-grup'], $_POST['pin-grup'])){
		$time11 = strtotime('+ 3 hour');
		$data11 = date("d.m.Y H:i", $time11);
		
		// проверяем, что файл загружался
	  if(isset($_FILES['file-grup']) && $_FILES['file-grup']['error'] != 4)
	  {
	    // проверяем, что файл загрузился без ошибок
		if($_FILES['file-grup']['error'] != 1 && $_FILES['file-grup']['error'] != 0)
		{
		  $error = $_FILES['file-grup']['error'];
		  //$alert = '<div class="alert alert-danger">Ошибка: Файл не загружен. Код ошибки: '.$error.'</div>';
		  $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ошибка: Файл не загружен.</div>';
		}
		else
	    {
	      // файл загружен на сервер

	      // проверяем файл на максимальный размер
		  $filesize = $_FILES['file-grup']['size'];
		  if($_FILES['file-grup']['error'] == 1 || ($filesize < 1024*1024*30 && $filesize > 1024*1024*10))
		  {
		   	//$filesize = ($filesize != 0)? sprintf('(%.2f Кб)' , $filesize / 1024): '';
		   	//$alert = '<div class="alert alert-danger">Ошибка: Размер прикреплённого файла '. $filesize.' больше допустимого (3 Мб).</div>';
		   	$alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ошибка: Размер прикреплённого файла не соответствует ожиданию.</div>';
		  }
		  else
		  {
		   	$filepath = $_FILES['file-grup']['tmp_name'];
		   	$filetype = $_FILES['file-grup']['type'];
		   	if($filetype != null && $filetype != '' && $filetype == 'text/html'){
				$file = file($filepath);
				foreach($file as $stro){
					$pos = strpos($stro, '<tr>');
					if(!($pos === FALSE)){
						$pos = stristr($stro, '<tr>');
						$pos = substr($pos, 0, strpos($pos, '</tbody>'));
						$pos = iconv("cp1251", "utf-8", $pos);
						$name_grup = htmlspecialchars($_POST['name-grup']);
						$gruptra = rus2translit($name_grup);
						//$alert = '<table  border="1"><tbody>'.$pos.'</tbody></table>';
						file_put_contents('raspisanie/'.$gruptra.' '.$data11.'.txt', $pos);
						
						$data_start = htmlspecialchars($_POST['data-tart-grup']);
						$pin_grup = (int)htmlspecialchars($_POST['pin-grup']);
						$data_start1 = explode('-', $data_start);
						$data_start = mktime(0,0,0,$data_start1['1'],$data_start1['2'], $data_start1['0']);
						if($mysqli->query("INSERT INTO `grups` (`name`, `start`, `pin`) VALUES ('$name_grup', '$data_start', '$pin_grup')")){
							$alert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Группа добавлена</div>';
							$id_grup = (string)$mysqli->insert_id;
							require("upload_raspis.php");
						}else
						$alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ошибка добавления</div>';
					}
				}
				
			}else{
				$alert = $alert.'<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ошибка: Что ты тут загружаешь?</div>';
			}
		  }
		}
	  }
	}
}//----------------Добавление группы и пар из Бонч

$active_day=false;
$active_week=false;    //активные кнопки меню
$active_vibor=true;

if(!((!isset($_COOKIE['id'])) or $vibr_grup)){ //после Выбор группы
	$active_vibor=false;
	$id_grup = htmlspecialchars($_COOKIE['id']);
	if($rez = $mysqli->query("SELECT * FROM grups WHERE id_grup = $id_grup LIMIT 1")){
		if(($rez->num_rows) == 1){
			while($result = $rez->fetch_assoc()){
				$name_grup = $result['name'];
				$start_grup = $result['start'];
				$last_update_raspis = $result['last-apdata'];
				$time_start_par = explode(" ", $result['time-start-par']);
				$pin = $result['pin'];
			}
			$rez->free();
			$week = (int)((date('z',(time()+60*60*3)) - date('z',$start_grup))/7)+1;
			$day_num = date('w',(time()+60*60*3));
			//$week = 13;
			//$day_num = 2;
			
			if(isset($pin) and ($_COOKIE['pin'.$id_grup] == $pin)){ //------------------------------Добавление пары
				if(isset($_POST['name-par'], $_POST['type-par'], $_POST['num-par'], $_POST['day-par'], $_POST['aud-par'], $_POST['week-par'], $_POST['prepod-par1'], $_POST['time-par1'], $_POST['time-par2']))
				{
				$name_par = htmlspecialchars($_POST['name-par']);
				$type_par = htmlspecialchars($_POST['type-par']);
				$num_par = htmlspecialchars($_POST['num-par']);
				$day_par = htmlspecialchars($_POST['day-par']);
				$week_par = htmlspecialchars($_POST['week-par']);
				$aud_par = htmlspecialchars($_POST['aud-par']);
				$prepod_par1 = htmlspecialchars($_POST['prepod-par1']);
				$prepod_par2 = htmlspecialchars($_POST['prepod-par2']);
				$time_par1 = htmlspecialchars($_POST['time-par1']);
				$time_par2 = htmlspecialchars($_POST['time-par2']);
				$time_par = '('.$time_par1.'-'.$time_par2.')';
				$prepod_par = '<span title="'.$prepod_par2.'"><i>'.$prepod_par1.'</i></span>';
				if($mysqli->query("INSERT INTO `raspis` (`id_grup`, `time`, `para`, `den`, `name`, `type`, `weeks`, `auditor`, `prepod`) VALUES ('$id_grup', '$time_par', '$num_par', '$day_par', '$name_par', '$type_par', '$week_par', '$aud_par', '$prepod_par')"))
				$alert2 = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Пара добавлена</div>';
				else
				$alert2 = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ошибка добавления</div>';
				}
			}//------------------------------Добавление пары

			if($_GET['page'] == 'week'){
				$active_week=true;
				if(isset($_GET['num']))
					$week_all = htmlspecialchars($_GET['num']);
				else
					$week_all = $week;
				for($i=1; $i<=6; $i++)
					$num_par[$i]=0;

				if($rez = $mysqli->query("SELECT * FROM raspis WHERE id_grup = $id_grup ORDER BY `para` ASC")){
					if(($rez->num_rows)>0){
						while($result = $rez->fetch_assoc()){
							$weeks = explode(", ", $result['weeks']);
							foreach($weeks as $week1){
								if($week1 == $week_all){
									$num_par[$result['den']]++;
									$result['time'] = $result['time']=="" ? $time_start_par[$result['para']-1] : $result['time'];
									$prepod = str_replace('<span' ,'<span data-toggle="tooltip"', $result['prepod']);
									$list_par[$result['den']][$num_par[$result['den']]] = '<tr class="bright bleft">
									<td rowspan="2" style="border-bottom: 2px solid #000000;"><b>'.$result['para'].'</b><br>'.$result['time'].'</td>
									<td colspan="2">'.$result['name'].' <span class="label label-default">'.$result['type'].'</span></td></tr>
									<tr class="bbottom bright"><td style="word-wrap: break-word;">'.$result['auditor'].'</td><td>'.$prepod.'</td></tr>';
									break;
								}
							}
						}
    				}else{
    					for($i=1; $i<=6; $i++)
    						$list_par[$i][1] = '<tr class="bbottom bright bleft"><td colspan="3"><h2 class="text-center">Пар нет!</h2></td></tr>';
    				}
    			}else{
    				$alert2 = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ошибка запроса расписания</div>';
					$error2 = FALSE;
				}
				$rez->free();
			}
			else{
				$active_day=true;
				if(isset($_GET['day'])){
					$day_11 = htmlspecialchars($_GET['day']);
					$week_new = (int)((date('z',(strtotime('+'.$day_11.' day')+60*60*3)) - date('z',$start_grup))/7)+1;
					$day_num_new = date('w',(strtotime('+'.$day_11.' day')+60*60*3));
					$data_11 = date("d.m",(strtotime('+'.$day_11.' day')+60*60*3));
				}else{
					$day_11 = 0;
					$week_new = $week;
					$day_num_new = $day_num;
				}

				if($rez = $mysqli->query("SELECT * FROM raspis WHERE id_grup = $id_grup AND den = $day_num_new ORDER BY `para` ASC")){
					if(($rez->num_rows)>0){
						$num_par = 0;
						while($result = $rez->fetch_assoc()){
							$weeks = explode(", ", $result['weeks']);
							foreach($weeks as $week1){
								if($week1 == $week_new){
									$num_par++;
									$result['time'] = $result['time']=="" ? $time_start_par[$result['para']-1] : $result['time'];
									$prepod = str_replace('<span' ,'<span data-toggle="tooltip"', $result['prepod']);
									$list_par[$num_par] = '<tr class="para_num_'.$num_par.' bright bleft">
									<td class="time_para" rowspan="2" style="border-bottom: 2px solid #000000;"><b>'.$result['para'].'</b><br>'.$result['time'].'</td>
									<td colspan="2">'.$result['name'].' <span class="label label-default">'.$result['type'].'</span></td></tr>
									<tr class="para_num_'.$num_par.' bbottom bright"><td style="word-wrap: break-word;">'.$result['auditor'].'</td><td>'.$prepod.'</td></tr>';
									break;
								}
							}
						}
					}else{
						$num_par = 0;
					}
				}else{
					$alert2 = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ошибка запроса расписания</div>';
					$error2 = FALSE;
				}
			}//--------------------------------------------------------Основной вывод
		}else{
			$alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Возможно ваша группа была удалена выберите из списка: <a href="/?p" class="alert-link">Выбрать</a></div>';
			$error1 = FALSE;
		}
	}else{
		$alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ошибка запроса группы</div>';
		$error1 = FALSE;
	}
}
//----------------------------------------------------Все с выбранной группой