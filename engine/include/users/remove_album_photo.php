<?
	session_start();
	if(isset($_SESSION['username']))
	{
		unlink($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/album/'.$_POST['photo']);
	}
?>