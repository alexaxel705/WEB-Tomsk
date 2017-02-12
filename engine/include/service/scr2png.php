<?
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';


if($_FILES['userfile']['size'] > 25000)
{
	exit("Скрипт не принимает больше 25000 байт.");
}
else
{
	if(!file_exists("tmp.scr")){
	$_FILES['userfile']['name']="tmp.scr";
	$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/engine/include/service/';
	$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
	move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
	chmod($uploaddir."tmp.scr", 0777);
	exec("/usr/local/bin/scr2png < tmp.scr > tmptopng.png");
	echo '<img src="data:image/png;base64,' .base64_encode(file_get_contents('tmptopng.png')).'"/><br />';
	unlink('tmp.scr');
	unlink('tmptopng.png');
	}
	else
	{
		exit("Сервер перегружен, попробуйте позже.");
	}
}


?>
