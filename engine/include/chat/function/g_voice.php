<?php
	session_start();
	if (!isset($_SESSION['username']))exit();
	if($_POST['message'] == '1')
	{
		$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$_SESSION['username'].'.arr'));
		$file->g_voice = '1';
		write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$_SESSION['username'].'.arr', json_encode($file));
	}
	else if($_POST['message'] == '2')
	{
		$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$_SESSION['username'].'.arr'));
		$file->g_voice = '2';
		write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$_SESSION['username'].'.arr', json_encode($file));
	}
?>

<?php
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
?>