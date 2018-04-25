
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
	language: "ru",
	ntop: 70,
	autoclose: true,
	toggleActive: true
});
$('#inputSerchDay2').datepicker({
	todayHighlight: true,
	language: "ru",
	ntop: 70,
	autoclose: true
});
$('#inputSerchDay2').on('changeDate', function() {
	var new_dat = $(this).datepicker('getUTCDate');
	var new_dat1 = new_dat.getTime()/1000;
	console.log(new_dat);
	document.location.replace("?day="+new_dat1);
	
});

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
var lin = window.location.href;
var simb = lin.substr(lin.length-2,2);

window.setInterval(function(){
	var date = new Date();
	date.setUTCHours(date.getUTCHours()+3+timeedit);
	var hours = date.getUTCHours();
	var minutes = date.getMinutes();
	var seconds = date.getSeconds();

	if (minutes < 10) 
		minutes = '0' + minutes;
	if (seconds < 10) 
		seconds = '0' + seconds;
	if((simb=="f/")||(simb=="=0")){	
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