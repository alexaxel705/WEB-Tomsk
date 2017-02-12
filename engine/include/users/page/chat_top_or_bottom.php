<?
session_start();
if (isset($_SESSION['username']))
{
	if($_POST['message'] == 'bottom')
	{
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_top_or_bottom.txt', '0');
	}
	else if($_POST['message'] == 'top')
	{
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_top_or_bottom.txt', '1');
	}
}
else exit('Ошибка.');
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
?>