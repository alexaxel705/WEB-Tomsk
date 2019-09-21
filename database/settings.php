<?
	include $_SERVER['DOCUMENT_ROOT'].'/head_menu.php';
	include $_SERVER['DOCUMENT_ROOT'].'/database/database_fn.php';
	if(!isset($_SESSION['username']))exit('Доступно после регистрации.');
	else
	{
		$conf=json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_cfg.arr'));
	}
	function page_title(){return "Настройки";}
?>
<div id="users_blank_legend">
<div id="users_blank_legend_text">
<? 
	echo '<b>'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt').'</b>'; 
	echo ' <sup style="color:green;">'.get_time(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/last_visit.txt')).'</sup>';
?>
</div>


</div>



<div id="blank_content-body">

<div id="usr_blank_body_background_color">


<div id="users_blank_float_left_block_150">
	<div id="users_blank_float_left_block_130">
		<div id="users_blank_float_left_block_cont_start" class="tx_align_center bg_c_FFFFFF"><a href="/database/profile.php?<? echo $_SESSION['username'];?>">Анкета</a></div>
		<div class="users_blank_float_left_block_cont tx_align_center bg_c_FFFFFF"><a href="/database/friends.php?<? echo $_SESSION['username'];?>">Друзья 
		<? echo gfc_old($_SESSION['username']).gfc_new($_SESSION['username']); ?>
		</a></div>
		<div class="users_blank_float_left_block_cont tx_align_center bg_c_F7F7F7"><a href="/database/settings.php">Настройки</a></div>
		<div class="users_blank_float_left_block_cont tx_align_center bg_c_FFFFFF"><a href="/database/album.php?<? echo $_SESSION['username'];?>">Альбом</a></div>
		<div id="users_blank_float_left_block_cont_end" class="tx_align_center bg_c_FFFFFF"><a href="/database/blog.php?u=<? echo $_SESSION['username'];?>">Блог</a></div>
		</div>
		<div id="users_blank_float_left_block_advanced"><div id="users_blank_float_left_block_advanced2"></div>
	</div>
</div>



<div id="usr_page_pdn_r_main">

<center>
<div style="margin-left:150px;">
	<fieldset style="border-radius:5px;margin-top:5px;"><legend>Редактирование вашего профиля</legend>
	Аватар: <br /><img style="width:100px;height:100px;" id="upload_avatar_img" src="/database/users/<? echo $_SESSION['username'];?>/<? echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/avatar.txt');?>"/><br />
<form action="/engine/include/users/page/upload_avatar.php" name="uploadForm" id="avatar_form" method="post" target="hiddenframe" enctype="multipart/form-data"
onsubmit="document.getElementById('res').innerHTML=''; return true;">
<input type="file" name="userfile" onchange="document.getElementById('avatar_form').submit();" style="width:100px;"/>
</form>
<div id="res"></div>
<iframe id="hiddenframe" name="hiddenframe" style="width:0; height:0; border:0"></iframe><br />
	
		Пол: <br />
		<select name="menu" size="1" id="id_sex">
		<option value="1" <?if(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/sex.txt') == 1)echo 'selected';?>>Мужской</option>
		<option value="2" <?if(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/sex.txt') == 2)echo 'selected';?>>Женский</option>
		</select><br /><br />
	
		Имя:<br />
		<input type="text" id="usr_real_name" value="<? echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/usr_real_name.txt');?>"/><br />
	
		Город:<br />
		<input type="text" id="settings_geo_loc" value="<?echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/location.txt');?>"/><br />

			
	
		Текущий пароль:<br />
		<input type="text" id="old_passwd"/><br />

		Новый пароль:<br />
		<input type="text" id="new_passwd"/><br />

		Подтвердите пароль:<br />
		<input type="text"/ id="new_passwd_ok"><br />
		

	<br /><div class="big_settings_str">О себе</div>
	<textarea id="textarea_my_info_1"><?
		$old = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/o_sebe.txt');
		$old = str_replace('<br />',"\r\n",$old);
		echo $old;
	?></textarea><br />
	<br />
	
	<br /><br /><div class="big_settings_str">Контакты</div>
	ICQ:<br />
	<input type="text" id="icq" value="<?
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/icq.txt'))
	{
		echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/icq.txt');
	}
	?>"/><br />
	Телефонный номер:<br />
	<input type="text" id="cell_phone" value="<?
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/cell_phone.txt'))
	{
		echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/cell_phone.txt');
	}
	?>"/><br />
	Электронная почта:<br />
	<input type="text" id="e_mail" value="<?
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/e_mail.txt'))
	{
		echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/e_mail.txt');
	}
	?>"/><br />
			
	<button onclick="send_settings()">Отправить</button>
	<div id="output_1"></div>
</fieldset>
	
	
<fieldset><legend>Настройка соединений</legend>
	<?		
		$set_connection = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/set_connection.arr'));
		$traffic = 0;
		if($set_connection['head_update'] == 1)
		{
			$check_head_update = 'checked';
			$traffic += 9;
		}
	?>
	<b>Текущая конфигурация: <span id="traffic_out"><? echo $traffic;?></span> байт\сек</b><br /><br />
	Проверять новые сообщения в анкете?<input type="checkbox" id="checkbox_head_update" <? echo $check_head_update;?>> (9 байт\сек)<br />
	<button onclick="send_internet_connection_settings()">Отправить</button>
	<div id="output_2"></div>
</fieldset>
	
	
<fieldset><legend>Настройка чата</legend>
Новые сообщения в чате:
<select name="menu" size="1" id="chat_t_or_b">
<option value="0" <?if($conf[0] == '0')echo 'selected';?>>Снизу</option>
<option value="1" <?if($conf[0] == '1')echo 'selected';?>>Сверху</option>
</select><br />


Смайлы в чате:
<?

?>
<input type="checkbox" id="chat_smile_on_off" <?if($conf[2] == 'true')echo 'checked';?>><br />





<button onclick="send_chat_settings()">Отправить</button>
<div id="output_3"></div>
</fieldset><br />


</center></div>


<script type="text/javascript" src="/engine/java/scripts.js"></script>
<script>
function avatar_upload_ok(obj)
{
	document.getElementById("res").innerHTML="Аватар успешно загружен.";
	$('#upload_avatar_img').attr("src","http://"+window.location.host+obj);
}
function send_chat_settings()
{
	$.post("/engine/include/users/settings_act.php",
	{
		config: '3',
		chat_t_or_b: document.getElementById('chat_t_or_b').value,
		chat_smile_on_off: $("#chat_smile_on_off").prop('checked')
	},
	function (data)
	{
		document.getElementById("output_3").innerHTML = data['out'];
	});
}

function send_internet_connection_settings()
{
	$.post("/engine/include/users/settings_act.php",
	{
		config: '2',
		head_update: document.getElementById("checkbox_head_update").checked
	},
	function (data)
	{
		document.getElementById("output_2").innerHTML = data['out'];
		document.getElementById("traffic_out").innerHTML = data['traffic'];
	});
}

function send_settings()
{
	$.post("/engine/include/users/settings_act.php",
	{
		config: '1',
		geoloc: document.getElementById('settings_geo_loc').value,
		sex: document.getElementById('id_sex').value,
		usr_real_name: document.getElementById('usr_real_name').value,
		o_sebe: document.getElementById("textarea_my_info_1").value,
		old_passwd: document.getElementById("old_passwd").value,
		new_passwd: document.getElementById("new_passwd").value,
		new_passwd_ok: document.getElementById("new_passwd_ok").value,
		icq: document.getElementById("icq").value,
		cell_phone: document.getElementById("cell_phone").value,
		e_mail: document.getElementById("e_mail").value
	},
	function (data)
	{
		document.getElementById("output_1").innerHTML = data['out'];
	});
}



</script>


<style>
.settings_left{
width:50%;
float:left;
border:1px solid black;
margin:-1px;
}
.settings_right{
width:50%;
float:left;
border:1px solid black;
margin:-1px;
}
.big_settings_str{
width:100%;
font-size:15px;
}
#textarea_my_info_1{
width:70%;
height:150px;
}
</style>