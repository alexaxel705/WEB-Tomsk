<?
	session_start();
	if (!isset($_SESSION['username']))
	{
		if(!isset($_SESSION['guestname']))exit;
		else $un=$_SESSION['guestname'];
	}
	else $un=$_SESSION['username'];

	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	$name = GetInTranslit($_GET['usr']);
	
	$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$un.'_ignore.arr'));
	if(in_array($name, $file) == true)
	{
		$key = array_search($name, $file);
		unset($file[$key]);
		write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$un.'_ignore.arr', json_encode($file));
	}
	else
	{
		$file[] = $name;
		write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/on/'.$un.'_ignore.arr', json_encode($file));
	}
	echo ' ';

?>