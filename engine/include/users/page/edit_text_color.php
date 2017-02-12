<?php
session_start();
if (isset($_SESSION['username']))
{
	if(mb_strlen($_POST['message']) == 7)write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_text_color_one.txt', $_POST['message']);
}
if (isset($_SESSION['guestname']))
{
	if(mb_strlen($_POST['message']) == 7)
	{
		$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'_color.arr'));
		$file->one=$_POST['message'];
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'_color.arr', json_encode($file));
	}
}
else exit('Ошибка.');
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
?>