<?php
	header("Content-Type: text/html; charset=UTF-8");
	session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/lang/lang_pack.php';
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/function/chat_fn.php';
	if(!isset($_SESSION['username']))
	{
		header("Location: http://".$_SERVER['HTTP_HOST'].'/index.php');
		exit('Чат только для зарегистрированных пользователей!');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head> 
	<link rel="SHORTCUT ICON" href="/engine/images/logo.svg" type="image/x-icon">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>...</title> 
	<link rel="SHORTCUT ICON" href="/favicon.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="engine/css/ih5.css">
	<link rel="stylesheet" type="text/css" href="engine/include/chat/chat.css">
	<script type="text/javascript" src="engine/java/scripts.js"></script>

</head> 



<body>
<?echo start_job();?>


<div id="iphone_chat_content">
<?
	echo load_start_messages();
?>
</div>

<div class="gradient" style="width:100%;background-color:#666666;" id="iphone_usr_panel">
<img class="iphone_mphfb" id="iphone_smile_button" onclick="smiles_on_off(); return false" src="/engine/images/iphone/sm_iphone.png"/>

<input class="iphone_mphfb " id="iphone_user_input" onKeyPress="send_message_enter(event)" type="text"/>

<div onclick="send_message();" class="iphone_mphfb cursor_pointer tx_align_center" style="font-size:45px;height:100px;line-height:100px;width:100px;color:#CCC;">&#8656;</div>
<img style="height:100px;width:100px;" onclick="chat_online_list(); return false;" src="/engine/images/iphone/send.png" alt="" class="iphone_mphfb cursor_pointer tx_align_center"/>

</div>

<div id="smilediv"></div>
<div id="chat_online_list"><div id="iphone_chat_online_list">
<div id="chat_users_online_text_female"></div>
<div id="chat_users_online_text_male"></div>
<div id="chat_users_online_text_guest"></div>
</div></div>
</body>
</html>



<style>
body{overflow:hidden;}
.classic{
position:fixed;
font-size:10px;
width:200px;
height:45px;
line-height:15px;
background-color:black;
color:white;
padding:5px;
}

body, html{margin:0 auto;padding:0;font-size:30px;height:100%;width:100%;}

.border_radius_iphone{border-radius: 10px;-moz-border-radius: 10px;-webkit-border-radius: 10px;}
.iphone_mphfb{
float:left;

border:0;margin:0;padding:0;
}

#iphone_smile_button{
height:100px;
width:100px;
}

#iphone_user_input{
font-size:42px;
height:96px;
border-top:2px solid #666666;
border-bottom:2px solid #666666;
}

#iphone_chat_content{
overflow:auto;
width:100%;
}

#chat_old_users_message, #chat_users_only_you, #chat_users_my_private_messages, #chat_users_private_messages, .chat_system_message, #chat_all_message_style{
line-height:35px;
}

.chat_sc{
min-height:75px;
}

#chat_usr_online_sex{
height:40px;
}
.chat_online_nick_js{
float:left;
}

.chat_users_online_frame:nth-child(odd){
background-color:#4F4F4F;
}

.iphone_height_online_status{
height:40px;
}

.chat_users_online_frame{list-style-type: none;height:40px;line-height: 40px;font-size:35px;}

#chat_online_list{
display:none; 
background-color:#5A5959; 
position: fixed;
top: 0%;
left: 0%;
text-shadow: #202020 1px 1px 1px;
}


</style>

<script>
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
var old_message_chat = "";
var ajax_chat_frame = $('#iphone_chat_content');
var divname_user_input = document.getElementById('iphone_user_input');

check_message();
check_chat_time();

function check_message()//Проверка обновлений
{
	$.get(
	"/engine/include/chat/check_message.php",
	function (data)
	{
		if(!data['m']=='')
		{
			if(chat_method == '0')
			{
				if(old_message_chat != data['m'])
				{
					ajax_chat_frame.append(data['m']);
					old_message_chat = data['m'];
					ajax_chat_frame.scrollTop(9999);//Скролл таблицы
				}
			}
			else
			{
				if(old_message_chat != data['m'])
				{
					ajax_chat_frame.prepend(data['m']);
					old_message_chat = data['m'];
				}
			}
		}
	});
    setTimeout("check_message()", 500);
}

function check_chat_time()
{
	$.get("/engine/include/chat/check_chat_time.php");
	setTimeout("check_chat_time()", 60000);
}



function print_message(obj)
{
	divname_user_input.focus();
	if (!divname_user_input.value.match(obj.innerText))
	{
		divname_user_input.value = obj.innerText+", "+divname_user_input.value;//Заполняем ником и тем что было
	}
}


function send_message_enter(event) 
{
	event = event || window.event
	 if(event.keyCode==13)
	 {
		send_message();//После нажатия Enter отправить на функцию отправки...
	 }
}


function send_message() 
{
	if(divname_user_input.value != "")
	{
		if(chat_method == '0')
		{
			ajax_chat_frame.scrollTop(9999);//Скролл таблицы
		}
		
		$.post(
		"/engine/include/chat/burn_message.php",
		{ 
			message: divname_user_input.value
		},
		function (data)
		{
			divname_user_input.value = '';
		});
	}
}


$("#iphone_user_input").focus(function() {
if(document.getElementById('smilediv').style.display=="block")
{
	document.getElementById("chat_smile_content").style.cssText="width:100%; height:"+$(window).height()/2+"px;"; 
}
}).blur(function() {
if(document.getElementById('smilediv').style.display=="block")
{
	document.getElementById("chat_smile_content").style.cssText="width:100%; height:"+$(window).height()/2+"px;"; 
}
});

function smiles_on_off()
{
	document.getElementById('smilediv').style.display = (document.getElementById('smilediv').style.display == 'none')?'block':'none'; 
}
document.getElementById("smilediv").style.cssText="display:none;color:white;background:#5A5959; position: fixed;top: 0%;left: 0%;";
document.getElementById('smilediv').innerHTML = '<div id="chat_smile_content">'+
	file_get_contents_js('/engine/images/smile_html/main.txt')+'</div><div style="font-size:30px;line-height:40px;">'+
	'<b class="chat_smile_content_tx" onclick=load_smile_content("main")>Основные</b> '+
	'<b class="chat_smile_content_tx" onclick=load_smile_content("food")>еда</b> '+
	'<b class="chat_smile_content_tx" onclick=load_smile_content("dance")>танцы</b> '+
	'<b class="chat_smile_content_tx" onclick=load_smile_content("music")>музыка</b> '+
	'<b class="chat_smile_content_tx" onclick=load_smile_content("love")>любовь</b> '+
	'<b class="chat_smile_content_tx" onclick=load_smile_content("job")>работа</b> '+
	'<b class="chat_smile_content_tx" onclick=load_smile_content("trollface")>trollface</b> '+
	'<b class="chat_smile_content_tx" onclick=load_smile_content("computer")>компьютеры</b> '+
	'<b class="chat_smile_content_tx" onclick=load_smile_content("friends")>дружба</b> '+
	'<b class="chat_smile_content_tx" onclick=load_smile_content("weapon")>оружие</b> '+
	'<b class="chat_smile_content_tx" onclick=load_smile_content("sport")>спорт</b> '+
	'<b class="chat_smile_content_tx" onclick=load_smile_content("holiday")>выпивка</b> '+
	'</div>';
document.getElementById("chat_smile_content").style.cssText="width:100%; height:"+$(window).height()/2+"px;"; 

function load_smile_content(obj)
{
	document.getElementById('chat_smile_content').innerHTML=file_get_contents_js('/engine/images/smile_html/'+obj+'.txt');
}

function onclick_smile(obj) 
{
	var test = obj.src;
	divname_user_input.value+= "(" + test.substring(test.lastIndexOf('/')+1,test.length) + ")";//Узнает имя картинки
	divname_user_input.focus();//Фокус на поле после отправки
	smiles_on_off();
}




function chat_online_list()
{
	get_online_iphone_list();
	document.getElementById('chat_online_list').style.display = (document.getElementById('chat_online_list').style.display == 'block')?'none':'block'; 
}
document.getElementById("iphone_chat_online_list").style.cssText="width:"+$(window).width()+"px; height:"+$(window).height()/2+"px;"; 

function get_online_iphone_list()
{
	$.get(
	"/engine/include/chat/check_online.php",
	function (data)
	{
		document.getElementById('chat_users_online_text_female').innerHTML = data['online_female'];
		document.getElementById('chat_users_online_text_male').innerHTML = data['online_male'];
		document.getElementById('chat_users_online_text_guest').innerHTML = data['online_guest'];
	});
}


function send_onclick_username_on(ff)
{
	$.post("/engine/include/chat/function/load_profile_info.php",{ username_click: ff},
	function (data)
	{
		divname_user_input.focus();
		if (!divname_user_input.value.match(data['users_name']))
		{
			divname_user_input.value = data['users_name']+", "+divname_user_input.value;//Заполняем ником и тем что было
		}
	});
	chat_online_list();
}


check_online();
function check_online()
{
	$.get(
	"/engine/include/chat/check_online.php",
	function (data)
	{

	});
    setTimeout("check_online()", 10000);
}

resize_window();
function resize_window()
{
	window_height = $(window).height();
	window_width = $(window).width();
	$('#iphone_chat_content').css('height', window_height-100);
	$('#iphone_usr_panel').css('height', 100);
	$('#iphone_user_input').css('width', window_width-300)
}
window.onresize=function(){resize_window();};

$("#iphone_user_input").focus(function() {
if(document.getElementById('smilediv').style.display=="block")
{
	document.getElementById("chat_smile_content").style.cssText="width:100%; height:"+$(window).height()/2+"px;"; 
}
}).blur(function() {
if(document.getElementById('smilediv').style.display=="block")
{
	document.getElementById("chat_smile_content").style.cssText="width:100%; height:"+$(window).height()/2+"px;"; 
}
});

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