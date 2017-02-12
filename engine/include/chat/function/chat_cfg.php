<?
	session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	if (isset($_SESSION['username']))
	{
		$lor=json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_cfg.arr'));
		if($lor[1] == '0')
		{
			$lor[1]='1';
		}
		else
		{
			$lor[1]='0';
		}
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_cfg.arr', json_encode($lor));
	}
	header("Location: http://".$_SERVER['HTTP_HOST'].'/chat.php');
?>