<?php
require("config.php");
require("code.php");
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Расписание</title>
    <link href="/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
    <!-- Bootstrap -->
    <link href="css/jtsage-datebox.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="css/new.css?ver=4" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style="height: 100%;">
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <button id="inputSerchDay2" type="button" style="padding:7px 14px 5px 14px;" class="navbar-toggle">
          	<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
          </button>
          <a class="navbar-brand" href="/">Расписание <?=$name_grup?></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li<?php if($active_vibor)echo' class="active"'?>><a href="/?p">Выбрать группу</a></li>
            <li<?php if($active_day)echo' class="active"'?>><a href="/">На день</a></li>
            <li<?php if($active_week)echo' class="active"'?>><a href="/?page=week">На всю неделю</a></li>
            <li id="hide_mob"><a href="#" onclick="monthd()" >Месяц цифрами <?php if($montsb) echo "ON"; else echo "OFF";?></a></li>
            <li class="dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Еще <b class="caret"></b></a>
          		<ul class="dropdown-menu">
            		<li><a href="#" data-toggle="modal" data-target="#add_grup_modal">Добавить группу</a></li>
            		<li class="divider"></li>
            		<li><a href="#" data-toggle="modal" data-target="#add_pin_modal">Доступ к редактированию</a></li>
            		<li class="divider"></li>
            		<li><a href="#" data-toggle="modal" data-target="#edit_time_modal">Редактировать время</a></li>
            		<li id="hide_pc" class="divider"></li>
            		<li id="hide_pc"><a href="#" onclick="monthd()" >Месяц цифрами <?php if($montsb) echo "ON"; else echo "OFF";?></a></li>
            		<?php
            		if(isset($pin) && ($_COOKIE['pin'.$id_grup] == $pin)){
            		echo '<li class="divider"></li>
            		<li><a href="#" data-toggle="modal" data-target="#add_par_modal">Добавить пару</a></li>';
            		//<li><a href="/?page=add-par">Добавить пару</a></li>';
            		//<li class="disabled"><a href="/?page=edit-par">Редактировать пары</a></li>';
            		//<li><a href="/?page=allow-edit-par" add-pin_modal>Доступ к редактированию</a></li>;
            		//<li><a href="/?page=add-grup">Добавить группу</a></li>;
            		//<li><a href="/?page=add-par-bonch">Добавление пар Бонч</a></li>';
            		}
            		if($_SESSION['mast']){
            			echo '<li class="divider"></li>
            			<li><a href="#" data-toggle="modal" data-target="#add_par_bonch_modal">Добавление пар Бонч</a></li>';
            		}
            		if((isset($pin) && ($_COOKIE['pin'.$id_grup] == $pin)) or ($_SESSION['mast'])){
            			echo '<li class="divider"></li>
            			<li><a href="/?page=edit-par">Редактировать пары</a></li>';
            		}
            		if(isset($last_update_raspis)){
            			echo '<li class="divider"></li>';
            			echo '<li><p class="navbar-te">Последнее обновление ';
            			echo $last_update_raspis;
            			echo '</p></li>';
            		}
            		?>
          		</ul>
        	</li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          	<li>
          	  <div id="inputSerchDayform" class="navbar-form" role="search">
								<div class="form-group">
									<input type="text" id="inputSerchDay" class="form-control" placeholder="yyyy-mm-dd">
								</div>
								<button type="submit" onclick="serch_day()" class="btn btn-default">Перейти</button>
							</div>
          	</li>
        	<li>
        		<a style="padding-top: 10px; padding-bottom: 10px" href="#"><!-- HotLog -->
					<span id="hotlog_counter"></span>
					<span id="hotlog_dyn"></span>
					<script type="text/javascript"> var hot_s = document.createElement('script');
					hot_s.type = 'text/javascript'; hot_s.async = true;
					hot_s.src = 'http://js.hotlog.ru/dcounter/2546330.js';
					hot_d = document.getElementById('hotlog_dyn');
					hot_d.appendChild(hot_s);
					</script>
					<noscript>
					<a href="http://click.hotlog.ru/?2546330" target="_blank">
					<img src="http://hit2.hotlog.ru/cgi-bin/hotlog/count?s=2546330&im=351" height="50px" width="50" border="0" 
					title="HotLog" alt="HotLog"></a>
					</noscript>
				</a><!-- /HotLog -->
			</li>
          </ul>
        </div><!--/.nav-collapse -->
    </div><!--Строка меню-->
    <div style="margin-top: 70px; height: 100%;" class="container">
	<?php
	if(isset($alert))
			echo $alert;
	?>
	<?php
	if(($_GET['page'] == 'edit-par') && ((isset($pin) && ($_COOKIE['pin'.$id_grup] == $pin)) or ($_SESSION['mast']))){
	?>
		<div class="alert alert-info"><!--Информация о дне, неделе, времени-->
			<div class="row text-center">
				<div class="col-md-6 col-xs-12"><h3 class="panel-title">Сегодня: <b><?=day($day_num)?></b></h3></div>
				<div class="col-md-6 col-xs-12"><h3 class="panel-title">Время: <b id="clock"><?=date('G:i:s',(time()+60*60*3))?></b></h3></div>
			</div>
		</div><!--Информация о дне, неделе, времени-->
	<?php
		echo $list_grups;
	}
	else{
		if((!isset($_COOKIE['id'])) or $vibr_grup){ //Выбор группы
	    	if($rez = $mysqli->query( "SELECT * FROM grups")){
			?>
	    	<table width="100%">
				<tr><td valign="center">
			    	<div align="center">
						<div class="page-header"><h1>Привет</h1></div>
				        <p>Выбери свою группу.</p>
						<div class="btn-group">
							<button style="width: 150px;" type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown">Выбери <span class="caret"></span></button>
							<ul style="min-width: 100px; width: 150px; text-align: center;" class="dropdown-menu" role="menu">
							<?php while($result = $rez->fetch_assoc()){ echo '<li><a style="white-space: normal; word-wrap: break-word;" href="/?id='.$result['id_grup'].'">'.$result['name'].'</a></li>'; } ?>
							</ul>
						</div>
					</div>
				</td></tr>
			</table>
			<?php
			$rez->free(); 
			}else
				echo'<div class="alert alert-danger">Ошибка запроса</div>';
		}else{
		?>
			<div class="alert alert-info"><!--Информация о дне, неделе, времени-->
				<div class="row text-center">
				<div class="col-md-4 col-xs-12"><h3 class="panel-title">Сегодня: <b><?=day($day_num)?></b></h3></div>
				<div class="col-md-4 col-xs-6"><h3 class="panel-title">Идет <b><?=$week?></b> неделя.</h3></div>
				<div class="col-md-3 col-xs-6"><h3 class="panel-title">Время: <b id="clock"><?=date('G:i:s',(time()+60*60*3))?></b></h3></div>
				</div>
			</div><!--Информация о дне, неделе, времени-->

			<?php
			if(!isset($error1)){
				if(isset($alert2))
				echo $alert2;

				if($_GET['page'] == 'week'){
					?>
					<ul class="pager">
			  			<li class="previous"><a href="/?page=week&num=<?=$week_all-1?>">&larr; Предыдущая</a></li>
			  			<li class="next"><a href="/?page=week&num=<?=$week_all+1?>">Следующая &rarr;</a></li>
					</ul><!--Вывод расписания на всю неделю-->
					
					<?php
					if(!isset($error2)){
						echo '<div class="row">';
						for($num_day=1; $num_day<=6; $num_day++){
							if($week_all == $week && $num_day == $day_num)
								$co = 'style="background: #ffab60;"';
							else
								$co = '';
						?>
						<div class="col-md-4 col-xs-12" >
							<div <?=$co?> class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title" style="float: right;"><b><?=$week_all?></b> неделя</h3>
									<h3 class="panel-title"><?=day($num_day)?> (<b>
										<?php
										if($montsb)
											echo date("d.m", strtotime("+ ".($num_day-1)." day", $week_s_nach1));
										else
											echo date("d ".name_monthes(date("n", strtotime("+ ".($num_day-1)." day", $week_s_nach1))), strtotime("+ ".($num_day-1)." day", $week_s_nach1));
										?></b>)</h3>
								</div>
								<table class="table table-bordered">
									<thead>
										<tr class="btop bleft bbottom bright">
											<th class="text-center">№</th>
											<th class="text-center">ауд.</th>
											<th class="text-center">Преподаватель</th>
										</tr>
									</thead>
									<tbody class="text-center">
										<?php
										if(isset($list_par[$num_day][1])){
											foreach ($list_par[$num_day] as $value11)
												echo $value11;
										}else
											echo '<tr class="bbottom bright bleft"><td colspan="3"><h2 class="text-center">Пар нет!</h2></td></tr>';
										?>
									</tbody>
								</table>
							<!--Вывод расписания на всю неделю-->
							</div>
						</div>
						<?php
						if($num_day == 3)
						echo'</div><div class="row">';
						}
						echo'</div>';
						unset($list_par);
					}//---------------------------Вывод всей недели
				}else{
					?>
					<ul class="pager"><!--Переключение дней-->
						<li class="previous"><a href="/?day=<?=$day_prev?>">&larr; Предыдущий</a></li>
						<li class="next"><a href="/?day=<?=$day_next?>">Следующий &rarr;</a></li>
					</ul><!--Переключение дней-->
					
					<div class="row"><!--Основной вывод расписания-->
						<div class="col-xs-12 col-md-4 col-md-offset-4">
							<div style="background: " class="panel panel-default">
								<div class="panel-heading">
										<h3 class="panel-title" style="float: right;"><b><?=$week_new?></b> неделя</h3>
						    		<h3 class="panel-title"><?=day($day_num_new)?> (<b><?php
										if($montsb)
											echo $data_11;
										else
											echo date("d ".name_monthes(date("n", $day_11)), $day_11);
										?></b>)</h3>
						  	</div>
								<table class="table table-bordered">
									<thead>
										<tr class="btop bleft bbottom bright">
											<th class="text-center">№</th>
											<th class="text-center">ауд.</th>
											<th class="text-center">Преподаватель</th>
										</tr>
									</thead>
									<tbody class="text-center">
									<?php
									if(isset($error2)){
										}elseif($num_par == 0){
											echo '<tr class="bbottom bright bleft"><td colspan="3"><h2 class="text-center">Пар нет!</h2></td></tr>';
										}else{
											foreach ($list_par as $value11) {
												echo $value11;
											}
										}
									?>
									</tbody>
								</table>
							</div>
						</div>
					</div><!--Основной вывод расписания-->
				    <?php
					unset($list_par);
		    	} //--------------------------------------------------------Основной вывод
	    	}
    	}
    }
    ?>
    </div><!-- /.container -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/jquery-ui-1.12.1.min.js"></script>
		<script src="js/jquery.mousewheel.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/jtsage-datebox.min.js"></script>
		<script src="js/jtsage-datebox.i18n.ru.utf8.min.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>
		<script src="js/bootstrap-datepicker.ru.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.cookie.js"></script>
		<script src="js/new.js?ver=7"></script>
		<?php include("modals.php"); ?>
  </body>
</html>
<?php
$mysqli->close();