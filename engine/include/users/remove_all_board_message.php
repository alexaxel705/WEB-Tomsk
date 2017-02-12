<?
session_start();
if (isset($_SESSION['username']))//Определение сессии. Есть ли ник
{
	write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/board.arr', serialize(array()));
	write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/board_id_message.txt', '0');
	write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/board_news.txt', '0');
	header("Location: http://".$_SERVER['HTTP_HOST'].'/database/profile.php?'.$_SESSION['username']);
}
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
?>