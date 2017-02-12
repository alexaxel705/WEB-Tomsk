<?
$_SERVER['QUERY_STRING'] = str_replace("%27", "'", $_SERVER['QUERY_STRING']);
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING']) &&
!empty($_SERVER['QUERY_STRING']) &&
$_SERVER['QUERY_STRING'] != '.' &&
$_SERVER['QUERY_STRING'] != '..')
{
	include $_SERVER['DOCUMENT_ROOT'].'/head_menu.php';
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	include $_SERVER['DOCUMENT_ROOT'].'/database/database_fn.php';
}
else exit;
function page_title(){return "Страница пользователя ".file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/login_translit.txt');}
?>
<div itemscope itemtype="http://schema.org/Person"> 
<div id="users_blank_legend">
<div id="users_blank_legend_text">
<? 
	echo '<b itemprop="additionalName">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/login_translit.txt').'</b>'; 
	echo ' <sup style="color:green;">'.get_time(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/last_visit.txt')).'</sup>';
?>
</div>
<? 
if (isset($_SESSION['username']))
{
	if($_SESSION['username'] != $_SERVER['QUERY_STRING'])
	{
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/friends/'.$_SESSION['username'].'.txt')) 
		{
			echo '<div class="right" id="users_blank_legend_text_right"><a href="/engine/include/users/add_friends.php?name='.$_SERVER['QUERY_STRING'].'" style="color:gray;">Добавить в друзья</a></div>';
		}
		else
		{
			if(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/friends/'.$_SESSION['username'].'.txt') == '0')echo '<div class="right" id="users_blank_legend_text_right">Вы отправили запрос на дружбу!</div>';
		}
	}
}
?>


</div>


<div id="blank_content-body">
<div id="usr_blank_body_background_color">


<div id="users_blank_float_left_block_150">
	<div id="users_blank_float_left_block_130">
		<div id="users_blank_float_left_block_cont_start" class="tx_align_center bg_c_F7F7F7"><a href="/database/profile.php?<? echo $_SERVER['QUERY_STRING'];?>">Анкета</a></div>
		<div class="users_blank_float_left_block_cont tx_align_center bg_c_FFFFFF"><a href="/database/friends.php?<? echo $_SERVER['QUERY_STRING'];?>">Друзья 
		<? echo gfc_old($_SERVER['QUERY_STRING']).gfc_new($_SERVER['QUERY_STRING']); ?>
		</a></div>
		<?
		if(isset($_SESSION['username']))
		{
			if($_SESSION['username'] == $_SERVER['QUERY_STRING'])
			{
				echo '<div class="users_blank_float_left_block_cont tx_align_center bg_c_FFFFFF"><a href="/database/settings.php">Настройки</a></div>';
			}
		}
		?>
		<div class="users_blank_float_left_block_cont tx_align_center bg_c_FFFFFF"><a href="/database/album.php?<? echo $_SERVER['QUERY_STRING'];?>">Альбом</a></div>
		<div id="users_blank_float_left_block_cont_end" class="tx_align_center bg_c_FFFFFF"><a href="/database/blog.php?u=<? echo $_SERVER['QUERY_STRING'];?>">Блог</a></div>
		</div>
		<div id="users_blank_float_left_block_advanced"><div id="users_blank_float_left_block_advanced2"></div>
	</div>
</div>






<div class="usr_page_pdn_r_main">
<div id="usr_blank_body_info">
<div id="usr_blank_body_info_cont">
<dl>
<dt id="usr_blank_body_info_big_str_top">Информация</dt>
<? if(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/usr_real_name.txt') != '')echo '<dd class="usr_blank_body_info_design">Имя: <span itemprop="name">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/usr_real_name.txt').'</span></dd>';?>
<dd class="usr_blank_body_info_design">Пол: <span itemprop="gender"><? 
if(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/sex.txt') == '2')echo 'Женский';
else echo 'Мужской';
?></span></dd>
<dd class="usr_blank_body_info_design">Дата регистрации: <? echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/reg_time.txt');?></dd>
<dd class="usr_blank_body_info_design">Последний визит: <? echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/last_visit.txt');?></dd>
<dt class="usr_blank_body_info_big_str">О себе</dt>
<dd class="usr_blank_body_info_design"><? echo file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/o_sebe.txt');?></dd>

<dt class="usr_blank_body_info_big_str">Контакты</dt>
<?
$a_connect = 0;
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/icq.txt'))
{
	$a_connect++;
	echo '<dd class="usr_blank_body_info_design">ICQ: '.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/icq.txt').'</dd>';
}
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/cell_phone.txt'))
{
	$a_connect++;
	echo '<dd class="usr_blank_body_info_design" itemprop="telephone">Номер телефона: <span itemprop="cell">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/cell_phone.txt').'</span></dd>';
}
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/e_mail.txt'))
{
	$a_connect++;
	echo '<dd class="usr_blank_body_info_design">Электронная почта: <a href="mailto:'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/e_mail.txt').'" itemprop="email">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/e_mail.txt').'</a></dd>';
}
if($a_connect == 0)echo '<dd class="usr_blank_body_info_design">Контактных данных нет</dd>';
?>
</dl>
<div class="usr_blank_body_info_big_str">Доска 
<? 
if(isset($_SESSION['username']))
{
	if($_SERVER['QUERY_STRING']==$_SESSION['username'])
	{
		if(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/board_news.txt') != "0")write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/board_news.txt', '0');
		echo ' <sup><a href="/engine/include/users/remove_all_board_message.php">очистить</a></sup>';
	}
}
?>
</div>
<div>


<form action="/engine/include/users/add_board_message.php" method="post" style="padding:0 10px;">
	<textarea id="usr_blank_input_board" name="message"></textarea>
	<input type="hidden" name="usr" value="<? echo $_SERVER['QUERY_STRING'];?>">
	<input type="submit" value="Отправить">
</form>
</div>




<br />

<?
$arr = array_reverse(unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/board.arr')));
foreach($arr  as  $key => $value)
{
echo '<center>
	<div id="blank_usr_board_an">
		<div id="blank_usr_board_an_head">
			<div id="blank_usr_an_txt" class="left">
				<a href="/database/profile.php?'.$arr[$key]['w'].'">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$arr[$key]['w'].'/login_translit.txt').'</a>
			</div>';
			if(isset($_SESSION['username']))
			{
				if($_SESSION['username'] == $_SERVER['QUERY_STRING'] || $_SESSION['username'] == $arr[$key]['w'])
				{
					echo '<div id="blank_usr_an_trash_icon"><a class="right" href="/engine/include/users/remove_board_message.php?id='.(count($arr)-$key-1).'&usr='.$_SERVER['QUERY_STRING'].'"><img src="/engine/images/trash_page.gif"/></a></div>';
				}
			}
		echo '</div>
		<div id="blank_usr_board_an_photo">
		<img  id="blank_usr_board_an_usr_avatar_size" src="/database/users/'.$arr[$key]['w'].'/'.file_get_contents($_SERVER['DOCUMENT_ROOT']."/database/users/".$arr[$key]['w']."/avatar.txt").'"/>
		<span style="font-size:8px;color:green;">'.get_time(file_get_contents($_SERVER['DOCUMENT_ROOT']."/database/users/".$arr[$key]['w']."/last_visit.txt")).'</span>
		</div>
		<div id="blank_usr_board_an_cont_p">
			<div id="blank_usr_board_an_cont_border">
				<div id="blank_usr_board_an_cont">
				<div id="blank_usr_an_txt" class="left">'.$arr[$key]['m'].'</div>
			</div>
			<div id="blank_usr_board_an_footer">
				<div class="pdng-r-5px">'.$arr[$key]['d'].'</div>
			</div>
		</div>
	</div>
</div>
</center><br />';
}
?>




	

</div>







</div>
</div>


<div id="blank_right_body">

<div id="usr_blank_photo_str" class="tx_align_center">Фото</div>
<div id="usr_blank_photo">
<div id="usr_blank_photo_body_cont">
<?
	$btn_fs_src = '';
	if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/photo.txt'))
	{
		echo '<img  itemprop="image" id="usr_blank_photo_body" class="js_border_radius_10" alt="" src="/engine/images/no_photo.jpg"/>';
		$btn_fs_src = '/engine/images/no_photo.jpg';
	}
	else
	{
		$photo = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/photo.txt');
		echo '<img itemprop="image" id="usr_blank_photo_body" alt="" class="js_border_radius_10" src="/database/users/'.GetInTranslit(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/login_translit.txt')).'/photo/'.$photo.'"/>';
		$btn_fs_src = '/database/users/'.GetInTranslit(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/login_translit.txt')).'/photo/'.$photo;
	}
?>
</div>

<?
	if (isset($_SESSION['username']))
	{
		if($_SESSION['username'] == $_SERVER['QUERY_STRING'])
		{
			echo '<button id="usr_blank_photo_load" class="cursor_pointer width_50pr" onclick="load_upload_avatar()">Загрузить</button><button id="usr_blank_photo_load" class="cursor_pointer width_50pr" onclick=blank_view_photo("'.$btn_fs_src.'")>Просмотр</button>';
		}
		else
		{
			echo '<button id="usr_blank_photo_load" class="width_100pr" onclick=blank_view_photo("'.$btn_fs_src.'")>Просмотр</button>';
		}
	}
?>

<div id="blank_form_upload_photo">
<form action="/engine/include/users/page/upload_photo.php" name="uploadForm" method="post" style="display:none;" id="avatarform" enctype="multipart/form-data">
<input type="hidden" name="method" value="0"/>
	<input type="hidden" name="page" value="<? echo $_SERVER['REQUEST_URI'];?>"/>
<input type="file" name="userfile" id="testss" onchange="document.getElementById('avatarform').submit();"/>
</form>
</div>


</div>

<div id="usr_blank_friends_str" class="tx_align_center">Друзья в сети</div>
<div id="friends_online_block">
<? 
	$dir = $_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/friends/'; 
	$cf=0;
	if(is_dir($dir)) 
	{ 
	$files = scandir($dir);
	array_shift($files);
	array_shift($files);
	for($i=0; $i<sizeof($files); $i++)
	{
			if(file_get_contents($dir.$files[$i]) == '1')
			{
				$files[$i] = substr($files[$i], 0, strlen($files[$i]) - 4);
				$f_time = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$files[$i].'/last_visit.txt');
				if(get_time($f_time)=='онлайн')
				{
					$real_name = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$files[$i].'/login_translit.txt');
					$avatar = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$files[$i].'/avatar.txt');
					if($cf==0)echo '<a href="/database/profile.php?'.$files[$i].'">'.$real_name.'</a>';
					else echo ', <a href="/database/profile.php?'.$files[$i].'">'.$real_name.'</a>';
					$cf++;
				}
			}
		}
	}
	if($cf==0)echo 'Нет друзей в сети.';
?>
</div>
</div>


<?
	include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>


</div>


<div id="blank_photo_hidden" onclick="blank_view_photo()"></div>




<script>
document.getElementById('blank_photo_hidden').style.cssText="display:none;";

function load_upload_avatar()
{
	document.getElementById("avatarform").style.display = (document.getElementById("avatarform").style.display == "none")?"block":"none";
}
</script>


</div>
</div>

