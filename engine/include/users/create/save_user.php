<?
	session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	$real_name = $_POST['login'];
	if ($_POST['reg_bot_test'] == '')
	{
		exit('Вы ввели не всю информацию, вернитесь назад и заполните все поля!');
	} 
	else
	{
		$true = $_POST['reg_bot_test_a'] + $_POST['reg_bot_test_b'];
		if ($_POST['reg_bot_test'] != $true)
		{
			exit('Неверное значение!');
		}
	}

	$login = $_POST['login']; 
	$password=$_POST['password']; 

	if($login == '' || $password == '')exit ('Вы ввели не всю информацию, вернитесь назад и заполните все поля!');
	if(mb_strlen($login, "UTF-8") > 15)exit('Логин слишком длинный!');
	$valids = '0123456789qwertyuioplkjhgfdsazxcvbnmёйцукенгшщзхъэждлорпавыфячсмитьбюQWERTYUIOPLKJHGFDSAZXCVBNMЁЙЦУКЕНГШЩЗХЪЭЖДЛОРПАВЫФЯЧСМИТЬБЮ_-';
	if (strspn($login, $valids) != strlen($login)) 
	{
		exit('Запрещенные символы! от [А-Я] [A-Z] [0-9] _ и -');
	}
	$password = stripslashes($password);
	$password = htmlspecialchars($password);
	
	$password = trim($password);//удаляем лишние пробелы(максимальное число пробелов подряд 1)
	
	if(is_dir($_SERVER['DOCUMENT_ROOT']."/database/users/".GetInTranslit($login))) {exit ("Такой пользователь уже существует!");} //Проверка логина на совпадения
	if(is_dir($_SERVER['DOCUMENT_ROOT']."/database/users/".$login)) {exit ("Такой пользователь уже существует!");} //Проверка логина на совпадения
	else//От сюда можно начинать действия регистрации.
	{
		$login = GetInTranslit($login);
		mkdir($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login, 0755);
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/last_visit.txt', date("Y-m-d H:i:s"));
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/avatar.txt', 'avatar.gif?7777');
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/password.txt', password($password));
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/reg_time.txt', date("Y-m-d H:i:s"));
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/login_translit.txt', $real_name);
		
		$r = rand(0, 200);
		$g = rand(0, 200);
		$b = rand(0, 200);
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/chat_cfg.arr', json_encode(array(
		'0', /* Новые сообщения (0: Сверху; 1: Снизу) */
		'1', /* Положение чата (0: Чат слева; 1: Чат справа) */
		'true' /* Смайлы */
		)));
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/name_style.txt', '<span style="color:'.rgbtohex($r, $g, $b).'">'.$real_name.'</span>');
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/chat_nick_color_one.txt', rgbtohex($r, $g, $b));	
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/chat_text_color_one.txt', rgbtohex($b, rand(0, 200), $r));
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/board_id_message.txt', '0');
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/board_news.txt', '0');	
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/o_sebe.txt', 'Информации нет');
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/location.txt', 'Томск');
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/usr_real_name.txt', '');
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/set_connection.arr', serialize(array('head_update' => '1')));
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/biu.arr', json_encode(array('b' => '0','i' => '0')));
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/chat_h.arr', json_encode(array('m' => '0','h' => '0')));
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/blog.arr', serialize(array()));
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/board.arr', serialize(array()));

		mkdir($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/friends', 0755);
		mkdir($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/album', 0755);
		mkdir($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/photo', 0755);
		if($_POST['reg_sex'] == "Мужской")
		{
			copy($_SERVER['DOCUMENT_ROOT'].'/engine/include/users/create/male.gif', $_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/avatar.gif');
			write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/sex.txt', '1');
		}
		else
		{
			copy($_SERVER['DOCUMENT_ROOT'].'/engine/include/users/create/girl.gif', $_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/avatar.gif');
			write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$login.'/sex.txt', '2');
		}
		$users_file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/db_users.arr'));
		$users_file[] = $real_name;
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/db_users.arr', json_encode($users_file));

	
		$_SESSION['username'] = $login;
		session_write_close();
		header("Location: http://".$_SERVER['HTTP_HOST'].'/chat.php');
	}
?>

<?
function rgbtohex($r, $g, $b){
$hex = "#";
$hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
$hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
$hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
return $hex;
}
?>
