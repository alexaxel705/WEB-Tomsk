<?php
header("Content-Type: text/plain; charset=UTF-8");
session_start();
if (isset($_SESSION['username']))
{
	$_POST['message'] = str_replace('>','',$_POST['message']);
	$_POST['message'] = str_replace('<','',$_POST['message']);
	write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat/enter_chat_speak.txt', substr($_POST['message'], 0, 60));
}
else echo 'Ошибка.';
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
?>