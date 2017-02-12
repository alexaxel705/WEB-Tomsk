<?
	session_start();
	if (isset($_SESSION['username']))//Определение сессии. Есть ли ник
	{
		if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['name']))exit ("Пользователь не найден!");
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['name'].'/friends/'.$_SESSION['username'].'.txt'))
		{
			write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['name'].'/friends/'.$_SESSION['username'].'.txt', '0');
			header("Location: http://".$_SERVER['HTTP_HOST'].'/database/profile.php?'.$_GET['name']);
		}
		else
		{
			exit('Ошибка!');//Если уже друзья
		}
	}
	else
	{
		exit('Ошибка!');
	}
	function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
?>