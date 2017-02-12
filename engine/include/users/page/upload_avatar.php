<?php
session_start();

if($_FILES['userfile']['type'] != "image/gif" && $_FILES['userfile']['type'] != 'image/jpeg') 
{
	echo '<script>window.parent.document.getElementById("res").innerHTML="Только GIF формат.";</script>';
}
else
{
	$_FILES['userfile']['name'] = GetInTranslit_fp_tr($_FILES['userfile']['name']);
	$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/';
	$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);

	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
	{
		$md5 = md5('database/users/'.$_SESSION['username'].'/'.$_FILES['userfile']['name']);
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/avatar.txt', $_FILES['userfile']['name'].'?'.$md5);
		echo '<script>window.parent.avatar_upload_ok("/database/users/'.$_SESSION['username'].'/'.$_FILES['userfile']['name'].'?'.$md5.'");</script>';
	} 
	else 
	{
		echo '<script>window.parent.document.getElementById("res").innerHTML="Ошибка.";</script>';
	}
}
?>


<?php
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
function GetInTranslit_fp_tr($string) {
    $replace = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '',  'ы' => 'y',   'ъ' => '',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
 
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya', ' ' => '_',
    );
	return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}
?>