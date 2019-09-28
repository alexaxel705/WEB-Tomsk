<?
	header('Content-type: application/json');
	session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	if(!isset($_SESSION['username']))exit;
	$conf=json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_cfg.arr'));
	$out='';
	$traffic=0;
	$set_connection = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/set_connection.arr'));
	if($set_connection['head_update']==1)$traffic+=9;


	
	if($_POST['config'] == 1)
	{
		if($_POST['old_passwd'] != '' && $_POST['new_passwd'] != '' && $_POST['new_passwd_ok'] != '')
		{
			$old_passwd = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/password.txt');
			if($old_passwd == password($_POST['old_passwd']))
			{
				if($_POST['new_passwd'] == $_POST['new_passwd_ok'])
				{
					write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/password.txt', password($_POST['new_passwd']));
					$out.=add_out('Пароль успешно изменен.');
				}
				else
				{
					$out.=add_out('Разные значения в полях: "Новый пароль" и "Подтвердите пароль". Пароль не изменен.');
				}
			}
			else
			{
				$out.=add_out('Текущий пароль не верный!');
			}
		}
		

		$old_o_sebe = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/o_sebe.txt');
		$old_o_sebe = str_replace('<br />',"\r\n",$old_o_sebe);
		if($_POST['o_sebe'] != $old_o_sebe)
		{
			$_POST['o_sebe'] = substr($_POST['o_sebe'], 0, 800);
			$_POST['o_sebe'] = str_replace('>','',$_POST['o_sebe']);
			$_POST['o_sebe'] = str_replace('<','',$_POST['o_sebe']);
			$_POST['o_sebe'] = str_replace("\r\n",'<br />',$_POST['o_sebe']);
			write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/o_sebe.txt', $_POST['o_sebe']);
			$out.=add_out('Информация "О себе" успешно обновлена!');
		}


		$usr_real_name = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/usr_real_name.txt');
		if($_POST['usr_real_name'] != $usr_real_name)
		{
			if(strlen($_POST['usr_real_name']) > 25)
			{
				$out.=add_out('Максимальное число символов в имени - 25!');
			}
			else
			{
				$_POST['usr_real_name'] = str_replace('>','',$_POST['usr_real_name']);
				$_POST['usr_real_name'] = str_replace('<','',$_POST['usr_real_name']);
				write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/usr_real_name.txt', $_POST['usr_real_name']);
				$out.=add_out('Вы успешно добавили своё имя!');
			}
		}
		$geoloc = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/location.txt');
		if($_POST['geoloc'] != $geoloc)
		{
			if(mb_strlen($_POST['geoloc'],'UTF-8') > 15)
			{
				$out.=add_out('Максимальное число символов в местоположении - 15!');
			}
			else
			{
				$_POST['geoloc'] = str_replace('>','',$_POST['geoloc']);
				$_POST['geoloc'] = str_replace('<','',$_POST['geoloc']);
				write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/location.txt', $_POST['geoloc']);
				$out.=add_out('Вы успешно добавили своё местоположение!');
			}
		}
		
		
		if($_POST['sex'] != '')
		{
			if($_POST['sex'] != file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/sex.txt'))
			{
				if($_POST['sex'] == 1 || $_POST['sex'] == 2)
				{
					write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/sex.txt', $_POST['sex']);
					$out.=add_out('Вы успешно сменили пол.');
				}
			}
		}
		

		if($_POST['icq'] != '')
		{
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/icq.txt'))
			{
				if($_POST['icq'] != file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/icq.txt'))
				{
					$valids = '0123456789';
					if(strspn($_POST['icq'], $valids) == strlen($_POST['icq'])) 
					{
						write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/icq.txt', $_POST['icq']);
						$out.=add_out('Вы успешно обновили номер ICQ.');
					}
					else
					{
						$out.=add_out('Запрещенные символы в ICQ! Только числа.');
					}
				}
			}
			else
			{
				$valids = '0123456789';
				if(strspn($_POST['icq'], $valids) == strlen($_POST['icq'])) 
				{
					write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/icq.txt', $_POST['icq']);
					$out.=add_out('Вы успешно добавили номер ICQ.');
				}
				else
				{
					$out.=add_out('Запрещенные символы в ICQ! Только числа.');
				}
			}
		}
		else
		{
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/icq.txt'))
			{
				unlink($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/icq.txt');
				$out.=add_out('Номер ICQ удален.');
			}
		}
		
		
		if($_POST['cell_phone'] != '')
		{
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/cell_phone.txt'))
			{
				if($_POST['cell_phone'] != file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/cell_phone.txt'))
				{
					$valids = '0123456789+';
					if(strspn($_POST['cell_phone'], $valids) == strlen($_POST['cell_phone'])) 
					{
						write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/cell_phone.txt', $_POST['cell_phone']);
						$out.=add_out('Вы успешно обновили номер телефона.');
					}
					else
					{
						$out.=add_out('Запрещенные символы в номере телефона! Только числа и +.');
					}
				}
			}
			else
			{
				$valids = '0123456789+';
				if(strspn($_POST['cell_phone'], $valids) == strlen($_POST['cell_phone'])) 
				{
					write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/cell_phone.txt', $_POST['cell_phone']);
					$out.=add_out('Вы успешно добавили телефонный номер.');
				}
				else
				{
					$out.=add_out('Запрещенные символы в номере телефона! Только числа и +.');
				}
			}
		}
		else
		{
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/cell_phone.txt'))
			{
				unlink($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/cell_phone.txt');
				$out.=add_out('Номер телефона удален.');
			}
		}
		
		
		if($_POST['e_mail'] != '')
		{
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/e_mail.txt'))
			{
				if($_POST['e_mail'] != file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/e_mail.txt'))
				{
					$valids = '0123456789qwertyuioplkjhgfdsazxcvbnmёйцукенгшщзхъэждлорпавыфячсмитьбюQWERTYUIOPLKJHGFDSAZXCVBNMЁЙЦУКЕНГШЩЗХЪЭЖДЛОРПАВЫФЯЧСМИТЬБЮ_-@.';
					if(strspn($_POST['e_mail'], $valids) == strlen($_POST['e_mail'])) 
					{
						write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/e_mail.txt', $_POST['e_mail']);
						$out.=add_out('Вы успешно обновили e-mail.');
					}
					else
					{
						$out.=add_out('Запрещенные символы в e-mail! [а-я] [a-z] _ . - @');
					}
				}
			}
			else
			{
				$valids = '0123456789qwertyuioplkjhgfdsazxcvbnmёйцукенгшщзхъэждлорпавыфячсмитьбюQWERTYUIOPLKJHGFDSAZXCVBNMЁЙЦУКЕНГШЩЗХЪЭЖДЛОРПАВЫФЯЧСМИТЬБЮ_-@.';
				if(strspn($_POST['e_mail'], $valids) == strlen($_POST['e_mail'])) 
				{
					write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/e_mail.txt', $_POST['e_mail']);
					$out.=add_out('Вы успешно добавили e-mail.');
				}
				else
				{
					$out.=add_out('Запрещенные символы в e-mail! [а-я] [a-z] _ . - @');
				}
			}
		}
		else
		{
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/e_mail.txt'))
			{
				unlink($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/e_mail.txt');
				$out.=add_out('e-mail успешно удален.');
			}
		}
	}


	write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_cfg.arr', json_encode($conf));
	die(json_encode(
	  array(
		'out'  => $out,
		'traffic' => $traffic
	  )));

	function add_out($text)
	{
		return $text.'<br />';
	}
?>