<?
	session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	$arr=array();

	if(isset($_GET['myrmc']))
	{
		if (isset($_SESSION['username']))//Определение сессии. Есть ли ник
		{
			$arr = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['myrmcu'].'/blog.arr'));
			if($_GET['myrmcu']==$_SESSION['username'] || $arr[$_GET['myrmcn']]['c'][$_GET['myrmc']]['usr'] == $_SESSION['username'])
			{
				unset($arr[$_GET['myrmcn']]['c'][$_GET['myrmc']]);
				write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['myrmcu'].'/blog.arr', serialize($arr));
				header("Location: ".'/database/blog.php?u='.$_GET['myrmcu'].'&amp;o='.$_GET['myrmcn']);
			}
		}
	}
?>
