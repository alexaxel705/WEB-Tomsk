<?
	session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	if (isset($_SESSION['username']))//Определение сессии. Есть ли ник
	{
		if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['name']))exit ("Пользователь не найден!");
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/friends/'.$_GET['name'].'.txt'))
		{
			if($_GET['act'] == 0)
			{
				write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/friends/'.$_GET['name'].'.txt', '1');
				write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['name'].'/friends/'.$_SESSION['username'].'.txt', '1');
				header("Location: http://".$_SERVER['HTTP_HOST'].'/database/users/'.$_SESSION['username'].'/friends.php');
				
				$name1=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt');
				$name2=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['name'].'/login_translit.txt');
				add_last_action('<a class="a_act_fr" href="/database/profile.php?'.$_SESSION['username'].'">'.$name1.'</a> и <a class="a_act_fr" href="/database/profile.php?'.$_GET['name'].'">'.$name2.'</a> стали друзьями!');
			}
			else
			{
				unlink($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/friends/'.$_GET['name'].'.txt');
				unlink($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['name'].'/friends/'.$_SESSION['username'].'.txt');
				header("Location: http://".$_SERVER['HTTP_HOST'].'/database/users/'.$_SESSION['username'].'/friends.php');
			}
		}
		else
		{
			exit('Ошибка!');//Если не отправляли запрос
		}
	}
	else
	{
		exit('Ошибка!');
	}
?>