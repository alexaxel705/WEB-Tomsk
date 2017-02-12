<?php
session_start();
if (isset($_SESSION['guestname']))
{
	$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'_color.arr'));
	$file->two=$_POST['message'];
	write_wb($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'_color.arr', json_encode($file));
}
if (isset($_SESSION['username']))
{
	$_POST['message'] = str_replace('#','',$_POST['message']);
	
	$name = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt');
	$valids = '0123456789abcdefABCDEF';
	if(strspn($_POST['message'], $valids) != strlen($_POST['message']))exit('Запрещенные символы! Только ("0123456789 [a-f] и [A-F]")');
	if(mb_strlen($_POST['message']) != 6)exit('Необходимо 6 символов!');
	$rgb = hex2rgb($_POST['message']);
	//if($rgb[0]+$rgb[1]+$rgb[2] >= 651)exit('stop');
	write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/name_style.txt', '<span style="color:rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')">'.$name.'</span>');
	write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_nick_color_one.txt', '#'.$_POST['message']);
}
else exit('Ошибка.');
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
function hex2rgb($h){return array(hexdec(substr($h,0,2)), hexdec(substr($h,2,2)), hexdec(substr($h,4,2)));}
?>