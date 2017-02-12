<?
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';


if(getExtension2($_FILES['userfile']['name']) != 'png' && getExtension2($_FILES['userfile']['name']) != 'gif' && getExtension2($_FILES['userfile']['name']) != 'JPG' && getExtension2($_FILES['userfile']['name']) != 'jpg' && getExtension2($_FILES['userfile']['name']) != 'jpeg' && getExtension2($_FILES['userfile']['name']) != 'JPEG') 
{
   echo "Error: ".getExtension2($_FILES['userfile']['name']);
   exit;
}
else
{
	$_FILES['userfile']['name'] = GetInTranslit($_FILES['userfile']['name']);
	
	if($_POST['method'] == '0')
	{
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/photo.txt'))
		{
			$old_photo=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/photo.txt');
			$old_photo=substr($old_photo, 0, strpos($old_photo, '?'));
			unlink($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/photo/'.$old_photo);
		}
		$_FILES['userfile']['name'] = str_replace("?", '', $_FILES['userfile']['name']);
		$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/photo/';
		$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
		move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/photo.txt', $_FILES['userfile']['name'].'?'.rand(1,2000));
	}
	else if($_POST['method'] == '1')
	{
		$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/album/';
		$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
		move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
	}
	header("Location: http://".$_SERVER['HTTP_HOST'].$_POST['page']);
}

  function getExtension2($filename) {
    $path_info = pathinfo($filename);
    return $path_info['extension'];
  }
?>
