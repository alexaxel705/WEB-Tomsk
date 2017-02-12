<?
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';


if($_FILES['userfile']['type'] != 'image/jpg' && $_FILES['userfile']['type'] != 'image/jpeg')
{
	exit("!= image/jpeg, image/jpg");
}
else
{
	if(!file_exists("tmp.jpg")){
	$_FILES['userfile']['name']="tmp.jpg";
	$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/engine/include/service/';
	$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
	$old_size=$_FILES["userfile"]["size"];
	move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
	chmod($uploaddir."tmp.jpg", 0777);
	exec("/usr/local/bin/jpegoptim --strip-all tmp.jpg");
	echo '<img src="data:image/jpg;base64,' .base64_encode(file_get_contents('tmp.jpg')).'"/><br />';
	echo 'До: '.$old_size.' Байт<br />';
	echo 'После: '.filesize($_SERVER['DOCUMENT_ROOT']."/engine/include/service/tmp.jpg").' Байт';
	unlink('tmp.jpg');
	}
	else
	{
		exit("Сервер перегружен, попробуйте позже.");
	}
}


?>
