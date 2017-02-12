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
function page_title(){return "Альбом ".file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/login_translit.txt');}
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
		<div class="users_blank_float_left_block_cont tx_align_center bg_c_F7F7F7"><a href="/database/album.php?<? echo $_SERVER['QUERY_STRING'];?>">Альбом</a></div>
		<div id="users_blank_float_left_block_cont_end" class="tx_align_center bg_c_FFFFFF"><a href="/database/blog.php?u=<? echo $_SERVER['QUERY_STRING'];?>">Блог</a></div>
		</div>
		<div id="users_blank_float_left_block_advanced"><div id="users_blank_float_left_block_advanced2"></div>
	</div>
</div>



<div class="usr_page_pdn_r">
<div id="usr_blank_body_info">
<?
    $old_usr_p='';$remove='';
    $dir = $_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SERVER['QUERY_STRING'].'/album/'; 
    if(is_dir($dir)) 
	{ 
         $files = scandir($dir);
         array_shift($files);
         array_shift($files);
         for($i=0; $i<sizeof($files); $i++)
		 {
			if(isset($_SESSION['username']))
			{
		 		if($_SERVER['QUERY_STRING'] == $_SESSION['username'])
				{
					$remove = '<div style="width:100%;height:25px;"><button class="album_close cursor_pointer" onclick=album_remove_photo("'.$files[$i].'")>Удалить</button></div>';
				}
			}
			$old_usr_p.= '<div class="album_photo_size">
			<div class="album_photo_padding">
				<img onclick=blank_view_photo("/database/users/'.$_SERVER['QUERY_STRING'].'/album/'.$files[$i].'") style="width:100%;height:100%;" src="/database/users/'.$_SERVER['QUERY_STRING'].'/album/'.$files[$i].'"/>
			</div>'.$remove.'</div>';
		 }
    }
?>

<?
if($old_usr_p == '')echo 'Альбом пуст.';
else echo $old_usr_p;

if(isset($_SESSION['username']))
{
	if($_SESSION['username'] == $_SERVER['QUERY_STRING'])
	{
		echo '<div class="album_load_photo_div"><form action="/engine/include/users/page/upload_photo.php" name="uploadForm" method="post" id="albumform" enctype="multipart/form-data">
		<input type="hidden" name="method" value="1"/>
		<input type="hidden" name="page" value="'.$_SERVER['REQUEST_URI'].'"/>
		<input type="file" name="userfile" id="testss"/>
		<input type="submit" value="Отправить"/>
		</form></div>';
	}
}
?>
</div>
</div>
</div>


<div id="blank_photo_hidden" onclick="blank_view_photo()"></div>
<script>
document.getElementById('blank_photo_hidden').style.cssText="display:none;";
</script>


<?
	include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
</div>
</html>
