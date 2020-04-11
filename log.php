<?
include 'head_menu.php';
include $_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/function/chat_fn.php';
function page_title(){return "...";}
if(!isset($_SESSION['username']))
{
	if(!isset($_SESSION['guestname']))
	{
		header("Location: http://".$_SERVER['HTTP_HOST'].'/engine/include/chat/index.php');
		exit('Необходима регистрация.');
	}
}

echo start_job();
	
if(isset($_SESSION['username']))
{
	$login_trans=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt');
	$text_color_one = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_text_color_one.txt');
	$nick_color_one = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_nick_color_one.txt');
}
else if(isset($_SESSION['guestname']))
{
	$login_trans=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'.txt');
	$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'_color.arr'));
	$text_color_one = $file->one;
	$nick_color_one = $file->two;
}
?>
<form action="/clearlog.php" method="get"><button>Очистить логи</button></form>
<div id="chat_frame" ondragover="allowDrop(event)" ondrop="drop(event)">
<?
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
	for($s = 0; $s <= sizeof($f); $s++)
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
	echo $out_iframe;

?>
</div>

<?php
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
function write_ap($f, $c){$fw=fopen($f, 'a+');fwrite($fw, $c);fclose($fw);}


function GetInTranslit_fp_tr($string) {
    $replace = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => "'",  'ы' => 'y',   'ъ' => "'",
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
 
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => "'",  'Ы' => 'Y',   'Ъ' => "'",
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
	return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}
?>





