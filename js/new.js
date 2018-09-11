
if($.cookie('timeedit') && $.cookie('timeedit')!="null"){
	var timeedit = parseInt($.cookie('timeedit'));
	$.cookie('timeedit', timeedit, {
			    expires: 30,
			    path: '/',
			});
}
else
	var timeedit = 0;

console.log(timeedit);
var resultget = dann();

$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	if($(window).width()>767){
		$('#time_input_mob').empty();
	}else{
		$('#time_input_pc').empty();
	}
	setTimeout(function(){
		$('.alert-success').alert('close');
	},5000);
	$('#timeedit').click(timeed);
});

function timeed(){
		timeedit = parseInt($('#inputTimeedit').val());
		console.log(timeedit);
		if(timeedit == 0)
			$.cookie('timeedit', null);
		else
			$.cookie('timeedit', timeedit, {
			    expires: 30,
			    path: '/',
			});
	}

function monthd(){
	if($.cookie('month') == null || $.cookie('month') == "null")
		$.cookie('month', 1, {
		    expires: 30,
		    path: '/',
		});
	else
		$.cookie('month', null);
	document.location.reload();
}

function serch_day(){
	new_day = $('#inputSerchDay');
	if(new_day.val().length>0){
		var new_date = new Date(new_day.val());
		var new_date1 = new_date.getTime()/1000;
		console.log(new_day);
		document.location.replace("?day="+new_date1);
	}else{
		$('#inputSerchDayform').toggleClass('has-error');
		setTimeout(function(){
			$('#inputSerchDayform').toggleClass('has-error');
		}, 5000)
	}
}

$('#inputSerchDay').datepicker({
	format: "yyyy-mm-dd",
	todayHighlight: true,
	clearBtn: true,
	todayBtn: "linked",
	language: "ru",
	ntop: 70,
	autoclose: true,
	toggleActive: true,
	defaultViewDate: resultget,
	beforeShowDay: function (date){
                    if(date.getDate() == resultget["day"] && date.getMonth() == resultget["month"]){
                        return {
                          classes: 'acty'
                        };
                  	}
                }
});
$('#inputSerchDay2').datepicker({
	todayHighlight: true,
	language: "ru",
	todayBtn: true,
	ntop: 70,
	autoclose: true,
	defaultViewDate: resultget,
	beforeShowDay: function (date){
                    if(date.getDate() == resultget["day"] && date.getMonth() == resultget["month"]){
                        return {
                          classes: 'acty'
                        };
                  	}
                }
});
$('#inputSerchDay2').on('changeDate', function() {
	var new_dat = $(this).datepicker('getUTCDate');
	var new_dat1 = new_dat.getTime()/1000;
	console.log(new_dat);
	document.location.replace("?day="+new_dat1);
	
});

function dell_group(id, pin){
	$('#dell_group_modal').modal("show");
	var id_name = $('#group_name_'+id).html();
	$('#dell_group_name').html(id_name);
	$('#dell_group_id').val(id);
	$('#dell_group_pin').val(pin);
}

function dell_group_run(){
	var id_group = $("#dell_group_id").val();
    $.ajax({
    type: "POST",
    url: "ajax.php",
    data: "dell_group=1&id="+id_group+"&pin="+$("#dell_group_pin").val(),
    success: function(reply){
      if (reply == 'Ok') {
        $('#dell_group_modal').modal("hide");
        $('#dell_stroc_droup_'+id_group).remove();
        myalert('success', 'Группа '+$('#dell_group_name').html()+' удалена');
      } else {
      	myalert('danger', reply);
        //window.alert(reply);
      }
    },
    error: function(resp) {
    	myalert('danger', 'Ошибка 0');
      //window.alert('Ошибка 0');
    }
  })
};

function select_group(id){
	$.cookie('id', id, {
		expires: 30,
		path: '/',
	});
	var name = $('#group_name_'+id).html();
	$('#name_grup_bar').html(name);
};

function clear_raspis_id_group(id, pin){
	$('#clear_group_modal').modal("show");
	var id_name = $('#group_name_'+id).html();
	$('#clear_group_name').html(id_name);
	$('#clear_group_id').val(id);
	$('#clear_group_pin').val(pin);
}

function clear_raspis_id_group_run(){
  var id_group = $("#clear_group_id").val();
  $.ajax({
    type: "POST",
    url: "ajax.php",
    data: "clear_group=1&id="+id_group+"&pin="+$("#clear_group_pin").val(),
    success: function(reply){
      if (reply == 'Ok') {
        $('#clear_group_modal').modal("hide");
        myalert('success', 'Расписание группы '+$('#clear_group_name').html()+' очищено');
        //alert("Очишено");
      } else {
      	myalert('danger', reply);
        //window.alert(reply);
      }
    },
    error: function(resp) {
    	myalert('danger', 'Ошибка 0');
      //window.alert('Ошибка 0');
    }
  })
};

function edit_group(id){
	$('#edit_group_modal').modal("show");
	$('#edit_group_pin_div').removeClass('has-warning');
	$('#edit_group_pin_div>span').removeClass('glyphicon-pencil');
	$('#edit_group_name_div').removeClass('has-warning');
	$('#edit_group_name_div>span').removeClass('glyphicon-pencil');
	$('#edit_group_date_div').removeClass('has-warning');
	$('#edit_group_date_div>span').removeClass('glyphicon-pencil');
	var id_name = $('#group_name_'+id).html();
	var id_pin = $('#group_pin_'+id).html();
	var id_date = $('#group_date_'+id).html();
	$('#edit_group_name_input').val(id_name);
	$('#edit_group_date_input').val(id_date);
	$('#edit_group_id').val(id);
	$('#edit_group_pin_input').val(id_pin);
	$('#edit_group_pin_old').val(id_pin);
	$('#edit_group_date_input').datepicker({
	format: "dd.mm.yyyy",
	todayHighlight: true,
	clearBtn: true,
	todayBtn: "linked",
	language: "ru",
	ntop: 70,
	autoclose: true,
	toggleActive: true,
	defaultViewDate: resultget,
	beforeShowDay: function (date){
                    if(date.getDate() == resultget["day"] && date.getMonth() == resultget["month"]){
                        return {
                          classes: 'acty'
                        };
                  	}
                }
	});
	$('#edit_group_date_input').datepicker('update',id_date);
	$('#edit_group_pin_input').on('input',function(){
		if(id_pin != $(this).val()){
			$('#edit_group_pin_div').addClass('has-warning');
			$('#edit_group_pin_div>span').addClass('glyphicon-pencil');
		}
		else{
			$('#edit_group_pin_div').removeClass('has-warning');
			$('#edit_group_pin_div>span').removeClass('glyphicon-pencil');
		}
	});
	$('#edit_group_name_input').on('input',function(){
		if(id_name != $(this).val()){
			$('#edit_group_name_div').addClass('has-warning');
			$('#edit_group_name_div>span').addClass('glyphicon-pencil');
		}
		else{
			$('#edit_group_name_div').removeClass('has-warning');
			$('#edit_group_name_div>span').removeClass('glyphicon-pencil');
		}
	});
	$('#edit_group_date_input').on('changeDate', function() {
		if(id_date != $(this).val()){
			$('#edit_group_date_div').addClass('has-warning');
			$('#edit_group_date_div>span').addClass('glyphicon-pencil');
		}
		else{
			$('#edit_group_date_div').removeClass('has-warning');
			$('#edit_group_date_div>span').removeClass('glyphicon-pencil');
		}
	});
};

function edit_group_run(){
	var new_dat = $('#edit_group_date_input').datepicker('getUTCDate');
	var new_dat1 = new_dat.getTime()/1000;
	$.ajax({
	  type: "POST",
	  url: "ajax.php",
	  data: "edit_group=1&id="+$('#edit_group_id').val()+"&pin="+$('#edit_group_pin_input').val()+"&pin_old="+$('#edit_group_pin_old').val()+"&name="+$('#edit_group_name_input').val()+"&date="+new_dat1,
	  success: function(reply){
      if (reply == 'Ok') {
        $('#edit_group_modal').modal("hide");
        myalert('success', 'Группа '+$('#edit_group_name_input').val()+' изменена');
        //alert("Изменено");
        list_group_load();
      } else {
      	myalert('danger', reply);
        //window.alert(reply);
      }
    },
    error: function(resp) {
    	myalert('danger', 'Ошибка 0');
      //window.alert('Ошибка 0');
    }
	});
};

function list_group_load(){
    $.ajax({
    type: "POST",
    url: "ajax.php",
    data: "body_list_group=1",
    success: function(reply){
      if (reply.substring(0,2) == 'Ok') {
      	reply = reply.substring(2);
      	 $('#body_list_group').html(reply);
      	 $('[data-toggle="tooltip"]').tooltip();
      } else {
      	myalert('danger', reply);
        //window.alert(reply);
      }
    },
    error: function(resp) {
    	myalert('danger', 'Ошибка 0');
      //window.alert('Ошибка -0');
    }
  })
};

function myalert(type, text){
	var cla = Math.random().toString(36).slice(2, 12 );
    $.ajax({
    type: "POST",
    url: "ajax.php",
    data: "myalert=1&type="+type+"&text="+text+"&cla="+cla,
    success: function(reply){
    	$('#block_alerts').append(reply);
    	$('.'+cla).slideDown(150).delay(5000).slideUp(150);
    },
    error: function(resp) {
      window.alert('Ошибка 0');
    }
  })
};

function dann(){
	var ear;
	var man;
	var dayy;
	var getday = window.location.search;
	var getres = new Object(); 
	getday = (getday.substr(1)).split('&');
	for (var i = 0; i < getday.length; i++) {
		res = getday[i].split('=');
		if((typeof res[0] !== "undefined") && (typeof res[1] !== "undefined")){
			if(res[1].length>0){
				getres[res[0]] = res[1];
			}
		}
	}
	if(typeof getres["day"] !== "undefined"){
		if(!isNaN(parseFloat(getres["day"])) && isFinite(getres["day"])){
			var datee = new Date(getres["day"]*1000);
			ear = datee.getUTCFullYear();
			man = datee.getUTCMonth();
			dayy = datee.getUTCDate();
			var resulte ={
				year: ear,
				month: man,
				day: dayy 
			}
		}
	}else{
	console.log(22);
	var datee = new Date();
	ear = datee.getFullYear();
	man = datee.getMonth();
	dayy = datee.getDate();
	var resulte ={
		year: ear,
		month: man,
		day: dayy 
	}
	}
	console.log(resulte);
	return resulte;
}

window.onload = function(){
	var list1 = document.getElementsByClassName("time_para");
	var list2 = [];
	if(list1[0]!=undefined){
	for (var i = 0; i < list1.length; i++) {
		var list3 = [];
		list3[0] = parseInt(list1[i].innerText.substr(0,1));
		list3[1] = parseInt(list1[i].innerText.substr(3,1));
		if(list3[1] == 1){
			list3[1] = parseInt(list1[i].innerText.substr(3,2));
			list3[2] = parseInt(list1[i].innerText.substr(6,2));
			list3[3] = parseInt(list1[i].innerText.substr(9,2));
			list3[4] = parseInt(list1[i].innerText.substr(12,2));
		}else{
			list3[2] = parseInt(list1[i].innerText.substr(5,2));
			list3[3] = parseInt(list1[i].innerText.substr(8,2));
			list3[4] = parseInt(list1[i].innerText.substr(11,2));
		}
		list2[i] = list3;
	}
	}

window.setInterval(function(){
	var date = new Date();
	date.setHours(date.getHours()+timeedit);
	var hours = date.getHours();
	var minutes = date.getMinutes();
	var seconds = date.getSeconds();

	if (minutes < 10) 
		minutes = '0' + minutes;
	if (seconds < 10) 
		seconds = '0' + seconds;
	
	if(date.getDate()==resultget["day"] && date.getMonth()==resultget["month"] && date.getFullYear()==resultget["year"]){	
		if(list1[0]!=undefined){
			for (var i = 0; i < list1.length; i++) {
				var ii = i+1;
				var temp = "para_num_" + ii;
				var temp1 = document.getElementsByClassName(temp);
				if((hours==list2[i][1] && minutes>=list2[i][2]) || (hours==list2[i][3] && minutes<=list2[i][4]) || (list2[i][1]<hours && hours<list2[i][3])){
					temp1[0].style.background = "#ffab60";
					temp1[1].style.background = "#ffab60";
				}else{
					temp1[0].style.background = "#ffffff";
					temp1[1].style.background = "#ffffff";
				}
			}
		}
	}
	var str = hours + ':' + minutes + ':' + seconds;
	document.getElementById('clock').innerHTML = str;
}, 1000);
}