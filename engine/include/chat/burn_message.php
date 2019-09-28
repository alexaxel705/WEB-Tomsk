<?php
	session_start();
	include("../MTA/mta_sdk.php");
	$_POST['message'] = mb_substr($_POST['message'],0,800);
	$_POST['message'] = preg_replace('/([^\s]{200})[^\s]+/', '$1...', $_POST['message']);
	$_POST['message'] = str_replace('>','&gt;',$_POST['message']) ;
	$_POST['message'] = str_replace('<','&lt;',$_POST['message']);
	$_POST['message'] = str_replace("\r\n", '', $_POST['message']);
	$_POST['message'] = str_replace("\n", '', $_POST['message']);
	$_POST['message'] = str_replace('&lt;br&gt;', '', $_POST['message']);
	if(!isset($_SESSION['username']) && !isset($_SESSION['guestname']))
	{
		header("Location: http://".$_SERVER['HTTP_HOST'].'/engine/include/users/login_html.php');
	}

	$message = $_POST['message'];
	/*$mas = explode(" ",$message);
	$arr = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/popular_voice.arr'));
	foreach ($mas as $key=>$value)
	{
		$arr[$value]++;
	}
	write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/popular_voice.arr', serialize($arr));	
	*/

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
		
	$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$usr_name.'.arr'));
	if($file->old_m == $message)exit;
	else
	{
		$file->old_m = $message;
		$file->old_mt = $_SERVER['REQUEST_TIME'];
		write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$usr_name.'.arr', json_encode($file));
	}
	
	$private_wm='';
	if($_POST['rez'] == 'true')
	{
		$private_wm='<!--<[render_for_'.$usr_name.']>-->';
	}
	
		
	if (isset($_SESSION['username']))
	{
		$text_color = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_text_color_one.txt');
		$nick_color = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_nick_color_one.txt');
		$name_style = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/name_style.txt');
	}
	else if (isset($_SESSION['guestname']))
	{
		$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'_color.arr'));
		$name_style = '<span style="color:'.$file->two.'">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$usr_name.'.txt').'</span>';
		$text_color = $file->one;
	}

	$name = "\n".'<!--<[name_'.$usr_name.']>-->['.date("H:i:s").'] <b onclick="print_message(this); return false;" class="cursor_pointer" style="color:'.$nick_color.';">'.$usr_name_tr.'</b>: <span class="chat_usr_message_text" style="color:'.$text_color.'">';



	
	
//Smiles_Search_Generator
$message=str_replace('(mir1.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/mir1.gif"/> ',$message);$message=str_replace('(mg252.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/mg252.gif"/> ',$message);$message=str_replace('(103.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/103.gif"/> ',$message);$message=str_replace('(0094.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/0094.gif"/> ',$message);$message=str_replace('(4124king.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/4124king.gif"/> ',$message);$message=str_replace('(aa.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/aa.gif"/> ',$message);$message=str_replace('(ab.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/ab.gif"/> ',$message);$message=str_replace('(ac.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/ac.gif"/> ',$message);$message=str_replace('(ag.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/ag.gif"/> ',$message);$message=str_replace('(ah.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/ah.gif"/> ',$message);$message=str_replace('(ai.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/ai.gif"/> ',$message);$message=str_replace('(al.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/al.gif"/> ',$message);$message=str_replace('(an.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/an.gif"/> ',$message);$message=str_replace('(ap.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/ap.gif"/> ',$message);$message=str_replace('(aq.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/aq.gif"/> ',$message);$message=str_replace('(at.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/at.gif"/> ',$message);$message=str_replace('(au.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/au.gif"/> ',$message);$message=str_replace('(bye.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/bye.gif"/> ',$message);$message=str_replace('(c0113.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/c0113.gif"/> ',$message);$message=str_replace('(crazy.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/crazy.gif"/> ',$message);$message=str_replace('(dirol.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/dirol.gif"/> ',$message);$message=str_replace('(good.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/good.gif"/> ',$message);$message=str_replace('(m0772.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/m0772.gif"/> ',$message);$message=str_replace('(m1104.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/m1104.gif"/> ',$message);$message=str_replace('(m1131.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/m1131.gif"/> ',$message);$message=str_replace('(m1137.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/m1137.gif"/> ',$message);$message=str_replace('(m1301.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/m1301.gif"/> ',$message);$message=str_replace('(m1324.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/m1324.gif"/> ',$message);$message=str_replace('(m2002.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/m2002.gif"/> ',$message);$message=str_replace('(m2012.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/m2012.gif"/> ',$message);$message=str_replace('(m2201.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/m2201.gif"/> ',$message);$message=str_replace('(pri1.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/pri1.gif"/> ',$message);$message=str_replace('(scr1.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/scr1.gif"/> ',$message);$message=str_replace('(sig1.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/sig1.gif"/> ',$message);$message=str_replace('(sle1.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/sle1.gif"/> ',$message);$message=str_replace('(smile156.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/smile156.gif"/> ',$message);$message=str_replace('(smile43.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/smile43.gif"/> ',$message);$message=str_replace('(t141038.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/t141038.gif"/> ',$message);$message=str_replace('(t142024.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/t142024.gif"/> ',$message);$message=str_replace('(t142027.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/t142027.gif"/> ',$message);$message=str_replace('(t2314.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/t2314.gif"/> ',$message);$message=str_replace('(t2708.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/t2708.gif"/> ',$message);$message=str_replace('(t4105.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/t4105.gif"/> ',$message);$message=str_replace('(t9509.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/t9509.gif"/> ',$message);$message=str_replace('(vav2.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/vav2.gif"/> ',$message);$message=str_replace('(xdf2.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/xdf2.gif"/> ',$message);$message=str_replace('(ad2.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/main/ad2.gif"/> ',$message);$message=str_replace('(101.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/101.gif"/> ',$message);$message=str_replace('(m05100.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/m05100.gif"/> ',$message);$message=str_replace('(m05101.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/m05101.gif"/> ',$message);$message=str_replace('(t0204.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t0204.gif"/> ',$message);$message=str_replace('(t02134.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t02134.gif"/> ',$message);$message=str_replace('(t02135.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t02135.gif"/> ',$message);$message=str_replace('(t0236.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t0236.gif"/> ',$message);$message=str_replace('(t0241.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t0241.gif"/> ',$message);$message=str_replace('(t0244.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t0244.gif"/> ',$message);$message=str_replace('(t0245.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t0245.gif"/> ',$message);$message=str_replace('(t0246.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t0246.gif"/> ',$message);$message=str_replace('(t0267.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t0267.gif"/> ',$message);$message=str_replace('(t0280.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t0280.gif"/> ',$message);$message=str_replace('(t0283.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t0283.gif"/> ',$message);$message=str_replace('(t0284.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t0284.gif"/> ',$message);$message=str_replace('(t0291.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t0291.gif"/> ',$message);$message=str_replace('(t0292.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/food/t0292.gif"/> ',$message);$message=str_replace('(1.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/1.gif"/> ',$message);$message=str_replace('(10.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/10.gif"/> ',$message);$message=str_replace('(11.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/11.gif"/> ',$message);$message=str_replace('(12.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/12.gif"/> ',$message);$message=str_replace('(13.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/13.gif"/> ',$message);$message=str_replace('(14.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/14.gif"/> ',$message);$message=str_replace('(15.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/15.gif"/> ',$message);$message=str_replace('(16_!.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/16_!.gif"/> ',$message);$message=str_replace('(17.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/17.gif"/> ',$message);$message=str_replace('(18.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/18.gif"/> ',$message);$message=str_replace('(19.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/19.gif"/> ',$message);$message=str_replace('(2.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/2.gif"/> ',$message);$message=str_replace('(20.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/20.gif"/> ',$message);$message=str_replace('(21.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/21.gif"/> ',$message);$message=str_replace('(22.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/22.gif"/> ',$message);$message=str_replace('(23.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/23.gif"/> ',$message);$message=str_replace('(24.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/24.gif"/> ',$message);$message=str_replace('(25.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/25.gif"/> ',$message);$message=str_replace('(26.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/26.gif"/> ',$message);$message=str_replace('(27.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/27.gif"/> ',$message);$message=str_replace('(28.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/28.gif"/> ',$message);$message=str_replace('(29.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/29.gif"/> ',$message);$message=str_replace('(3.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/3.gif"/> ',$message);$message=str_replace('(30.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/30.gif"/> ',$message);$message=str_replace('(31.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/31.gif"/> ',$message);$message=str_replace('(32.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/32.gif"/> ',$message);$message=str_replace('(33.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/33.gif"/> ',$message);$message=str_replace('(34.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/34.gif"/> ',$message);$message=str_replace('(35.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/35.gif"/> ',$message);$message=str_replace('(36.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/36.gif"/> ',$message);$message=str_replace('(37.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/37.gif"/> ',$message);$message=str_replace('(38.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/38.gif"/> ',$message);$message=str_replace('(4.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/4.gif"/> ',$message);$message=str_replace('(6.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/6.gif"/> ',$message);$message=str_replace('(7.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/7.gif"/> ',$message);$message=str_replace('(8.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/8.gif"/> ',$message);$message=str_replace('(9.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/9.gif"/> ',$message);$message=str_replace('(fry1.png)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/fry1.png"/> ',$message);$message=str_replace('(prf1.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/prf1.gif"/> ',$message);$message=str_replace('(t_6278.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/trollface/t_6278.gif"/> ',$message);$message=str_replace('(m0803.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0803.gif"/> ',$message);$message=str_replace('(m0804.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0804.gif"/> ',$message);$message=str_replace('(m0807.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0807.gif"/> ',$message);$message=str_replace('(m0822.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0822.gif"/> ',$message);$message=str_replace('(m0823.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0823.gif"/> ',$message);$message=str_replace('(m0826.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0826.gif"/> ',$message);$message=str_replace('(m0828.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0828.gif"/> ',$message);$message=str_replace('(m0830.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0830.gif"/> ',$message);$message=str_replace('(m0831.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0831.gif"/> ',$message);$message=str_replace('(m0833.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0833.gif"/> ',$message);$message=str_replace('(m0837.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0837.gif"/> ',$message);$message=str_replace('(m0838.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0838.gif"/> ',$message);$message=str_replace('(m0854.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0854.gif"/> ',$message);$message=str_replace('(m0855.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0855.gif"/> ',$message);$message=str_replace('(m0862.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0862.gif"/> ',$message);$message=str_replace('(m0871.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/music/m0871.gif"/> ',$message);$message=str_replace('(126.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/126.gif"/> ',$message);$message=str_replace('(aj.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/aj.gif"/> ',$message);$message=str_replace('(girl_in_love.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/girl_in_love.gif"/> ',$message);$message=str_replace('(l12424.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/l12424.gif"/> ',$message);$message=str_replace('(m0611.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/m0611.gif"/> ',$message);$message=str_replace('(m0630.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/m0630.gif"/> ',$message);$message=str_replace('(m0631.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/m0631.gif"/> ',$message);$message=str_replace('(m0634.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/m0634.gif"/> ',$message);$message=str_replace('(m0646.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/m0646.gif"/> ',$message);$message=str_replace('(m0652.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/m0652.gif"/> ',$message);$message=str_replace('(m0654.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/m0654.gif"/> ',$message);$message=str_replace('(t12423.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/t12423.gif"/> ',$message);$message=str_replace('(t34224.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/t34224.gif"/> ',$message);$message=str_replace('(t4404.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/t4404.gif"/> ',$message);$message=str_replace('(t4810.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/t4810.gif"/> ',$message);$message=str_replace('(t4812.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/t4812.gif"/> ',$message);$message=str_replace('(t4868.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/love/t4868.gif"/> ',$message);$message=str_replace('(B_B1.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/holiday/B_B1.gif"/> ',$message);$message=str_replace('(h41234.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/holiday/h41234.gif"/> ',$message);$message=str_replace('(m1004.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/holiday/m1004.gif"/> ',$message);$message=str_replace('(m1029.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/holiday/m1029.gif"/> ',$message);$message=str_replace('(smile20.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/holiday/smile20.gif"/> ',$message);$message=str_replace('(j1.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/job/j1.gif"/> ',$message);$message=str_replace('(j5.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/job/j5.gif"/> ',$message);$message=str_replace('(j2.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/job/j2.gif"/> ',$message);$message=str_replace('(j3.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/job/j3.gif"/> ',$message);$message=str_replace('(j4.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/job/j4.gif"/> ',$message);$message=str_replace('(j6.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/job/j6.gif"/> ',$message);$message=str_replace('(compg2.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/computer/compg2.gif"/> ',$message);$message=str_replace('(m1902.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/computer/m1902.gif"/> ',$message);$message=str_replace('(m1904.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/computer/m1904.gif"/> ',$message);$message=str_replace('(m1905.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/computer/m1905.gif"/> ',$message);$message=str_replace('(m1908.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/computer/m1908.gif"/> ',$message);$message=str_replace('(m19110.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/computer/m19110.gif"/> ',$message);$message=str_replace('(m19127.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/computer/m19127.gif"/> ',$message);$message=str_replace('(84.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/friends/84.gif"/> ',$message);$message=str_replace('(c0407.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/friends/c0407.gif"/> ',$message);$message=str_replace('(c0417.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/friends/c0417.gif"/> ',$message);$message=str_replace('(smile107.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/friends/smile107.gif"/> ',$message);$message=str_replace('(21fe.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/weapon/21fe.gif"/> ',$message);$message=str_replace('(gun252.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/weapon/gun252.gif"/> ',$message);$message=str_replace('(W_W4.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/weapon/W_W4.gif"/> ',$message);$message=str_replace('(ter1.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/weapon/ter1.gif"/> ',$message);$message=str_replace('(W_W1.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/weapon/W_W1.gif"/> ',$message);$message=str_replace('(W_W2.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/weapon/W_W2.gif"/> ',$message);$message=str_replace('(W_W3.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/weapon/W_W3.gif"/> ',$message);$message=str_replace('(m0760.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/sport/m0760.gif"/> ',$message);$message=str_replace('(smile52.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/sport/smile52.gif"/> ',$message);$message=str_replace('(training1.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/sport/training1.gif"/> ',$message);$message=str_replace('(h0708.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/dance/h0708.gif"/> ',$message);$message=str_replace('(h0721.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/dance/h0721.gif"/> ',$message);$message=str_replace('(h0731.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/dance/h0731.gif"/> ',$message);$message=str_replace('(x1612064411.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/dance/x1612064411.gif"/> ',$message);$message=str_replace('(x1701214012.gif)',' <img alt="" class="chat_sc" src="/engine/images/smile/dance/x1701214012.gif"/> ',$message);
	
	
	
	$message = str_replace("&nbsp;", ' ', $message);
	
	$message = str_replace('https://', 'http://', $message); 
	$message = preg_replace('#((http)?://(\S)+[\.](\S)*[^\s.,> )\];\'\"!?])#is', "<a target='_blank' href='\\1'>\\1</a>", $message);

	
	$message = preg_replace('/ {2,}/',' ',$message);//Нельзя больше 1 пробела
	if(isset($_SESSION['guestname']))
	{
		$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'_biu.arr'));
	}
	else if(isset($_SESSION['username']))
	{
		$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/biu.arr'));
	}

	$biu = '';
	$biu_end = '';
	if($file->b == '1')
	{
		$biu.='<b>';
		$biu_end.='</b>';
	}
	if($file->i == '1')
	{
		$biu.='<i>';
		$biu_end.='</i>';
	}
	
	

	$burn_file = fopen($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/lgchat86123.txt', 'a+');
	fwrite($burn_file, $name.$private_wm.$biu.$message.$biu_end.'</span>');//Записываем сообщение
	fclose($burn_file);
	session_write_close();

 
	$SERVER = new mta("109.227.228.4", 22005);
    $RESOURCE = $SERVER->getResource("chat");
    $RESOURCE->call("BurnChatMSG", $usr_name_tr, $message, $nick_color);

	
	if(isset($_POST['method']))
	{
		if($_POST['method'] == 'mobile')
		{
			header("Location: http://".$_SERVER['HTTP_HOST'].'/chat.wml');
		}
	}
?>


<?php
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
?>



