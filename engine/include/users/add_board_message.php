<?
	session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	$_POST['usr'] = GetInTranslit($_POST['usr']);
	$valids = '0123456789qwertyuioplkjhgfdsazxcvbnmёйцукенгшщзхъэждлорпавыфячсмитьбюQWERTYUIOPLKJHGFDSAZXCVBNMЁЙЦУКЕНГШЩЗХЪЭЖДЛОРПАВЫФЯЧСМИТЬБЮ_- ,.!??:#)([]* / \ \'"=|'."\r\n".implode('',range('a','z')).'&%$';
	if (strspn($_POST['message'], $valids) != strlen($_POST['message'])) 
	{
		exit('Запрещенные символы!');
	}
	if($_POST['message'] == '') 
	{
		exit('Пустое сообщение!');
	}
	if(!is_dir("/var/www/database/users/".$_POST['usr']))exit ("Пользователь не найден!");
	if (isset($_SESSION['username']))//Определение сессии. Есть ли ник
	{
		$_POST['message'] = str_replace("\n", '<br />', $_POST['message']);
		$_POST['message'] = str_replace("\r", '<br />', $_POST['message']);


		$old_news = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['usr'].'/board_news.txt');
		$id_message = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['usr'].'/board_id_message.txt');
	
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['usr'].'/board_id_message.txt', $id_message+=1);
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['usr'].'/board_news.txt', $old_news+=1);
				
				
		$arr=unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['usr'].'/board.arr'));
		$arr[]=array('d'=>date("Y-m-d H:i:s"),'m'=>$_POST['message'],'w'=>$_SESSION['username']);
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['usr'].'/board.arr', serialize($arr));

		$name1=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt');
		$name2=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['usr'].'/login_translit.txt');
		add_last_action('<a class="a_act_fr" href="/database/profile.php?'.$_SESSION['username'].'">'.$name1.'</a> написал(а) на доске у <a class="a_act_fr" href="/database/profile.php?'.$_POST['usr'].'">'.$name2.'</a>');

		header("Location: http://".$_SERVER['HTTP_HOST'].'/database/profile.php?'.$_POST['usr']);
	}
	else
	{
		header("Location: http://".$_SERVER['HTTP_HOST'].'/database/profile.php?'.$_POST['usr']);
	}
?>

