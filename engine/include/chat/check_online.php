<?
	header('Content-type: application/json');
	session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	$out_male='';$out_female='';$out_guest='';
	$g_ve=0;$g_vd=0;
	
	$female_arr=array();
	$male_arr=array();
	$guest_arr=array();

	$out_male_arr='';
	$out_female_arr='';
	$out_guest_arr='';
	
	if(!isset($_SESSION['username']))
	{
		if(!isset($_SESSION['guestname']))
		{
			header("Location: http://".$_SERVER['HTTP_HOST'].'/engine/include/chat/index.php');
			exit('Необходима регистрация.');
		}
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/'.$_SESSION['guestname'].'.txt') == true)
		{
			write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/'.$_SESSION['guestname'].'.txt', $_SERVER['REQUEST_TIME']);
		}
	}
	else
	{
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/'.$_SESSION['username'].'.txt') == true)
		{
			write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/'.$_SESSION['username'].'.txt', $_SERVER['REQUEST_TIME']);
		}
	}
	

	
	$dh = opendir($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/');
	while ($file = readdir($dh)): 
    if ($file != '.' && $file != '..')//Сканируем название раздела
    {
		$users_name = substr($file, 0, -4);
		$USR = $_SERVER['DOCUMENT_ROOT'].'/database/users/'.$users_name;
		if($_SERVER['REQUEST_TIME']-file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/'.$file) > 60)
		{
			unlink($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/'.$file);
			unlink($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$users_name.'.arr');
			unlink($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$users_name.'_ignore.arr');
			/*if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$users_name.'.txt') == true)//Гости
			{
				unlink($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$users_name.'.txt');
				unlink($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$users_name.'_biu.arr');
				unlink($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$users_name.'_color.arr');
			}*/
		}
		else
		{
			$style_time_out='';
			if($_SERVER['REQUEST_TIME']-file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/'.$file) > 20)
			{
				$style_time_out = 'opacity_50 line_through';
			}
		
		
				
			if(file_exists($USR.'/name_style.txt'))
			{
				//$new_name=file_get_contents($USR.'/name_style.txt');
				$login_trans=file_get_contents($USR.'/login_translit.txt');

				$color_nick=file_get_contents($USR.'/chat_nick_color_one.txt');
				$color_nick_rgb=hex2rgb($color_nick);
				if($color_nick_rgb[0]+$color_nick_rgb[1]+$color_nick_rgb[2] > 100)
				{
					$new_name='<span title="Написать" onclick="print_message(this); return false;" style="color:'.$color_nick.';" class="left sh_black chat_color_nick_o cursor_pointer '.$style_time_out.'">'.$login_trans.'</span>';
				}
				else
				{
					$new_name='<span title="Написать" onclick="print_message(this); return false;" style="color:'.$color_nick.';" class="sh_white chat_color_nick_o cursor_pointer '.$style_time_out.'">'.$login_trans.'</span>';
				}
			}
			else
			{
				$new_name='<span title="Написать" onclick="print_message(this); return false;" style="color:#EEE;" class="sh_black chat_color_nick_o cursor_pointer '.$style_time_out.'">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$users_name.'.txt').'</span>';
				$login_trans=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$users_name.'.txt');
				$shadow="sh_black";
			}

			

			$ss = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$users_name.'.arr'));
			$tt = $_SERVER['REQUEST_TIME']-$ss->times;

			$h = intval($tt / 3600);
			$m = intval($tt / 60)%60;
			$s = intval($tt % 60);
			
			if($h >= 1)
			{
				$out_times = $h.' ч. '.$m.' м. '.$s.' с.';
			}
			else if($m >= 1)
			{
				$out_times = $m.' мин. '.$s.' сек.';
			}
			else if($s > -1)
			{
				$out_times = $s.' сек.';
			}
			
			if(json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$users_name.'.arr'))->status == '1')
			{
				if($_SERVER['REQUEST_TIME']-json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$users_name.'.arr'))->old_mt > 600)//Автосмена статуса
				{
					$status = '<b style="color:red;" class="left" title="Отошел '.$out_times.'">&#10008;</b>';
				}
				else
				{
					$status = '<b style="color:#32CD32;" title="На связи '.$out_times.'" class="left">&#10004;</b>';
				}
			}
			
			if(isset($_SESSION['username']))
			{
				$file_ign = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$_SESSION['username'].'_ignore.arr'));
			}
			else
			{
				$file_ign = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$_SESSION['guestname'].'_ignore.arr'));
			}
			if(in_array($users_name, $file_ign) == true)
			{
				$ch_lock_src = '<img style="border-bottom:1px dashed red;" class="right iphone_height_online_status cursor_pointer" alt="В игнор" title="Убрать из игнора" onclick=chat_ignore_act("'.$users_name.'") src="/engine/images/ch_lock_red.png"/>';
			}
			else
			{
				$ch_lock_src = '<img style="border-bottom:1px dashed #58ACFA;" class="right iphone_height_online_status cursor_pointer" alt="В игнор" title="Добавить в игнор" onclick=chat_ignore_act("'.$users_name.'") src="/engine/images/ch_lock.png"/>';
			}
			
			$test_img ='<a title="Анкета" target="_blank" href="/database/profile.php?'.$users_name.'"><img style="border-bottom:1px solid orange;" class="right iphone_height_online_status" alt="Анкета" src="/engine/images/blank_usr.gif"/></a>'.$ch_lock_src;
			
			
			if($ss->g_voice==1)$g_ve++;
			else $g_vd++;
			

			$title=$new_name.$test_img;	

			if(file_exists($USR.'/sex.txt'))
			{
				if(file_get_contents($USR.'/sex.txt') == '2')
				{
					$sex = '<b style="color:pink;" class="left" title="Женщина">&#9792;</b>';
					$female_arr[] = $sex.$status.$title;
				}
				else if(file_get_contents($USR.'/sex.txt') == '1')
				{
					$sex = '<b style="color:#00CCFF;" class="left" title="Мужчина">&#9794;</b>';
					$male_arr[] = $sex.$status.$title;
				}

			}
			else
			{
				$sex = '<b style="color:white;" class="left" title="Пол неизвестен">x</b>';
				$guest_arr[] = $sex.$status.$title;
			}
		}
	}
	endwhile; 
	closedir($dh);
	

	$cfc_1 = '<li class="chat_users_online_frame chat_color_2_n">';
	$cfc_2 = '<li class="chat_users_online_frame chat_color_1_n">';
	$w=0;
			
	
	foreach($female_arr as $key)
	{
		$w++;
		if(fmod($w,2)==0)$out_female_arr.= $cfc_1.$key.'</li>';
		else $out_female_arr.= $cfc_2.$key.'</li>';
	}
	foreach($male_arr as $key)
	{
		$w++;
		if(fmod($w,2)==0)$out_male_arr.= $cfc_1.$key.'</li>';
		else $out_male_arr.= $cfc_2.$key.'</li>';
	}
	foreach($guest_arr as $key)
	{
		$w++;
		if(fmod($w,2)==0)$out_guest_arr.= $cfc_1.$key.'</li>';
		else $out_guest_arr.= $cfc_2.$key.'</li>';
	}


	$MTA = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/online.txt');
	$MTA = str_replace("<br />", "\n", $MTA);
	$arr = explode("\n", $MTA);

	foreach($arr as $player) {
		$player = trim($player);
		if($player != "") {
			$w++;
			if(fmod($w,2)==0) {
				$out .= $cfc_1.'<span title="Написать" onclick="print_message(this); return false;" style="color:#CCCCCC" class="left sh_black chat_color_nick_o cursor_pointer">'.$player.'</span></li>';

			}
			else {
				$out .= $cfc_2.'<span title="Написать" onclick="print_message(this); return false;" style="color:#EEEEEE;" class="left sh_black chat_color_nick_o cursor_pointer">'.$player.'</span></li>';
			}
		}
	}

	//'.$login_trans.
	
	session_write_close();
	
	$Minecraft = file_get_contents('http://minecraft.neeboo.ru/server/online');
	if(isset($Minecraft)) {
		$arr = json_decode($Minecraft);
		if(isset($arr)) {
			$Minecraft = "";
			foreach($arr as $player) {
			$player = trim($player);
				if($player != "") {
					$w++;
					if(fmod($w,2)==0) {
						$Minecraft .= $cfc_1.'<span title="Написать" onclick="print_message(this); return false;" style="color:#CCCCCC" class="left sh_black chat_color_nick_o cursor_pointer">'.$player.'</span></li>';
					}
					else {
						$Minecraft .= $cfc_2.'<span title="Написать" onclick="print_message(this); return false;" style="color:#EEEEEE;" class="left sh_black chat_color_nick_o cursor_pointer">'.$player.'</span></li>';
					}
				}
			}
		}
	}
	
	die(json_encode(
	  array(
		'online_male' => $out_male_arr,
		'online_female' => $out_female_arr,
		'online_guest' => $out_guest_arr,
		'g_ve' => $g_ve,
		'g_vd' => $g_vd,
		'MTA' => $out,
		'Minecraft' => $Minecraft
	  )
	));

?>

<?
function hex2rgb($h){
$h = str_replace("#", "", $h);
return array(hexdec(substr($h,0,2)), hexdec(substr($h,2,2)), hexdec(substr($h,4,2)));
}
?>

