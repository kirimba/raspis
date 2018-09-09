<!--Modals-->
<?php
if(isset($_GET))
	$per_page = "?";
	$get_b_one = false;
	foreach ($_GET as $get_key => $get_value) {
		if ($get_b_one) $per_page = $per_page.'&';
		$per_page = $per_page.$get_key."=".$get_value;
		$get_b_one = true;
	}
	
?>
<?php
if(isset($_SESSION['mast']) && $_SESSION['mast'] == $maspar){
?>
<div class="modal fade" id="add_par_bonch_modal" tabindex="-1" role="dialog"><!--Добавление расписания Бонч-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Добавление расписания Бонч</h4>
		</div>
		<form enctype="multipart/form-data" role="form" name="add-par-bonch" method="post" action="/<?=$per_page?>">
			<div class="modal-body">
				<p>Зайди на эту страницу: <a href="https://cabinet.sut.ru/raspisanie_all_new">линк</a>, сохранить страницу как и загрузить сюда.</p>
				<div class="form-group">
				    <label for="inputName">Название</label>
				    <input name="name-grup-bo" type="text" class="form-control" id="inputName" placeholder="Название" required>
				</div>
				<div class="form-group">
				    <label for="inputFile">Загрузить фаил расписания</label>
				    <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
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
if((isset($pin) && ($_COOKIE['pin'.$id_grup] == $pin)) or (isset($_SESSION['mast']) && $_SESSION['mast'] == $maspar)){
?>
<div class="modal fade" id="dell_group_modal" tabindex="-1" role="dialog"><!--Удалить группу?-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Удалить?</h4>
      </div>
		<div class="modal-body">
			<div class="form-group">
				<p class="text-center">Удалить группу вместе с расписанием: <span id="dell_group_name"></span></p>
				<input type="hidden" id="dell_group_id" name="dell_group_id" value="">
				<input type="hidden" id="dell_group_pin" name="dell_group_pin" value="">			
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" id="dell_group_button" onclick="dell_group_run()">Удалить</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
		</div>
    </div>
  </div>
</div><!--Удалить группу?-->
<div class="modal fade" id="clear_group_modal" tabindex="-1" role="dialog"><!--Очистить расписание группы?-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Очистить?</h4>
      </div>
		<div class="modal-body">
			<div class="form-group">
				<p class="text-center">Очистить расписание группы: <span id="clear_group_name"></span></p>
				<input type="hidden" id="clear_group_id" name="clear_group_id" value="">
				<input type="hidden" id="clear_group_pin" name="clear_group_pin" value="">			
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" id="clear_group_button" onclick="clear_raspis_id_group_run()">Очистить</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
		</div>
    </div>
  </div>
</div><!--Очистить расписание группы?-->
<div class="modal fade" id="edit_group_modal" tabindex="-1" role="dialog"><!--Редактирование группы-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Редактирование группы</h4>
      </div>
	  	<div class="modal-body">
			<div id="edit_group_name_div" class="form-group has-feedback">
				<label class="control-label" for="edit_group_name">Название</label>
				<input name="edit_group_name_input" type="text" class="form-control" id="edit_group_name_input" placeholder="Название" required>
				<span class="glyphicon form-control-feedback"></span>
			</div>
			<div id="edit_group_date_div" class="form-group has-feedback">
				<label class="control-label" for="edit_group_date_input">Дата начала семестра</label>
				<input name="edit_group_date_input" type="text" class="form-control" id="edit_group_date_input" placeholder="Дата начала семестра" required>
				<span class="glyphicon form-control-feedback"></span>
				<small>Любой день <b>первой</b> недели</small>
			</div>
			<div id="edit_group_pin_div" class="form-group has-feedback">
				<label class="control-label" for="edit_group_pin_input">Пин код для доступа к редактированию</label>
				<input name="edit_group_pin_input" type="text" class="form-control" id="edit_group_pin_input" placeholder="Пин код для доступа к редактированию" required>
				<span class="glyphicon form-control-feedback"></span>
			</div>
			<input type="hidden" id="edit_group_id" name="edit_group_id" value="">
			<input type="hidden" id="edit_group_pin_old" name="edit_group_pin_old" value="">
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" onclick="edit_group_run()">Изменить</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
		</div>
    </div>
  </div>
</div><!--Редактирование группы-->
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
      <form role="form" name="add-para" method="post" action="/<?=$per_page?>">
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
<?php
}?>
<div class="modal fade" id="add_pin_modal" tabindex="-1" role="dialog"><!--Разрешение на редактирование-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Доступ к редактированию</h4>
      </div>
	  <form class="form" role="form" name="add-pin" method="post" action="/<?=$per_page?>">
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
	  <form role="form" name="add-grup" method="post" action="/<?=$per_page?>"> 
	  	<div class="modal-body">
			<div class="form-group">
				<label for="inputName">Название</label>
				<input name="name-grup" type="text" class="form-control" id="inputName" placeholder="Название" required>
			</div>
			<div class="form-group">
				<label for="inputData">Дата начала семестра</label>
				<input name="data-tart-grup" type="date" class="form-control" id="inputData" placeholder="Дата начала семестра" required>
				<small>Любой день <b>первой</b> недели</small>
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
<div class="modal fade" id="edit_time_modal" tabindex="-1" role="dialog"><!--Изменение времени-->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Изменение времени</h4>
      </div>
	  	<div class="modal-body">
			<div class="form-group">
				<label for="inputTimeedit">Изменить на:</label>
				<select name="time-edit" class="form-control" id="inputTimeedit">
				  <option>0</option>
				  <option>-11</option>
				  <option>-10</option>
				  <option>-9</option>
				  <option>-8</option>
				  <option>-7</option>
				  <option>-6</option>
				  <option>-5</option>
				  <option>-4</option>
				  <option>-3</option>
				  <option>-2</option>
				  <option>-1</option>
				  <option>+1</option>
				  <option>+2</option>
				  <option>+3</option>
				  <option>+4</option>
				  <option>+5</option>
				  <option>+6</option>
				  <option>+7</option>
				  <option>+8</option>
				  <option>+9</option>
				  <option>+10</option>
				  <option>+11</option>
				</select><small>Имеет отношение только к времени начала пары</small>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" id="timeedit">Изменить</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
		</div>
    </div>
  </div>
</div><!--Изменение времени-->