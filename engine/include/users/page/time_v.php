<?php
session_start();
if (isset($_SESSION['username']))
{
	if($_POST['message'] == 'false' || $_POST['message'] == 'true')
	{
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/time_v.txt', $_POST['message']);
	}
}
else exit('Ошибка.');
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
?>