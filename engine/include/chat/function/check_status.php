<?
	session_start();
	if(!isset($_SESSION['username']))
	{
		if(!isset($_SESSION['guestname']))exit;
	}
	
	if (isset($_SESSION['username']))
	{
		$usr_name = $_SESSION['username'];
	}
	else if (isset($_SESSION['guestname']))
	{
		$usr_name = $_SESSION['guestname'];
	}
		
	
	if($_POST['message'] == '1')
	{
		$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$usr_name.'.arr'));
		$file->status = '1';
		write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$usr_name.'.arr', json_encode($file));
	}
	else if($_POST['message'] == '2')
	{
		$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$usr_name.'.arr'));
		$file->status = '2';
		write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$usr_name.'.arr', json_encode($file));
	}
?>

<?
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
?>