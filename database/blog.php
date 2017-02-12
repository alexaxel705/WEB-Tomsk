<?
$_GET['u'] = str_replace("%27", "'", $_GET['u']);
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['u']) &&
!empty($_GET['u']) &&
$_GET['u'] != '.' &&
$_GET['u'] != '..')
{
	include $_SERVER['DOCUMENT_ROOT'].'/head_menu.php';
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	include $_SERVER['DOCUMENT_ROOT'].'/database/database_fn.php';
}
else exit;

if(isset($_GET['o']))
{
	$arr=unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['u'].'/blog.arr'));
	if(!isset($arr[$_GET['o']]))exit('Такой страницы нет.');
}

function page_title()
{
	if(isset($_GET['o']))
	{
		$arr=unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['u'].'/blog.arr'));
		return $arr[$_GET['o']]['n'];
	}
	else
	{
		return "Блог пользователя ".file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['u'].'/login_translit.txt');
	}
}

?>
<div itemscope itemtype="http://schema.org/Blog">
<div id="users_blank_legend">
<div id="users_blank_legend_text">
<? 
	echo '<b itemprop="author">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['u'].'/login_translit.txt').'</b>'; 
	echo ' <sup style="color:green;">'.get_time(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['u'].'/last_visit.txt')).'</sup>';
?>
</div>
<? 
if (isset($_SESSION['username']))
{
	if($_SESSION['username'] != $_GET['u'])
	{
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['u'].'/friends/'.$_SESSION['username'].'.txt')) 
		{
			echo '<div class="right" id="users_blank_legend_text_right"><a href="/engine/include/users/add_friends.php?name='.$_GET['u'].'" style="color:gray;">Добавить в друзья</a></div>';
		}
		else
		{
			if(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['u'].'/friends/'.$_SESSION['username'].'.txt') == '0')echo '<div class="right" id="users_blank_legend_text_right">Вы отправили запрос на дружбу!</div>';
		}
	}
}
?>


</div>






<div id="blank_content-body">
<div id="usr_blank_body_background_color">


<div id="users_blank_float_left_block_150">
	<div id="users_blank_float_left_block_130">
		<div id="users_blank_float_left_block_cont_start" class="tx_align_center bg_c_FFFFFF"><a href="/database/profile.php?<? echo $_GET['u'];?>">Анкета</a></div>
		<div class="users_blank_float_left_block_cont tx_align_center bg_c_FFFFFF"><a href="/database/friends.php?<? echo $_GET['u'];?>">Друзья 
		<? echo gfc_old($_GET['u']).gfc_new($_GET['u']); ?>
		</a></div>
		<?
		if(isset($_SESSION['username']))
		{
			if($_SESSION['username'] == $_GET['u'])
			{
				echo '<div class="users_blank_float_left_block_cont tx_align_center bg_c_FFFFFF"><a href="/database/settings.php">Настройки</a></div>';
			}
		}
		?>
		<div class="users_blank_float_left_block_cont tx_align_center bg_c_FFFFFF"><a href="/database/album.php?<? echo $_GET['u'];?>">Альбом</a></div>
		<div id="users_blank_float_left_block_cont_end" class="tx_align_center bg_c_F7F7F7"><a href="/database/blog.php?u=<? echo $_GET['u'];?>">Блог</a></div>
		</div>
		<div id="users_blank_float_left_block_advanced"><div id="users_blank_float_left_block_advanced2"></div>
	</div>
</div>


<div class="usr_page_pdn_r">
<div id="usr_blank_body_info">
<?
	$arr=unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['u'].'/blog.arr'));
	$me='';$add='';$out='';$adv='';
	if(isset($_SESSION['username']))
	{
		if($_GET['u']==$_SESSION['username'])
		{
			$me=1; 
			$add='<a href="blog.php?u='.$_GET['u'].'&amp;add=1">Добавить запись</a><br /><br />';
			if(isset($_GET['rm']))
			{
				unset($arr[$_GET['rm']]);
				write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/blog.arr', serialize($arr));
			}
		}
	}
	if(isset($_GET['o']))
	{
		$search  = array(
			'&lt;br /&gt;[spoiler]',
			'[/spoiler]&lt;br /&gt;',
			'&lt;br /&gt;[spoiler]',
			'[/spoiler]&lt;br /&gt;',
			'&lt;br /&gt;[img]',
			'[/img]&lt;br /&gt;'
		);
		$replace  = array(
			'[spoiler]',
			'[/spoiler]',
			'[spoiler]',
			'[/spoiler]',
			'[img]',
			'[/img]'
		);
		
	 	$arr[$_GET['o']]['m'] = str_replace($search , $replace,  $arr[$_GET['o']]['m']);

		$search = array(
			'/\[link\](.*?)\[\/link\]/is',	
			'/\[code\](.*?)\[\/code\]/is',
			"~&lt;br /&gt;~",
			'/\[left\](.*?)\[\/left\]/is',
			'/\[right\](.*?)\[\/right\]/is',
			'/\[center\](.*?)\[\/center\]/is',
			'/\[img\](.*?)\[\/img\]/is',
			'/\[spoiler\](.*?)\[\/spoiler\]/is'
		);
		$replace = array(
			'<a href="$1" title="$1">$1</a>',
			'<code>$1</code>',
			"<br />",
			'<div class="left">$1</div>',
			'<div class="right">$1</div>',
			'<div class="center">$1</div>',
			'<img onclick=\'blank_view_photo("$1"); return false;\' src="$1" class="blog_img" alt="$1"/>',
			'<div class="blog_spoiler"><div onclick="open_spoler(this); return false;" class="blog_plus">[+] Открыть</div>$1<div onclick="open_spoler(this); return false;" class="blog_minus">[-] Закрыть</div></div>'
		);

	if(!isset($arr[$_GET['o']]['c']))$commentn=0;
	else $commentn = count($arr[$_GET['o']]['c']);
        $arr[$_GET['o']]['m'] = preg_replace ($search, $replace, $arr[$_GET['o']]['m']);
		echo '<div class="usr_blog_top"><div class="usr_blog_top_text" itemprop="about">'.$arr[$_GET['o']]['n'].'</div></div>'.
			 '<article class="usr_blog_content" itemprop="text">'.$arr[$_GET['o']]['m'].'</article>'.
			 '<div class="usr_blog_bottom"><span class="pdng-l-5px" itemprop="interactionCount">Комментариев: '.$commentn.' '.$adv.'</span><span class="right pdng-r-5px"><span itemprop="dateCreated">'.substr($arr[$_GET['o']]['d'], 0,10).'</span> <time>'.substr($arr[$_GET['o']]['d'], -8).'</time></span></div>';
		if($commentn > 0)
		{
			foreach($arr[$_GET['o']]['c'] as $key => $value)
			{	
				if($me==1)
				{
					$adv='<a href="/engine/include/users/blog_edit.php?myrmc='.$key.'&amp;myrmcn='.$_GET['o'].'&amp;myrmcu='.$_GET['u'].'">Удалить</a>';
				}

     				$arr[$_GET['o']]['c'][$key]['m']=str_replace("&lt;br /&gt;", "<br />", $arr[$_GET['o']]['c'][$key]['m']);
				$tr_name=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$arr[$_GET['o']]['c'][$key]['usr'].'/login_translit.txt');
				echo '<br /><div style="border-left:1px solid #DADABF;width:100%;float:left;border-top:1px solid #DADABF;" itemprop="comment"><div class="pdng-l-5px">'.$arr[$_GET['o']]['c'][$key]['m'].'</div></div>'.
				'<div style="border-left:1px solid #DADABF;width:100%;float:left;border-bottom:1px solid #DADABF;"><div class="pdng-l-5px left">
				<a href="/database/profile.php?'.$arr[$_GET['o']]['c'][$key]['usr'].'">'.$tr_name.'</a> '
				.$adv.'</div><time class="right" style="padding-right:5px;">'.$arr[$_GET['o']]['c'][$key]['d'].'</time></div>';
			}
		}
		echo '<form action="/engine/include/users/blog_add.php" method="POST">
				<br />Ответить:<br />
				<textarea name="comment" style="height:100px;width:300px;"></textarea><br />
				<input type="submit" value="Отправить"/>
				<input type="hidden" name="id" value="'.$_GET['o'].'">
				<input type="hidden" name="usr" value="'.$_GET['u'].'"><br />
			</form>';
	}
	else
	{
		if(isset($_GET['add']) && $me==1)
		{
			echo '<form action="/engine/include/users/blog_add.php" method="POST">
			<center>
				Заголовок <sup title="Осталось символов" class="sup_abbr">255</sup><br />
				<input type="text" name="name" onkeyup="input_blog_val(this, 255);" required><br />
				Запись <sup title="Осталось символов" class="sup_abbr">25500</sup><br />
				<textarea name="message" onkeyup="input_blog_val(this, 25500);" style="width:60%;height:250px;"></textarea><br />
				
				<input type="submit" value="Отправить"/>
			</center>
			</form>';
		}
		else if(isset($_GET['edit']) && $me==1)
		{
			$arr = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['u'].'/blog.arr'));
			if(isset($arr[$_GET['edit']]))
			{
				$n=$arr[$_GET['edit']]['n'];
				$m=$arr[$_GET['edit']]['s'];
				echo '<form action="/engine/include/users/blog_add.php" method="POST">
				<center>
					Заголовок <sup title="Осталось символов" class="sup_abbr">'.(255-mb_strlen($n, "UTF-8")).'</sup><br />
					<input type="text" name="name" value="'.$n.'" onkeyup="input_blog_val(this, 255);" required><br />
					<input type="hidden" name="id" value="'.$_GET['edit'].'"><br />
					Запись <sup title="Осталось символов" class="sup_abbr">'.(25500-mb_strlen($m, "UTF-8")+substr_count($m,"\r\n")).'</sup><br />
					<textarea name="edit" onkeyup="input_blog_val(this, 25500);" style="width:80%;height:250px;">'.$m.'</textarea><br />
					
					<input type="submit" value="Отправить"/>
				</center>
				</form>
				<script>
					
				</script>		
		
';
			}
			else
			{
				echo 'Нет такой записи.';
			}
		}
		else
		{
			echo $add;
			echo '<div class="usr_blog_top"><span class="usr_blog_top_text">Записи пользователя '.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['u'].'/login_translit.txt').':</span></div>';
			foreach($arr as $key => $value)
			{	
				if($me==1)
				{
					$adv='<a class="right" href="blog.php?u='.$_GET['u'].'&amp;rm='.$key.'">удалить запись</a><i class="right">&nbsp;|&nbsp;</i><a class="right" href="blog.php?u='.$_GET['u'].'&amp;edit='.$key.'">редактировать</a>';
				}
				$out.='<div class="border_lb" style="padding:4px;"><a href="blog.php?u='.$_GET['u'].'&amp;o='.$key.'">'.$arr[$key]['n'].'</a>'.$adv.'</div>';
			}
			echo $out;
			if($out=='')echo '<div class="border_lb" style="padding:4px;">Записей нет.</div>';
		}
	}
?>
</div>
</div>
</div>
</div>
<div id="blank_photo_hidden" onclick="blank_view_photo(); return false;"></div>




<script>
function open_spoler(obj){
if($(obj).parent().css("height")=="21px")$(obj).parent().css("height", "auto");
else $(obj).parent().css("height", "21px");}

$('.blog_minus').click(function(){$(this).parent().css("height", "20px");});


function input_blog_val(obj, max)
{
	$(obj).prev().prev().html(""+max-obj.value.length);
}
</script>




</div>
<?
	include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
?>
</html>

