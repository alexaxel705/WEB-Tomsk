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
function page_title(){return "Друзья пользователя ".file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/login_translit.txt');}
?>

<div id="users_blank_legend">
<div id="users_blank_legend_text">
<? 
	echo '<b>'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/login_translit.txt').'</b>'; 
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
		<div id="users_blank_float_left_block_cont_start" class="tx_align_center bg_c_FFFFFF"><a href="/database/profile.php?<? echo $_SERVER['QUERY_STRING'];?>">Анкета</a></div>
		<div class="users_blank_float_left_block_cont tx_align_center bg_c_F7F7F7"><a href="/database/friends.php?<? echo $_SERVER['QUERY_STRING'];?>">Друзья 
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



<div class="usr_page_pdn_r">
<div id="usr_blank_body_info">
<?
$new_usr_f='';$old_usr_f='';$adv_old_usr_f='';
$dir = $_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/friends/'; 
if(is_dir($dir)) 
{ 
	$files = scandir($dir);
	array_shift($files);
	array_shift($files);
	for($i=0; $i<sizeof($files); $i++)
	{
		$files[$i] = substr($files[$i], 0, strlen($files[$i]) - 1);//Удаляем .txt
		$files[$i] = substr($files[$i], 0, strlen($files[$i]) - 1);			
		$files[$i] = substr($files[$i], 0, strlen($files[$i]) - 1);
		$files[$i] = substr($files[$i], 0, strlen($files[$i]) - 1);
		$tr = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$files[$i].'/login_translit.txt');
		$fr_avatar = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$files[$i].'/avatar.txt');
		if(file_get_contents($dir.$files[$i].'.txt') == '0')
		{
			$new_usr_f = $new_usr_f.'<div style="height:25px;line-height:25px;width:100%;"><img style="height:25px;width:25px;" alt="" class="left" src="/database/users/'.$files[$i].'/'.$fr_avatar.'"/><a style="padding-left:2px;" class="left"  href="/database/profile.php?'.$files[$i].'">'.$tr.'</a><a style="padding-left:5px;" href="/engine/include/users/friends_act.php?name='.$files[$i].'&act=0">принять</a> <a href="/engine/include/users/friends_act.php?name='.$files[$i].'&act=1">отклонить</a></div>';
		}
		else
		{
			if(isset($_SESSION['username']))
			{
				if($_SESSION['username'] == $_SERVER['QUERY_STRING'])
				{
					$adv_old_usr_f='<sup><a href="/engine/include/users/friends_act.php?name='.$files[$i].'&act=1">удалить</a></sup>';
				}
			}
			$old_usr_f = $old_usr_f.'<div style="height:25px;line-height:25px;width:100%;"><img style="height:25px;width:25px;" alt="" class="left" src="/database/users/'.$files[$i].'/'.$fr_avatar.'"/><a style="padding-left:2px;" class="left"  href="/database/profile.php?'.$files[$i].'">'.$tr.'</a>&nbsp;'.$adv_old_usr_f.'</div>';
		}
	}
}
?>


<?
if(isset($_SESSION['username']))
{
	if($_SESSION['username'] == $_SERVER['QUERY_STRING'])
	{
		echo $new_usr_f;
	}
}
if($old_usr_f == '')
{
	echo 'У '.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/login_translit.txt').' нет друзей';
}
else
{
	echo $old_usr_f;
}
?>
</div>
</div>
</div>




<?
	include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
</div>
</html>
