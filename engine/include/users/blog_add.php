<?
	session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	if($_POST['edit'] != "")
	{
		if (isset($_SESSION['username']))//Определение сессии. Есть ли ник
		{			
			$_POST['edit'] = mb_substr($_POST['edit'],0,25500);//Сообщение
			$_POST['name'] = mb_substr($_POST['name'],0,255);//Заголовок
			$arr = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/blog.arr'));
			$arr[$_POST['id']]['m']=parse($_POST['edit']);
			$arr[$_POST['id']]['s']=$_POST['edit'];
			$arr[$_POST['id']]['n']=parse($_POST['name']);
			write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/blog.arr', serialize($arr));
			header("Location: ".'/database/blog.php?u='.$_SESSION['username']);
		}
	}
	
	if(isset($_POST['comment']))
	{
		if (isset($_SESSION['username']))//Определение сессии. Есть ли ник
		{
			$_POST['comment'] = parse($_POST['comment']);
			$arr = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['usr'].'/blog.arr'));
			$arr[$_POST['id']]['c'][]=array('d'=>date("Y-m-d H:i:s"),'m'=>$_POST['comment'],'usr'=>$_SESSION['username']);
			write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['usr'].'/blog.arr', serialize($arr));
			
			$name1=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt');
			add_last_action('<a class="a_act_fr" href="/database/profile.php?'.$_SESSION['username'].'">'.$name1.'</a> добавил(а) комментарий в блог "<a class="a_act_fr" href="/database/blog.php?u='.$_POST['usr'].'&amp;o='.$_POST['id'].'">'.$arr[$_POST['id']]['n'].'</a>"');
			header("Location: ".'/database/blog.php?u='.$_SESSION['username'].'&amp;o='.$_POST['id']);
		}
	}
	else
	{
		if($_POST['message'] != '')
		{
			if (isset($_SESSION['username']))//Определение сессии. Есть ли ник
			{				
				$_POST['message'] = mb_substr($_POST['message'],0,25500);//Сообщение
				$_POST['name'] = mb_substr($_POST['name'],0,255);//Заголовок
				$arr = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/blog.arr'));
				$arr[]=array('d'=>date("Y-m-d H:i:s"),'m'=>parse($_POST['message']),'n'=>parse($_POST['name']),'s'=>$_POST['message']);
				write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/blog.arr', serialize($arr));
				
				$name1=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt');
				add_last_action('<a class="a_act_fr" href="/database/profile.php?'.$_SESSION['username'].'">'.$name1.'</a> добавил(а) запись в блог "<a class="a_act_fr" href="/database/blog.php?u='.$_SESSION['username'].'&amp;o='.(count($arr)-1).'">'.$_POST['name'].'</a>"');
				header("Location: ".'/database/blog.php?u='.$_SESSION['username']);
			}
		}
	}
?>

<?
function parse($obj)
{
	$obj = str_replace("\r\n", '<br />', $obj);
	$obj = str_replace("\n", '<br />', $obj);
	$obj = str_replace('>','&gt;',$obj) ;
	$obj = str_replace('<','&lt;',$obj);
	return $obj;
}
?>




