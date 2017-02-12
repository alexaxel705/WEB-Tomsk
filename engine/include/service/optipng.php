<?
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';


if($_FILES['userfile']['type'] != 'image/png')
{
	exit("!= image/png");
}
else
{
	if(!file_exists("tmp.png")){
	$_FILES['userfile']['name']="tmp.png";
	$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/engine/include/service/';
	$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
	$old_size=$_FILES["userfile"]["size"];
	move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
	chmod($uploaddir."tmp.png", 0777);
	passthru("/usr/local/bin/optipng tmp.png");
	echo '<img src="data:image/png;base64,' .base64_encode(file_get_contents('tmp.png')).'"/><br />';
	echo 'До: '.$old_size.' Байт<br />';
	echo 'После: '.filesize($_SERVER['DOCUMENT_ROOT']."/engine/include/service/tmp.png").' Байт';
	unlink('tmp.png');
	}
	else
	{
		exit("Сервер перегружен, попробуйте позже.");
	}
}


?>
