<?
function load_start_messages()
{
	if (isset($_SESSION['username']))
	{
		$usr_name = $_SESSION['username'];
		$usr_name_tr = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt');
	}
	else if (isset($_SESSION['guestname']))
	{
		$usr_name = $_SESSION['guestname'];
		$usr_name_tr = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'.txt');
	}
	$out_iframe = '';
	if (isset($_SESSION['username']))
	{
		$torb=json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_cfg.arr'));
		$settings_iframe=$torb[0];
	}
	else if (isset($_SESSION['guestname']))
	{
		$settings_iframe='0';
	}
	$f = file($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/lgchat86123.txt');
	for($s = sizeof($f)-20; $s <= sizeof($f); $s++)
	{
		if(isset($f[$s]))
		{
			if (isset($_SESSION['username']))
			{
				$real_nick_name = GetInTranslit_fp_tr(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt'));//Для русских имен.
			}
			else if (isset($_SESSION['guestname']))
			{
				$real_nick_name = GetInTranslit_fp_tr(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'.txt'));//Для русских имен.
			}

			$my_name_is = $real_nick_name.', ';
			$fp_tr = GetInTranslit_fp_tr($f[$s]);
			$fp = $f[$s];
			
			if(isset($_SESSION['username']))
			{
				if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/time_v.txt'))
				{
					if(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/time_v.txt') == 'false')//Не отображать смайлы
					{
						$fp=str_replace('<[time_v]>',' style="display:none;"',$fp);
					}
					else
					{
						$fp=str_replace('<[time_v]>','',$fp);
					}
				}
				else
				{
					$fp=str_replace('<[time_v]>',' style="display:none;"',$fp);
				}
			}
			else
			{
					$fp=str_replace('<[time_v]>',' style="display:none;"',$fp);
			}


			if (preg_match("/".$my_name_is."/", $fp_tr))
			{
				if (preg_match("/".preg_quote("[@private]".$my_name_is)."/", $fp_tr))
				{
					$fp = str_replace("[@private]", '',$fp);//Очистка сообщения от знака [@private]
					if($settings_iframe == '0')
					{
						$out_iframe = $out_iframe.'<div class="chat_all_message_style chat_users_private_messages">'.$fp.'</div>';
					}
					else if($settings_iframe == '1')
					{
						$out_iframe = '<div class="chat_all_message_style chat_users_private_messages">'.$fp.'</div>'.$out_iframe;
					}
				}
				else
				{
					if($settings_iframe == '0')
					{
						$out_iframe = $out_iframe.'<div class="chat_all_message_style chat_users_only_you">'.$fp.'</div>';
					}
					else if($settings_iframe == '1')
					{
						$out_iframe = '<div class="chat_all_message_style chat_users_only_you">'.$fp.'</div>'.$out_iframe;
					}
				}
			}
			else
			{
				if(strpos($fp, '<!--<[render_for_'.$usr_name.']>-->') === false)
				{
				
				}
				else
				{
					$fp = str_replace("[@private]", '',$fp);//Очистка сообщения от знака [@private]
					$out_iframe = $out_iframe.'<div class="chat_all_message_style chat_users_my_private_messages">'.$fp.'</div>';
				}
				
				
				if (preg_match("/".preg_quote("[@private]")."/", $fp_tr))//Проверить обычное сообщение на личное.
				{

				}
				else
				{
					if (preg_match("/".preg_quote('<div class="chat_all_message_style chat_system_message">').'/', $fp_tr) )//Проверить сообщение на системное
					{

						if($settings_iframe == '0')
						{
							$out_iframe = $out_iframe.$fp;
						}
						else if($settings_iframe == '1')
						{
							$out_iframe = $fp.$out_iframe;
						}
					}
					else if (preg_match("/".preg_quote('<!--<[name_').'/', $fp_tr) )//Проверить сообщение на хотя бы обычное
					{
						if($settings_iframe == '0')
						{
							$out_iframe = $out_iframe.'<div class="chat_all_message_style chat_old_users_message">'.$fp.'</div>';
						}
						else if($settings_iframe == '1')
						{
							$out_iframe = '<div class="chat_all_message_style chat_old_users_message">'.$fp.'</div>'.$out_iframe;
						}
					}
				}
			}
		}
	}

	$search = array(
		'#<script>create_prompt_tray(.*?)</script>#is'
	);
	$replace = array(
		''
	);
	$out_iframe = preg_replace($search, $replace, $out_iframe); 
	return $out_iframe;
}

function start_job()
{
	if (isset($_SESSION['username']))
	{
		$usr_name = $_SESSION['username'];
		$usr_name_tr = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt');

	}
	else if (isset($_SESSION['guestname']))
	{
		$usr_name = $_SESSION['guestname'];
		$usr_name_tr = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'.txt');
	}
	$p='create_prompt_tray("'.date("H:i").' Заходит '.$usr_name_tr.'");';

	if (isset($_SESSION['username']))
	{
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/IP.txt', getenv("REMOTE_ADDR"));
	}
	if (isset($_SESSION['username']) || isset($_SESSION['guestname']))//Определение сессии. Есть ли ник
	{
		$dh = opendir($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/');  
		while ($file = readdir($dh)): 
		if ($file != '.' && $file != '..')//Сканируем название раздела
		{
			if($_SERVER['REQUEST_TIME']-file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/'.$file) > 60)
			{
				$filen=substr($file, 0, -4);//Удаляем .txt
				unlink($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/'.$filen.'.txt');
				unlink($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$filen.'.arr');
				unlink($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$filen.'_ignore.arr');
				/*if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$filen.'.txt') == true)//Гости
				{
					unlink($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$filen.'.txt');
					unlink($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$filen.'_biu.arr');
					unlink($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$filen.'_color.arr');
				}*/
			}
		}
		endwhile; 
		closedir($dh);
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/'.$usr_name.'.txt') == true)
		{
			//exit("Пользователь уже в чате. Повторите запрос через минуту...");
		}
		else
		{
			write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/'.$usr_name.'.txt', $_SERVER['REQUEST_TIME']);	
			write_ap($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/lgchat86123.txt', sys_msg_ent($usr_name_tr,$p));
		}
		
		if (isset($_SESSION['username']))
		{
			write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$_SESSION['username'].'_ignore.arr', json_encode(array()));
			
			write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$_SESSION['username'].'.arr', json_encode(array(
			'status' => '1',
			'times' => $_SERVER['REQUEST_TIME'],
			'str' => sizeof(file($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/lgchat86123.txt')),
			'old_m' => '',
			'old_mt' => $_SERVER['REQUEST_TIME'],
			'g_voice' => '1',
			'last_alert' => '0',
			'print_message' => '0'
			)));
		}
		else if (isset($_SESSION['guestname']))
		{
			write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$_SESSION['guestname'].'_ignore.arr', json_encode(array()));
			
			write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$_SESSION['guestname'].'.arr', json_encode(array(
			'status' => '1',
			'times' => $_SERVER['REQUEST_TIME'],
			'str' => sizeof(file($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/lgchat86123.txt')),
			'old_m' => '',
			'old_mt' => $_SERVER['REQUEST_TIME'],
			'g_voice' => '1',
			'last_alert' => '0',
			'print_message' => '0'
			)));
		}
	}
	else exit('Чат только для зарегистрированных пользователей!');
}

function sys_msg_ent($n,$p){return "\r\n".'<div class="chat_all_message_style chat_system_message"><script>'.$p.'</script><span <[time_v]>>['.date("H:i:s").'] </span><b>Системное оповещение</b>: Заходит "<span class="tx_c_9ACD32 cursor_pointer" onclick="print_message(this); return false;">'.$n.'</span>"</div>';}
function sys_msg_ext($n){return "\r\n".'<!--<[name_system]>--><div class="chat_all_message_style chat_system_message"><span <[time_v]>>['.date("H:i:s").'] </span><b>Системное оповещение</b>: Выходит "<span class="tx_c_9ACD32 cursor_pointer" onclick="print_message(this); return false;">'.$n.'</span>"</div>';}
?>
