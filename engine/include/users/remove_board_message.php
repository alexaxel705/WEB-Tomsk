<?
session_start();
if(isset($_SESSION['username']))
{
	$arr = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['usr'].'/board.arr'));
	if($arr[$_GET['id']]['w'] == $_SESSION['username'] || $_SESSION['username'] == $_GET['usr'])
	{
		unset($arr[$_GET['id']]);
		$arr = array_values($arr);
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_GET['usr'].'/board.arr', serialize($arr));
		header("Location: http://".$_SERVER['HTTP_HOST'].'/database/profile.php?'.$_GET['usr']);
	}
	else
	{
		exit('Ошибка!');
	}
}
else
{
	exit('Ошибка!');
}
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
?>
