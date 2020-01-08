<?
include 'head_menu.php';
include $_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/function/chat_fn.php';
function page_title(){return "...";}
if(!isset($_SESSION['username']))
{
	if(!isset($_SESSION['guestname']))
	{
		header("Location: http://".$_SERVER['HTTP_HOST'].'/engine/include/chat/index.php');
		exit('Необходима регистрация.');
	}
}

echo start_job();
	
if(isset($_SESSION['username']))
{
	$login_trans=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt');
	$text_color_one = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_text_color_one.txt');
	$nick_color_one = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_nick_color_one.txt');
}
else if(isset($_SESSION['guestname']))
{
	$login_trans=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'.txt');
	$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'_color.arr'));
	$text_color_one = $file->one;
	$nick_color_one = $file->two;
}
?>

<?
	$chat_border = '#000';//DADABF
	if(isset($_SESSION['username']))
	{
		$lor=json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_cfg.arr'));
		if($lor[1] == '0')
		{
			$chat_l_or_r = 'left';
		}
		else
		{
			$chat_l_or_r = 'right';
		}
	}
	else
	{
		$chat_l_or_r = 'right';
	}
	
	if($chat_l_or_r == 'left')
	{
		$chat_left_body = 'left';
		$chat_ltr = 'chat_ltr';
		$chat_right_body = 'right';
	}
	else
	{
		$chat_left_body = 'right';
		$chat_ltr = 'chat_rtl';
		$chat_right_body = 'left';
	}
?>

<style type="text/css">
body{width:100%;overflow:hidden;}


#chat_left_body{
width:100%;
padding:0;
margin:0;
}


#chat_right_body{
width:280px;
padding:0;
margin:0;
background-color:#202020;
}

#chat_frame{
background-color:white;
width:100%;
overflow-y:scroll;
}

#chat_users_output_body{
border-spacing:0;
height:72px;
background-color:#4F4F4F;
}
#chat_uo_body td {padding: 1px;}
#chat_users_output_body td{background-color:#5F5F5F;}

#chat_profile_info_id_2{
border-top:1px solid <? echo $chat_border;?>;
color:#CCC;
width:100%;
text-indent:5px;
}

#users_check_online{
overflow:auto;
width:280px;
}


#users_check_online img{
height:23px;
width:23px;
}
#users_check_online abbr{
width:16px;
text-align:center;
}

.chat_color_1_n{background-color:#4F4F4F;}
.chat_color_2_n{background-color:#5F5F5F;}
.chat_color_nick_o{float:left;padding-left:3px;width:197px;}

.sh_black{text-shadow: 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black, 0 0 1px black;}
.sh_white{text-shadow: 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white, 0 0 1px white;}

.chat_users_online_frame{list-style-type: none;height:23px;line-height:23px;padding:1px;}


#user_input{
height:30px;
line-height:30px;
width:100%;
background-color:#F7F7F7;
<?
if($chat_left_body == 'right')$style_tmp='0 3px 3px 0';
else $style_tmp='3px 0 0 3px';
?>
border-radius:<? echo $style_tmp;?>;
overflow-y:auto;
overflow-x:hidden;
}

#user_input img{max-height:30px;vertical-align:middle;}

.chat_all_message_style{
margin:1px;
text-indent:2px;
}

.chat_old_users_message{border-left:5px solid #CEDB60;}
.chat_system_message{
border-left:5px solid #6495EB;
}

.chat_users_private_messages{
border-bottom:1px solid #EEE3E3;
background-color:#FFF3F3;
border-left:5px solid #D6A4E5;
}

.chat_users_my_private_messages{
border-bottom:1px solid #EEE3E3;
background-color:#FFF3F3;
border-left:5px solid pink;
}

.chat_users_only_you{
border-bottom:1px solid #E9E9EE;
background-color: #F9F9FF;
border-left:5px solid #B7CBED;
}


.chat_border{border:1px solid <? echo $chat_border;?>;}
.chat_color_2{background-color:#303030;color:gray;}
.chat_in_color_b{
vertical-align:middle;
cursor:pointer;
line-height:23px;
height:23px;
width:23px;
background-color:#CCC;
border:1px outset #5F5F5F;
border-radius:2px;
}

</style>

<script type="text/javascript">
function allowDrop(ev){ev.preventDefault();}
function drop(ev){send_message();}
 </script>
<?
$b_b='';$b_i='';$b_u='';
if(isset($_SESSION['guestname']))$file=json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'_biu.arr'));
else if(isset($_SESSION['username']))$file=json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/biu.arr'));
if($file->b == '1')$b_b = ' chat_hover_button';
if($file->i == '1')$b_i = ' chat_hover_button';
if($file->u == '1')$b_u = ' chat_hover_button';
?>


<table class="width_100pr <? echo $chat_ltr;?>" style="border-collapse:collapse;"><tr>
<td id="chat_right_body" class="chat_ltr">
<div id="users_check_online"></div>
<div id="chat_profile_info_id_2" class="right chat_color_2" style="text-align:<? echo $chat_left_body;?>;">
		в чате 
		<span id="chat_profile_info_id_2_n">OVER9000</span> 
		чел.
</div>

</td>


<td id="chat_left_body" class="chat_ltr">
<div id="chat_frame" ondragover="allowDrop(event)" ondrop="drop(event)">
<?
	echo load_start_messages();
?>
</div>



<table id="chat_users_output_body" class="width_100pr <? echo $chat_ltr;?>"><tr>
<td style="width:110px;padding-left: 5px;">
<table id="chat_uo_body"><tr>
<td><div class="chat_in_color_b" id="chat_edit_color_1" title="Цвет ника" onclick="render_edit_nick_color('edit_color_1_canvas', 'edit_color_1_canvas_body', 'edit_color_1_block_edit_old_color', 'edit_color_1_block_edit_new_color', 'edir_color_1_div'); return false;" style="background-color:<? echo $nick_color_one;?>;"></div></td>
<td><div class="chat_in_color_b" id="chat_edit_color_2" title="Цвет текста" onclick="render_edit_nick_color('edit_color_2_canvas', 'edit_color_2_canvas_body', 'edit_color_2_block_edit_old_color', 'edit_color_2_block_edit_new_color', 'edir_color_2_div'); return false;" style="background-color:<? echo $text_color_one;?>;"></div></td>
<td>	<div class="chat_in_color_b tx_align_center " style="font-size:22px;" title="Редактировать" onclick="chat_content_editable(); return false;">&#9998;</div></td>
<td><img class="chat_in_color_b left" onclick="smiles_on_off(); return false;" src="/engine/images/smiles.gif" alt="Смайлы" title="Смайлы"/></td>
</tr><tr>
<td><div class="chat_in_color_b tx_align_center <? echo $b_b;?>" onclick="biu('b'); return false;" id="button_biu_b" title="Устанавливает жирное начертание шрифта">ж</div></td>
<td><div class="chat_in_color_b tx_align_center <? echo $b_i;?>" onclick="biu('i'); return false;" id="button_biu_i" title="Устанавливает курсивное начертание шрифта">к</div></td>
<td>	<div class="chat_in_color_b tx_align_center bold"><a style="text-decoration:none;color:gray;" href="/engine/include/chat/function/chat_cfg.php" title="Чат слева\справа">&#8644;</a></div></td>
<td><div class="chat_in_color_b <? echo $chat_left_body;?> tx_align_center" onclick="chat_sound_contol(this); return false;" title="Звук">з</div></td>
</tr></table>
</td>
<td style="padding:0 5px;">
<div onclick="chat_btn_public_action(); return false;" title="Текущий режим" class="cursor_pointer chat_btn_public bold" id="chat_public_or_private_btn">Публично</div>
<div style="padding-<? echo $chat_right_body;?>:80px;">
<div id="user_input" class="left chat_ltr" contenteditable="true"></div>
</div>
<div class="left" style="width:100%;height:22px;line-height:22px;color:#F7F7F7;">
	<div class="<? echo $chat_left_body;?>" id="print_usr_list">
		<div style="float:<? echo $chat_left_body;?>;line-height:22px;font-size:18px;" class="cursor_pointer tx_align_center" onclick="key_on_off(); return false;" title="Виртуальная клавиатура">&#9000;</div><div id="print_usr_list_design_say"></div>
	</div>
	<div class="<? echo $chat_right_body;?>" id="print_usr_list_right"></div>
</div>
</td>
</tr>
</table>
</td>
</tr></table>



<style type="text/css">
.chat_close{
font-size:12px;
line-height:20px;
background-color:#4F4F4F;
color:#FFFFFF;
width:70px;
border-radius: 0 5px 0 0;
text-align:center;
}

#print_usr_list_design_say{
margin-<? echo $chat_right_body;?>:5px;
margin-<? echo $chat_left_body;?>:5px;
float:<? echo $chat_left_body;?>;
border-<? echo $chat_left_body;?>: 0px solid transparent;
border-<? echo $chat_right_body;?>: 15px solid transparent;
border-top: 20px solid #F7F7F7;
}

.print_usr_list_style{
line-height:20px;
font-size:15px;
float:left;
background-color:#EEE;
margin-left:3px;
padding:0 3px;
border-bottom:1px solid black;
border-left:1px solid white;
border-right:1px solid black;
color:#5F5F5F;
}

#print_usr_list{
overflow:auto;
height:22px;
}

#print_usr_list_right{width:0px;}

#chat_public_or_private_btn{
float:<? echo $chat_right_body;?>;
line-height:30px;
font-size:12px;
color:white;
width:80px;
text-align:center;
<?
if($chat_left_body == 'right')$style_tmp='3px 0 0 0;';
else $style_tmp='0 3px 0 0;';
?>
border-radius:<? echo $style_tmp;?>;
}


.chat_prompt_listen:nth-child(even){background-color:#5F5F5F;}
.chat_prompt_listen:nth-child(odd){background-color:#4F4F4F;}

.chat_prompt_listen{
color:#CCC;
line-height:24px;
float:left;
width:100%;
text-align:left;
}

.chat_prompt_listen div{
padding:0 5px;
}
</style>



<div class="hidden">
<audio preload="auto" id="chat_sound_message">
	<source src="/engine/include/chat/audio/message.wav"/>
	<source src="/engine/include/chat/audio/message.mp3"/>
	<source src="/engine/include/chat/audio/message.ogg"/>
</audio>

<audio preload="auto" id="chat_sound_message_private">
	<source src="/engine/include/chat/audio/private.wav"/>
	<source src="/engine/include/chat/audio/private.mp3"/>
	<source src="/engine/include/chat/audio/private.ogg"/>
</audio>
</div>
<div id="output"></div>
<div id="edir_color_1_div">
	<div class="border_radius_5top chat_color_edit_dialog_style">
		<div class="border_radius_5top opacity_90 chat_color_2" id="edir_color_1_div_head">
			<span onclick="on_off_block('edir_color_1_div'); return false;"  class="chat_close cursor_pointer right">Закрыть</span></div>
			<div style="width:400px;height:231px;background-color:#4F4F4F;">
			<canvas class=" left" height="230" width="290" id="edit_color_1_canvas_body"></canvas>
			<canvas class="left" id="edit_color_1_canvas" height="229" width="25"></canvas>
			<div id="edit_color_1_block_edit_old_color"></div>
			<div id="edit_color_1_block_edit_new_color"></div>
			<button class="send_edit_nick_color_style" onclick="send_edit_nick_color_1(); return false;">Готово</button>
		</div>
	</div>
</div>

<div id="edir_color_2_div">
	<div class="border_radius_5top chat_color_edit_dialog_style">
		<div class="border_radius_5top opacity_90 chat_color_2" id="edir_color_2_div_head">
			<span onclick="on_off_block('edir_color_2_div'); return false;" class="chat_close cursor_pointer right">Закрыть</span></div>
			<div style="width:400px;height:231px;background-color:#4F4F4F;">
			<canvas class="left" height="230" width="290" id="edit_color_2_canvas_body"></canvas>
			<canvas class="left" id="edit_color_2_canvas" height="229" width="25"></canvas>
			<div id="edit_color_2_block_edit_old_color"></div>
			<div id="edit_color_2_block_edit_new_color"></div>
			<button class="send_edit_nick_color_style" onclick="send_edit_nick_color_2(); return false;">Готово</button>
		</div>
	</div>
</div>

<style type="text/css">
.chat_btn_public{background-color:#9BBB4C;}
.chat_btn_private{background-color:#FBB14E;}
.chat_color_edit_dialog_style{width:400px;height:251px;}

#edit_color_1_canvas, #edit_color_2_canvas{margin-left:1px;margin-top:1px;}
#edir_color_1_div_head, #edir_color_2_div_head{width:400px;height:20px;cursor:move;}
#edit_color_1_block_edit_old_color, #edit_color_1_block_edit_new_color, #edit_color_2_block_edit_old_color, #edit_color_2_block_edit_new_color{
height:40px;width:60px;float:left;
border:1px solid #202020;
margin-left:12px;
margin-top:6px;
}
#edit_color_1_block_edit_old_color{background-color:<? echo $nick_color_one;?>;}
#edit_color_2_block_edit_old_color{background-color:<? echo $text_color_one;?>;}

.send_edit_nick_color_style{
padding:0;
border:1px solid #303030;
height:20px;
float:left;
background-color:#5F5F5F;
margin:6px 0 0 12px;
width:62px;
}

</style>

<script>
if (!Array.prototype.indexOf)
{
	Array.prototype.indexOf = function(elt /*, from*/)
	{
		var len = this.length >>> 0;
		var from = Number(arguments[1]) || 0;
		from = (from < 0)
	         ? Math.ceil(from)
	         : Math.floor(from);
		if (from < 0)from += len;
		for (; from < len; from++)
		{
			if (from in this &&
				this[from] === elt)
			return from;
		}
		return -1;
	};
}

function chat_scroll()
{
	$('#chat_frame').animate({scrollTop:'+='+$('#chat_frame').children("div:last").height()+2+'px'});
}


function create_prompt_tray(obj)
{
	alert(obj)
	resize_window();
}


var usrname_tr="<?php
if(isset($_SESSION['username']))
{
	echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt');
}
else if(isset($_SESSION['guestname']))
{
	echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'.txt');
}
?>";
var print_usr_array = [];
var divname_user_input = document.getElementById('user_input');
var divname_users_check_online = document.getElementById('users_check_online');
var main_menu_header_block_js = $("#main_menu_header_block").height();
var window_height = $(window).height();
var pri_pub=false;

var print_message_str=0;//1=check_message


var chat_method = "<?
if (isset($_SESSION['username']))
{
	$torb=json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_cfg.arr'));
	echo $torb[0];
}
else
{
	echo '0';
}
?>";
var main_chat_frame = $('#chat_frame');

check_message();
check_chat_time();
check_online();
function check_message()//Проверка обновлений
{
	$.get(
	"/engine/include/chat/check_message.php",{ s: print_message_str,'u[]': print_usr_array},//*Печатает сообщение, Список пользователей
	function (data)
	{
		if(!data['m']=='')
		{
			if(chat_method == '0')
			{
				main_chat_frame.append(data['m']);
				chat_scroll();
			}
			else
			{
				main_chat_frame.prepend(data['m']);
			}
		}
		if(!data['s']=='')
		{
			for (var key in data['s']) 
			{
				if($(".print_message_usr_id_"+data['s'][key][0]).length) 
				{
					if(data['s'][key][1] == "offline")
					{
						$(".print_message_usr_id_"+data['s'][key][0]).css('color', 'red')
					}
					else
					{
						if(data['s'][key][1] > 0)
						{
							$(".print_message_usr_id_"+data['s'][key][0]).css('color', '#9BBB4C')
						}
						else
						{
							$(".print_message_usr_id_"+data['s'][key][0]).css('color', '#5F5F5F')
						}
					}
				}
			}
		}
	});
	if(print_message_str>0)
	{
		print_message_str--;
	}
	setTimeout("check_message()", 200);
}


$('#user_input').droppable({drop : function(event, ui)
{
	test = $(ui.draggable).attr("src");
	cont = "("+test.substring(test.lastIndexOf('/')+1,test.length)+")";
	if (!divname_user_input.innerHTML.match(cont))
	{
		cont = cont.replace('<br>', '');
		cont = cont.replace('<br/>', '');
		$("#user_input").append('<img alt="" src="'+test+'" />');
		divname_user_input.innerHTML = $("#user_input").html().replace('<br>', '');
	}
	chat_input_focus();
}});
		 
function check_chat_time()
{
	$.get("/engine/include/chat/check_chat_time.php");
	setTimeout("check_chat_time()", 60000);
}


function check_online()
{
	engine_check_online();
	setTimeout("check_online()", 10000);
}


function engine_check_online()
{
	$.get(
	"/engine/include/chat/check_online.php",
	function (data)
	{
		if(!data['MTA']) {data['MTA'] = ""}
		
		$("#users_check_online").html(data['online_female']+data['online_male']+data['online_guest']+data['MTA']+data['Minecraft']);
		document.getElementById('chat_profile_info_id_2_n').innerHTML = divname_users_check_online.getElementsByTagName('li').length;
		if(divname_users_check_online.getElementsByTagName('li').length == 0)
		{
			location.reload();
		}
	});
}


var tmp_innertext;//Для кроссбраузерности
function print_message(obj)
{
	if(pri_pub && print_usr_array.length > 0)
	{
		create_prompt_tray('Не больше 1 пользователя.');
	}
	else
	{
		if(obj.innerText)tmp_innertext=obj.innerText;//Остальные
		else	tmp_innertext=obj.textContent;//FireFox
		if (print_usr_array.join().search(tmp_innertext) == -1)
		{

			print_usr_array[print_usr_array.length] = tmp_innertext;

			$('#print_usr_list').append('<div class="print_usr_list_style print_message_usr_id_'+tmp_innertext+'">'+tmp_innertext+'<div onclick=\'rm_print_message_usr(\"'+tmp_innertext+'\"); return false;\' title="Удалить" class="right cursor_pointer" style="padding-left:3px;color:red;font-size:15px;margin-top:-3px;">x</div></div>');
		}
		chat_input_focus();
	}

}


function rm_print_message_usr(obj)
{
	$("div.print_message_usr_id_"+obj).remove();
	print_usr_array.splice(print_usr_array.indexOf(obj),1);

}

document.onclick=function(){$('title').text('...');}


function send_message() 
{
	out_print_usr_array='';
	for (var i=0; i<print_usr_array.length; i++) 
	{
		if(pri_pub)
		{
			out_print_usr_array += "[@private]"+print_usr_array[i]+", ";
		}
		else
		{
			out_print_usr_array += print_usr_array[i]+", ";
		}
	}	
	divname_user_input.innerHTML = smiles_replace(divname_user_input.innerHTML);
	if(divname_user_input.innerText != '')
	{
		$.post(
		"/engine/include/chat/burn_message.php",
		{
			message: out_print_usr_array+$("#user_input").text(),
			rez: pri_pub
		},
		function (data)
		{
			chat_clear_message();
		});
	}
}



$("#user_input").keypress(function(event)
{
	if(IE='\v'!='v')
	{
		$('title').text('...');
	}
	print_message_str=6;
	if(event.which == '13')
	{
		send_message();
	}
});


	
function chat_clear_message(){$('#user_input').text('');}
function chat_input_focus(){$("#user_input").focus();seoc(divname_user_input);}


var old_obj_load_smile_content='main';
function smiles_on_off()
{
	if(document.getElementById('smilediv')==null)
	{
		var smilediv=document.createElement('div');
		smilediv.setAttribute('style','display:block;position: fixed; top: 50%;left: 50%;');
		smilediv.setAttribute("id", "smilediv");
		smilediv.innerHTML = '<div align="center" class="border_radius_5top opacity_90 chat_color_2" id="chat_smile_frame_head">'+
		'<span onclick="chat_smile_anim_off(); return false;" title="Анимация" style="margin-left:8px;line-height:20px;" class="cursor_pointer left">A</span>'+
		'<span onclick="on_off_block(\'smilediv\'); return false;" class="chat_close cursor_pointer right">Закрыть</span></div><div style="width:400px; height:200px;" id="chat_smile_content">'+
		'</div><div class="chat_color_2" id="chat_smile_frame_foot">'+
		'<font class="chat_smile_content_tx" onclick="load_smile_content(\'main\'); return false;">Основные</font>'+
		'<font class="chat_smile_content_tx" onclick="load_smile_content(\'food\'); return false;">еда</font>'+
		'<font class="chat_smile_content_tx" onclick="load_smile_content(\'dance\'); return false;">танцы</font>'+
		'<font class="chat_smile_content_tx" onclick="load_smile_content(\'music\')"; return false;>музыка</font>'+
		'<font class="chat_smile_content_tx" onclick="load_smile_content(\'love\')"; return false;>любовь</font>'+
		'<font class="chat_smile_content_tx" onclick="load_smile_content(\'job\')"; return false;>работа</font>'+
		'<font class="chat_smile_content_tx" onclick="load_smile_content(\'trollface\')"; return false;>trollface</font>'+
		'<font class="chat_smile_content_tx" onclick="load_smile_content(\'computer\'); return false;">компьютеры</font>'+
		'<font class="chat_smile_content_tx" onclick="load_smile_content(\'friends\'); return false;">дружба</font>'+
		'<font class="chat_smile_content_tx" onclick="load_smile_content(\'weapon\'); return false;">оружие</font>'+
		'<font class="chat_smile_content_tx" onclick="load_smile_content(\'sport\'); return false;">спорт</font>'+
		'<font class="chat_smile_content_tx" onclick="load_smile_content(\'holiday\'); return false;">выпивка</font>'+
		'</div>';
		$('body').prepend(smilediv);
		load_smile_content('main');
		$("#smilediv").draggable({containment:"window",handle:'#chat_smile_frame_head'});
	}
	else
	{
		document.getElementById('smilediv').style.display = (document.getElementById('smilediv').style.display == 'none')?'block':'none';
	}
}



function load_smile_content(obj)
{
	$("#chat_smile_content").html("");
	old_obj_load_smile_content=obj;
	for (var i=0; i<chat_sml[obj].length; i++) 
	{
		d=document.createElement('img');
		d.setAttribute("class","chat_sc chat_sc_js");
		d.setAttribute("onclick","onclick_smile(this); return false;");
		d.setAttribute("src",'/engine/images/smile/'+obj+"/"+chat_sml[obj][i]);
		d.setAttribute("alt","");
		$("#chat_smile_content").append(d);
	}	
	chat_install_smile_fn();
}




function chat_smile_anim_off()
{
	$('.chat_sc_js').each(function(i) 
	{
		pic = new Image();
		d=document.createElement('canvas');
		d.width=this.width;
		d.height=this.height;
		if(this.src == null)
		{
			pic.src = $(this).data('src');
			d.setAttribute("data-src",$(this).data('src'));
		}
		else
		{
			pic.src = this.src;
			d.setAttribute("data-src",this.src);
		}
		d.setAttribute("class","chat_sc chat_sc_js");
		d.setAttribute("onclick","onclick_smile(this); return false;");
		d.getContext('2d').drawImage(pic, 0, 0); 
		$("#chat_smile_content").append(d);
		$(this).remove();
		chat_install_smile_fn();
	});
}


function chat_install_smile_fn()
{
	$('.chat_sc').draggable({helper : 'clone',opacity : 0.5});
}


var test='';
var cont='';

function onclick_smile(obj) 
{
	if(obj.src==null)
	{
		test=obj.getAttribute("data-src");//canvas
	}
	else
	{
		test = obj.src;//image
	}
	test = test.replace("http://"+document.domain, '');
	cont = "("+test.substring(test.lastIndexOf('/')+1,test.length)+")";
	if (!divname_user_input.innerHTML.match(cont) && divname_user_input.getElementsByTagName('img').length < 3)
	{
		cont = cont.replace('<br>', '');
		cont = cont.replace('<br/>', '');
		$("#user_input").append('<img alt="" src="'+test+'" />');
		divname_user_input.innerHTML = $("#user_input").html().replace('<br>', '');
	}
	chat_input_focus();
}



var range,selection;
function seoc(cee)
{
        range = document.createRange();
        range.selectNodeContents(cee);
        range.collapse(false);
        selection = window.getSelection();
        selection.removeAllRanges();
	selection.addRange(range);
}




var audioElement = document.getElementById('chat_sound_message');
var audioElement_2 = document.getElementById('chat_sound_message_private');

function play_message(){audioElement.play();}
function play_message_private(){audioElement_2.play();}

function chat_sound_contol(obj){
if(audioElement.volume==0){
	audioElement.volume=0.9;
	audioElement_2.volume=0.9;
	$(obj).removeClass('lt');
}else{
	audioElement.volume=0;
	audioElement_2.volume=0;
	$(obj).addClass('lt');
}}


function on_off_block(obj){document.getElementById(obj).style.display = (document.getElementById(obj).style.display == 'block')?'none':'block';}


function send_edit_nick_color_1()
{
	$.post(
	"/engine/include/users/page/edit_nick_color.php",
	{ 
		message: rgb2hexm($('#edit_color_1_block_edit_new_color').css('backgroundColor'))
	},
	function (data)
	{
		
		$("#edit_color_1_block_edit_old_color").css('background-color', rgb2hexm($('#edit_color_1_block_edit_new_color').css('backgroundColor')));
		$("#chat_edit_color_1").css('background-color', rgb2hexm($('#edit_color_1_block_edit_new_color').css('backgroundColor')));
	});
}


function render_edit_nick_color(obj_canvas, obj_body, obj_old, obj_new, obj_div)
{
	var canvas = document.getElementById(obj_canvas);
	var ctx = canvas.getContext("2d");
	var grad = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
	grad.addColorStop(0, '#FD040A');
	grad.addColorStop(.2, '#FE00FD');
	grad.addColorStop(.4, '#0006FE');
	grad.addColorStop(.6, '#01F9FE');
	grad.addColorStop(.8, '#00FF00');
	grad.addColorStop(.9, 'yellow');
	grad.addColorStop(1, 'red');
	ctx.fillStyle = grad;
	ctx.fillRect(0, 0, canvas.width, canvas.height);
	
	var canvas_body = document.getElementById(obj_body);
	var ctx = canvas_body.getContext("2d");
	var grad = ctx.createLinearGradient(0, 0, canvas_body.width, canvas_body.height);
	grad.addColorStop(0, "rgb(220, 220, 220)");
	grad.addColorStop(.5, rgb2hexm($("#"+obj_old).css('backgroundColor')));
	grad.addColorStop(1, "rgb(0, 0, 0)");
	ctx.fillStyle = grad;
	ctx.fillRect(0, 0, canvas_body.width, canvas_body.height);
	
	document.getElementById(obj_old).style.background= rgb2hexm($("#"+obj_old).css('backgroundColor'));
	document.getElementById(obj_new).style.background= rgb2hexm($("#"+obj_old).css('backgroundColor'));
	
	$("#"+obj_canvas).click(function(e){
	var pos = findPos(this);
	var p = this.getContext('2d').getImageData(e.pageX-pos.x, e.pageY-pos.y, 1, 1).data; 
	render_canvas("#"+("000000"+rgbToHex(p[0], p[1], p[2])).slice(-6), obj_body);
	});
	
	$("#"+obj_body).click(function(e){
	var pos = findPos(this);
	var p = this.getContext('2d').getImageData(e.pageX-pos.x, e.pageY-pos.y, 1, 1).data; 
	document.getElementById(obj_new).style.background="#"+("000000"+rgbToHex(p[0], p[1], p[2])).slice(-6);
	});
	on_off_block(obj_div);
}




function send_edit_nick_color_2()
{
	$.post(
	"/engine/include/users/page/edit_text_color.php",
	{ 
		message: rgb2hexm($('#edit_color_2_block_edit_new_color').css('backgroundColor'))
	},
	function (data)
	{
		$("#edit_color_2_block_edit_old_color").css('background-color', rgb2hexm($('#edit_color_2_block_edit_new_color').css('backgroundColor')));
		$("#chat_edit_color_2").css('background-color', rgb2hexm($('#edit_color_2_block_edit_new_color').css('backgroundColor')));
	});
}

function rgb2hexm(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}


function render_canvas(color, obj)
{
	var canvas_body = document.getElementById(obj);
	var ctx = canvas_body.getContext("2d");
	var grad = ctx.createLinearGradient(0, 0, canvas_body.width, canvas_body.height);
	grad.addColorStop(0, "rgb(220, 220, 220)");
	grad.addColorStop(.5, color);
	grad.addColorStop(1, "rgb(0, 0, 0)");
	ctx.fillStyle = grad;
	ctx.fillRect(0, 0, canvas_body.width, canvas_body.height);
}


function findPos(obj){var curleft = 0, curtop = 0;if (obj.offsetParent){do{curleft += obj.offsetLeft;curtop += obj.offsetTop;}while(obj=obj.offsetParent);return{x:curleft,y:curtop};}return undefined;}
function rgbToHex(r, g, b){if(r > 255 || g > 255 || b > 255)throw "Invalid color component";return ((r << 16) | (g << 8) | b).toString(16);}


function chat_ignore_act(obj)
{
	$.get(
	"/engine/include/chat/function/ignore.php",
	{
		usr: obj
	},
	function (data)
	{
		engine_check_online();
	});
}

function biu(obj)
{
	$.get(
	"/engine/include/chat/function/biu.php",
	{
		biu: obj
	},
	function (data)
	{
		chat_hover_button('#button_biu_'+data['biu']);
	});
}
function chat_hover_button(obj)
{
	if($(obj).hasClass("chat_hover_button"))
	{
		$(obj).removeClass("chat_hover_button");
	}
	else
	{
		$(obj).addClass("chat_hover_button");
	}
}

function chat_view_smile(ff, ff2){document.getElementById(ff2).innerHTML = "<img src=http://"+window.location.host+ff+" />";}



var chat_config_lr = "<? echo $chat_left_body;?>";



function chat_btn_public_action()
{
	if(pri_pub)
	{		
		$("#chat_public_or_private_btn").removeClass("chat_btn_private");
		$("#chat_public_or_private_btn").addClass("chat_btn_public");
		$("#chat_public_or_private_btn").html('Публично');
		pri_pub=!pri_pub;
	}
	else
	{
		if(print_usr_array.length > 1)
		{
			create_prompt_tray('Не больше 1 пользователя.');
		}
		else
		{
			$("#chat_public_or_private_btn").removeClass("chat_btn_public");
			$("#chat_public_or_private_btn").addClass("chat_btn_private");
			$("#chat_public_or_private_btn").html('Лично');
			pri_pub=!pri_pub;
		}

	}
}


function chat_content_editable()
{
	document.getElementById("chat_frame").contentEditable = (document.getElementById("chat_frame").contentEditable == 'true')?'false':'true'; 
}

$(document).ready(function(){
	$("#edir_color_1_div").draggable({ containment: "window" ,  handle: '#edir_color_1_div_head' });
	$("#edir_color_2_div").draggable({ containment: "window" ,  handle: '#edir_color_2_div_head' });
});
</script>



<style type="text/css">
#chat_all_message_draggble{
cursor:move;
width:5px;
position:absolute;
margin-left:-5px;
}

#vt_keyboard_body{
position: fixed;
width:510px;

background-color:#B9B59B;
border-radius:3px 3px 0 0;
}

.vt_keyboard_1r{
width:100%;
height:30px;
float:left;
padding-top:5px;
}

.vt_keyboard_2r{
width:100%;
height:30px;
float:left;
padding-top:2px;
}
.vt_keyboard_last_r{
width:100%;
height:30px;
float:left;
padding-top:2px;
margin-bottom:7px;
}

.vt_keyboard_30px_lh15, .vt_keyboard_30px{

border-bottom:2px solid black;
border-left:1px solid black;
box-shadow:3px 3px 3px rgba(0,0,0,0.8);
height:29px;
font-size:10px;
width:30px;
cursor:pointer;
float:left;
border-radius:3px;
margin:0 1px;
color:#F7F7F7;
text-align:center;
}

.vt_keyboard_30px_lh15{
line-height:15px;
}
.vt_keyboard_30px{
line-height:30px;
}
.vt_keyboard_c1{
background-color:#37372F;
}
.vt_keyboard_c2{
background-color:#26261E;
font-size:8px;
}
.vtken{
float:left;
padding-left:7px;
}
.vtkru{
float:left;
padding-left:15px;
color:#EE746C;
}
</style>

<div id="vt_keyboard_body">
<div class="vt_keyboard_1r">
<div class="vt_keyboard_30px vt_keyboard_c2" style="margin-left:10px;">~</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="1">!<br />1</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="2">@<br />2</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="3">#<br />3</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="4">$<br />4</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="5">%<br />5</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="6">^<br />6</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="7">&<br />7</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="8">*<br />8</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="9">(<br />9</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="0">)<br />0</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="44">_<br />-</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="45">+<br />=</div>
<div class="vt_keyboard_30px vt_keyboard_c2" style="width:60px;" onclick="chat_clear_message(); return false;">RESET</div>
</div>
<div class="vt_keyboard_2r">
<div class="vt_keyboard_30px vt_keyboard_c2" style="width:45px;margin-left:10px;">Tab</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="10"><div class="vtken">Q</div><br /><div class="vtkru">Й</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="11"><div class="vtken">W</div><br /><div class="vtkru">Ц</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="12"><div class="vtken">E</div><br /><div class="vtkru">У</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="13"><div class="vtken">R</div><br /><div class="vtkru">К</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="14"><div class="vtken">T</div><br /><div class="vtkru">Е</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="15"><div class="vtken">Y</div><br /><div class="vtkru">Н</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="16"><div class="vtken">U</div><br /><div class="vtkru">Г</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="17"><div class="vtken">I</div><br /><div class="vtkru">Ш</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="18"><div class="vtken">O</div><br /><div class="vtkru">Щ</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="19"><div class="vtken">P</div><br /><div class="vtkru">З</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="20"><div class="vtken">[</div><br /><div class="vtkru">Х</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="21"><div class="vtken">]</div><br /><div class="vtkru">Ъ</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c2" style="width:45px;" data-key="backspace">&#8592;Back<br />Space</div>
</div>
<div class="vt_keyboard_2r">
<div class="vt_keyboard_30px vt_keyboard_c2" style="width:60px;margin-left:10px;" data-key="alt">Control</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="22"><div class="vtken">A</div><br /><div class="vtkru">Ф</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="23"><div class="vtken">S</div><br /><div class="vtkru">Ы</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="24"><div class="vtken">D</div><br /><div class="vtkru">В</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="25"><div class="vtken">F</div><br /><div class="vtkru">А</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="26"><div class="vtken">G</div><br /><div class="vtkru">П</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="27"><div class="vtken">H</div><br /><div class="vtkru">Р</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="28"><div class="vtken">J</div><br /><div class="vtkru">О</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="29"><div class="vtken">K</div><br /><div class="vtkru">Л</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="30"><div class="vtken">L</div><br /><div class="vtkru">Д</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="31"><div class="vtken">:</div><br /><div class="vtkru">Ж</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="32"><div class="vtken">"</div><br /><div class="vtkru">Э</div></div>
<div class="vt_keyboard_30px vt_keyboard_c2" style="width:63px;" onclick="send_message(); return false;">EXECUTE</div>
</div>
<div class="vt_keyboard_2r">
<div class="vt_keyboard_30px vt_keyboard_c2" style="margin-left:10px;width:75px;" id="vt_keyboard_shift2" data-key="shift">&#8593;Shift</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="33"><div class="vtken">Z</div><br /><div class="vtkru">Я</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="34"><div class="vtken">X</div><br /><div class="vtkru">Ч</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="35"><div class="vtken">C</div><br /><div class="vtkru">С</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="36"><div class="vtken">V</div><br /><div class="vtkru">М</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="37"><div class="vtken">B</div><br /><div class="vtkru">И</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="38"><div class="vtken">N</div><br /><div class="vtkru">Т</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="39"><div class="vtken">M</div><br /><div class="vtkru">Ь</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="40"><div class="vtken">&#60;</div><br /><div class="vtkru">Б</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="41"><div class="vtken">&#62;</div><br /><div class="vtkru">Ю</div></div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c1" data-key="42">?<br />/</div>
<div class="vt_keyboard_30px vt_keyboard_c2" style="width:80px;" id="vt_keyboard_shift1" data-key="shift">&#8593;Shift</div>
</div>
<div class="vt_keyboard_last_r">
<div class="vt_keyboard_30px vt_keyboard_c2" style="margin-left:10px;width:60px;">Caps Lock</div>
<div class="vt_keyboard_30px vt_keyboard_c2" data-key="alt">Alt</div>
<div class="vt_keyboard_30px vt_keyboard_c2" style="font-size:10px;">&#9670;</div>
<div class="vt_keyboard_30px vt_keyboard_c1" style="width:260px;" data-key="43"></div>
<div class="vt_keyboard_30px vt_keyboard_c2" style="font-size:10px;">&#9670;</div>
<div class="vt_keyboard_30px_lh15 vt_keyboard_c2">Com-<br />pose</div>
<div class="vt_keyboard_30px vt_keyboard_c2" onclick="morse(); return false;">Morse</div>

</div>
</div>
<script>
var vt_shift=false;
var vt_enru=true;
var vt_key_arr = [['0',')','0',')'],//Первое число без Shift на английском. 3 без Shift на русском
	['1','!','1','!'],
	['2','@','2','@'],
	['3','#','3','#'],
	['4','$','4','$'],
	['5','%','5','%'],
	['6','^','6','^'],
	['7','&','7','&'],
	['8','*','8','*'],
    	['9','(','9','('],
	['q','Q','й','Й'],
	['w','W','ц','Ц'],
	['e','E','у','У'],
	['r','R','к','К'],
	['t','T','е','Е'],
	['y','Y','н','Н'],
	['u','U','г','Г'],
	['i','I','ш','Ш'],
	['o','O','щ','Щ'],
	['p','P','з','З'],
	['[','[','х','Х'],
	[']',']','ъ','Ъ'],
	['a','A','ф','Ф'],
	['s','S','ы','Ы'],
	['d','d','в','В'],
	['f','F','а','А'],
	['g','G','п','П'],
	['h','H','р','Р'],
	['j','J','о','О'],
	['k','K','л','Л'],
	['l','L','д','Д'],
	[':',';','ж','Ж'],
	['"',"'",'э','Э'],
	['z','Z','я','Я'],
	['x','X','ч','Ч'],
	['c','C','с','С'],
	['v','V','м','М'],
	['b','B','и','И'],
	['n','N','т','Т'],
	['m','M','ь','Ь'],
	['<',',','б','Б'],
	['>','.','ю','Ю'],
	['?','/','?','/'],
	[' ', ' ',' ',' '],
	['_','-','_','-'],
	['+','=','+','=']
	];



$(".vt_keyboard_c1").mouseup(function(){
      $(this).css('box-shadow', '3px 3px 3px rgba(0,0,0,0.8)');
	  $(this).css('margin-top', "0px");
	  
}).mousedown(function(){
	$(this).css('box-shadow', '3px 1px 3px rgba(0,0,0,0.8)');
	$(this).css('margin-top', "1px");
	var vt_tmp_var=0;
	if(vt_shift){vt_tmp_var+=1;}
	if(vt_enru){vt_tmp_var+=2;}
	oldbs = $("#user_input").html();
	$("#user_input").html(oldbs.replace('<br>', '')+vt_key_arr[$(this).data('key')][vt_tmp_var]);
});


$(".vt_keyboard_c2").mouseup(function(){
      $(this).css('box-shadow', '3px 3px 3px rgba(0,0,0,0.8)');
	  $(this).css('margin-top', "0px"); 
}).mousedown(function(){
	$(this).css('box-shadow', '3px 1px 3px rgba(0,0,0,0.8)');
	$(this).css('margin-top', "1px");
	if($(this).data('key') == 'shift')
	{
		if(vt_shift)
		{
			vt_shift=!vt_shift;
			$("#vt_keyboard_shift2").css('color','#FFF');
			$("#vt_keyboard_shift1").css('color','#FFF');
		}
		else
		{
			vt_shift=!vt_shift;
			$("#vt_keyboard_shift2").css('color','#B5DC2E');
			$("#vt_keyboard_shift1").css('color','#B5DC2E');
		}
	}
	else if($(this).data('key') == 'alt')
	{
		if(vt_shift)
		{
			vt_keyboard_en_ru();
			vt_shift=!vt_shift;
			$("#vt_keyboard_shift2").css('color','#FFF');
			$("#vt_keyboard_shift1").css('color','#FFF');
		}
	}
	else if($(this).data('key') == 'backspace')
	{
		oldbs = $("#user_input").html();
		$("#user_input").html(oldbs.substr(0, oldbs.length-1));
	}
});
	

function vt_keyboard_en_ru()
{
	if(vt_enru)
	{
		vt_enru=!vt_enru;
		$( '.vtken' ).css('color', '#EE746C');
		$( '.vtkru' ).css('color', '#F7F7F7');
	}
	else
	{
		vt_enru=!vt_enru;
		$( '.vtken' ).css('color', '#F7F7F7');
		$( '.vtkru' ).css('color', '#EE746C');
	}
}


function key_on_off()
{
	$("#vt_keyboard_body").css('top',($("#chat_users_output_body").offset().top-$("#vt_keyboard_body").height())+'px');
	$("#vt_keyboard_body").css('left',$("#user_input").offset().left+'px');
	document.getElementById('vt_keyboard_body').style.display = (document.getElementById('vt_keyboard_body').style.display == 'block')?'none':'block';
}

resize_window();
function resize_window()
{
	$("#print_usr_list").width($("#user_input").width()-$("#print_usr_list_right").width()+3+"px");
	window_height = $(window).height();
	main_menu_header_block_js = $("#main_menu_header_block").height()+1;
	document.getElementById('chat_left_body').style.height = window_height-main_menu_header_block_js+"px";
	document.getElementById('chat_right_body').style.height = window_height-main_menu_header_block_js+"px";
	document.getElementById('chat_frame').style.height = window_height-72-main_menu_header_block_js+"px";
	document.getElementById('users_check_online').style.height = window_height-1-$('#chat_profile_info_id_2').height()-main_menu_header_block_js+"px";
	$('#chat_frame').animate({scrollTop:'+=9999px'});
}
window.onresize=function(){resize_window();};




var tmptime=new Date().getTime();
var lasttime=new Date().getTime();
var morse_timeout_tr=false;
var morse_buffer="";
start_morse(35);

function start_morse(obj)
{
	$(document).keydown(function(e){
	        if(e.keyCode == obj)
		{
			if(morse_timeout_tr==true)
			{
				clearTimeout(morse_timeout);
			}
			tmptime=new Date().getTime();
			if(tmptime-lasttime > 300 && tmptime-lasttime < 700)morse_buffer+=" ";
			else if(tmptime-lasttime > 700)morse_buffer+=" | ";
		}
	}).keyup(function(e){
	        if(e.keyCode == obj)
		{
			if(new Date().getTime()-tmptime < 100)
			{

				morse_buffer+=".";
			}
			else
			{
				morse_buffer+="-";
			}
   			morse_timeout=setTimeout("morse_decode()", 300);
			morse_timeout_tr=true;
			lasttime=new Date().getTime();
		}
	});
}

function morse_decode()
{
	tmptime=new Date().getTime();

	obj=morse_buffer;
	obj=obj.split(' ');
	for (var i=0;i<obj.length;i++) 
	{
		divname_user_input.innerHTML = $("#user_input").html().replace('<br>', '')+morse_rpl(obj[i]);
		chat_input_focus();
		morse_buffer="";
	}
	morse_timeout_tr=false;
}

function morse_rpl(obj)
{
	switch (obj) {
        case "|": return " ";
        case ".-": return "a";
        case "-...": return "b";
        case ".--": return "w";
        case "--.": return "g";
        case "-..": return "d";
        case ".": return "e";
        case "...-": return "v";
        case "--..": return "z";
        case "..": return "i";
        case ".---": return "j";
        case "-.-": return "k";
        case ".-..": return "l";
        case "--": return "m";
        case "-.": return "n";
        case "---": return "o";
        case ".--.": return "p";
        case ".-.": return "r";
        case "...": return "s";
        case "-": return "t";
        case "..-": return "u";
        case "..-.": return "f";
        case "....": return "h";
        case "-.-.": return "c";
        case "---.": return "Ö";
        case "----": return "CH";
        case "--.-": return "q";
        case "--.--": return "Ñ";
        case "-.--": return "y";
        case "-..-": return "x";
        case "..-..": return "É";
        case "..--": return "Ü";
        case ".-.-": return "Ä";
        case ".----": return "1";
        case "..---": return "2";
        case "...--": return "3";
        case "....-": return "4";
        case ".....": return "5";
        case "-....": return "6";
        case "--...": return "7";
        case "---..": return "8";
        case "----.": return "9";
        case "-----": return "0";
        case "......": return ".";
        case ".-.-.-": return ",";
        case "---...": return ":";
        case "-.-.-.": return ";";
        case "-.--.-": return ")";
        case ".----.": return "'";
        case ".-..-.": return '"';
        case "-....-": return "-";
        case "-..-.": return "/";
        case "..--..": return "?";
        case "--..--": return "!";
        case ".---.": return "§";
        case "........": return "ошибка";
        case ".--.-.": return "@";
        case "..-.-": return "конец связи";
	default: return "";
	}
}


</script>


<?php
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
function write_ap($f, $c){$fw=fopen($f, 'a+');fwrite($fw, $c);fclose($fw);}


function GetInTranslit_fp_tr($string) {
    $replace = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => "'",  'ы' => 'y',   'ъ' => "'",
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
        'Ь' => "'",  'Ы' => 'Y',   'Ъ' => "'",
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
	return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}
?>
