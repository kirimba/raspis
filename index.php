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
    <link href="css/new.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Расписание <?=$name_grup?></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/?p">Выбрать группу</a></li>
            <li><a href="/?page=all-par">На всю неделю</a></li>
            <li class="dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Еще <b class="caret"></b></a>
          		<ul class="dropdown-menu">
            		<li><a href="#" data-toggle="modal" data-target="#add_grup_modal">Добавить группу</a></li>
            		<li class="divider"></li>
            		<li><a href="#" data-toggle="modal" data-target="#add_pin_modal">Доступ к редактированию</a></li>
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
            		}?>
          		</ul>
        	</li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
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
    <div style="margin-top: 70px;" class="container">
	<?php
	if(isset($alert))
			echo $alert;
	?>
	<?php
	if($_GET['page'] == 'add-grup'){}
	elseif($_GET['page'] == 'add-par-bonch'){}
	else{
		if((!isset($_COOKIE['id'])) or $vibr_grup){ //Выбор группы
	    	if($rez = $mysqli->query( "SELECT * FROM grups")){
			?>
	    	<table width=100%">
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

				if($_GET['page'] == 'all-par'){
					?>
					<div class="panel panel-info text-center">
						<div class="panel-heading">
							<h3 class="panel-title">Сейчас показана <b><?=$week_all?></b> неделя.</h3>
						</div>
					</div>
					<ul class="pager">
			  			<li class="previous"><a href="/?page=all-par&num=<?=$week_all-1?>">&larr; Предыдущая</a></li>
			  			<li class="next"><a href="/?page=all-par&num=<?=$week_all+1?>">Следующая &rarr;</a></li>
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
						    		<h3 class="panel-title"><?=day($num_day)?></h3>
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
					if(isset($_GET['day'])){
						if(htmlspecialchars($_GET['day']) != 0){
						?>
						<div class="alert alert-info">
							<div class="row text-center">
								<div class="col-md-4 col-xs-12"><h3 class="panel-title">Сейчас показана <b><?=$week_new?></b> неделя,</h3></div>
								<div class="col-md-4 col-xs-6"><h3 class="panel-title"><b><?=day($day_num_new)?></b></h3></div>
								<div class="col-md-3 col-xs-6"><h3 class="panel-title">Число: <b><?=$data_11?></b></h3></div>
							</div>
						</div>
						<?php
						}
					}
					?>
					<ul class="pager"><!--Переключение дней-->
						<li class="previous"><a href="/?day=<?=$day_11-1?>">&larr; Предыдущий</a></li>
						<li class="next"><a href="/?day=<?=$day_11+1?>">Следующий &rarr;</a></li>
					</ul><!--Переключение дней-->
					
					<div class="row"><!--Основной вывод расписания-->
						<div class="col-xs-12 col-md-4 col-md-offset-4">
							<div style="background: " class="panel panel-default">
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
    <!--Modals-->
	<?php
	if($_SESSION['mast']){
	?>
	<div class="modal fade" id="add_par_bonch_modal" tabindex="-1" role="dialog"><!--Добавление расписания Бонч-->
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Добавление расписания Бонч</h4>
			</div>
			<form enctype="multipart/form-data" role="form" name="add-par-bonch" method="post" action="/">
				<div class="modal-body">
					<p>Зайди на эту страницу: <a href="https://cabinet.sut.ru/raspisanie_all_new">линк</a>, сохранить страницу как и загрузить сюда.</p>
					<div class="form-group">
					    <label for="inputName">Название</label>
					    <input name="name-grup" type="text" class="form-control" id="inputName" placeholder="Название" required>
					</div>
					<div class="form-group">
					    <label for="inputFile">Загрузить фаил расписания</label>
					    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
					    <input name="file-grup" type="file" id="inputFile" required>
					</div>
					<div class="form-group">
					    <label for="inputData">Дата начала семестра</label>
					    <input name="data-tart-grup" type="date" class="form-control" id="inputData" required>
					</div>
					<div class="form-group">
					    <label for="inputPin">Пин код для доступа к редактированию</label>
					    <input name="pin-grup" type="text" class="form-control" id="inputPin" placeholder="Пин код для доступа к редактированию" required>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-default">Ввести</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
				</div>
		  	</form>
	    </div>
	  </div>
	</div><!--Добавление расписания Бонч-->
	<?php
	}
	if(isset($pin) && ($_COOKIE['pin'.$id_grup] == $pin)){
	?>
	<div class="modal fade" id="add_par_modal" tabindex="-1" role="dialog"><!--Добавление пары-->
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Добавление пары</h4>
	      </div>
	      <form role="form" name="add-para" method="post" action="/">
	      	<div class="modal-body">
	      		<div class="form-group" id="time_input_mob">
		      		<label for="inputTime">Время</label>
		      		<div class="input-group">
						<span class="input-group-addon">с</span>
						<input type="time" name="time-par1" class="form-control" id="inputTime" required>
						<span class="input-group-addon">по</span>
						<input type="time" name="time-par2" class="form-control" id="inputTime1" required>
					</div>
				</div>
				<div class="form-group" id="time_input_pc">
					<label for="inputTime0">Время</label>
					<label class="time_label" for="inputTime">Начало пары</label>
					<label class="time_label" for="inputTime1">Конец пары</label>
		      		<div class="input-group">
						<span class="input-group-addon">с</span>
						<input type="time" name="time-par1" data-role="datebox" class="form-control" id="inputTime" data-options='{"mode":"timeflipbox", "overrideTimeOutput":"%H:%M", "useFocus":true, "useButton":false, "useCancelButton":true, "useCollapsedBut":true}' required>
						<span class="input-group-addon">по</span>
						<input type="time" name="time-par2" data-role="datebox" class="form-control" id="inputTime1" data-options='{"mode":"timeflipbox", "overrideTimeOutput":"%H:%M", "useFocus":true, "useButton":false, "useCancelButton":true, "useCollapsedBut":true}' required>
					</div>
				</div>
				<div class="form-group">
					<label for="inputDay">День недели</label>
					<select name="day-par" class="form-control" id="inputDay">
					  <option value="1">Понедельник</option>
					  <option value="2">Вторник</option>
					  <option value="3">Среда</option>
					  <option value="4">Четверг</option>
					  <option value="5">Пятница</option>
					  <option value="6">Суббота</option>
					  <option value="0">Воскресенье</option>
					</select>
				</div>
				<div class="form-group">
					<label for="inputNum">№ пары</label>
					<select name="num-par" class="form-control" id="inputNum">
					  <option>1</option>
					  <option>2</option>
					  <option>3</option>
					  <option>4</option>
					  <option>5</option>
					</select>
				</div>
				<div class="form-group">
					<label for="inputName">Название пары</label>
				    <input name="name-par" type="text" class="form-control" id="inputName" placeholder="Название пары" required>
				</div>
				<div class="form-group">
					<label for="inputType">Тип пары</label>
				    <select name="type-par" class="form-control" id="inputType">
					  <option>Лекция</option>
					  <option>Практические занятия</option>
					  <option>Лабораторная работа</option>
					  <option>Консультация</option>
					  <option>Экзамен</option>
					</select>
				</div>
				<div class="form-group">
					<label for="inputWeek">По каким неделям</label>
					<div class="input-group">
				    	<input name="week-par" type="text" class="form-control" id="inputWeek" placeholder="По каким неделям" required>
				    	<span class="input-group-addon">1, 3, 4, 5</span>
				    </div>
				</div>
				<div class="form-group">
					<label for="inputPrepod">Преподаватель</label>
					<div class="input-group">
					    <input name="prepod-par1" type="text" class="form-control" id="inputPrepod" placeholder="Иванов И.И." required>
					    <span class="input-group-addon">Сокращенно</span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
					    <input name="prepod-par2" type="text" class="form-control" id="inputPrepod1" placeholder="Иванов Иван Иванович">
					    <span class="input-group-addon">Полностью</span>
					</div>
				</div>
				<div class="form-group">
					<label for="inputAyd">Аудитория</label>
				    <input name="aud-par" type="text" class="form-control" id="inputAyd" placeholder="Аудитория" required>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default">Добавить</button>
	    		<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
	      	</div>
		  </form>
	    </div>  
	  </div>  
	</div><!--Добавление пары-->
	<?}?>
	<div class="modal fade" id="add_pin_modal" tabindex="-1" role="dialog"><!--Разрешение на редактирование-->
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Доступ к редактированию</h4>
	      </div>
		  <form class="form" role="form" name="add-pin" method="post" action="/">
			<div class="modal-body">
				<div class="form-group">
					<label for="inputPin1">Пин код для доступа к редактированию группы <?=$name_grup?></label>
					<input name="pingrup" type="text" class="form-control" id="inputPin1" placeholder="Пин" required>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default">Ввести</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		  </form>
	    </div>
	  </div>
	</div><!--Разрешение на редактирование-->
	<div class="modal fade" id="add_grup_modal" tabindex="-1" role="dialog"><!--Добавление группы-->
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Добавление группы</h4>
	      </div>
		  <form role="form" name="add-grup" method="post" action="/">
		  	<div class="modal-body">
				<div class="form-group">
					<label for="inputName">Название</label>
					<input name="name-grup" type="text" class="form-control" id="inputName" placeholder="Название" required>
				</div>
				<div class="form-group">
					<label for="inputData">Дата начала семестра</label>
					<input name="data-tart-grup" type="date" class="form-control" id="inputData" placeholder="Дата начала семестра" required>
				</div>
				<div class="form-group">
					<label for="inputPin">Пин код для доступа к редактированию</label>
					<input name="pin-grup" type="text" class="form-control" id="inputPin" placeholder="Пин код для доступа к редактированию" required>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default">Добавить</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		  </form>
	    </div>
	  </div>
	</div><!--Добавление группы-->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/jquery-ui-1.12.1.min.js"></script>
	<script src="js/jquery.mousewheel.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/jtsage-datebox.min.js"></script>
	<script src="js/jtsage-datebox.i18n.ru.utf8.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/new.js"></script>
  </body>
</html>
<?php
$mysqli->close();