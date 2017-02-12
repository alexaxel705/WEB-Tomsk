<?php
session_start();
if (isset($_SESSION['username']))
{
	if ($_POST['message'] == 'male')write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/sex.txt', '1');
	else write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/sex.txt', '2');
}
else echo 'Ошибка';
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
?>