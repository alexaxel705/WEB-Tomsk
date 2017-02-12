<?php
header('Content-type: application/json');
session_start();
if ($_SESSION['username'] == 'Alexey')
{
	if($_POST['message'] == '0')
	{
		$str = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/terminal/fn/usr_update/tmp/usr_str.txt');
		die(json_encode(
		array(
			'str'  => 'ok',
			'name' => $str
		  )
		));
	}
	else
	{
		$fs = file($_SERVER['DOCUMENT_ROOT'].'/engine/terminal/fn/usr_update/tmp/usr_list.txt');
		$line = $fs[$_POST['message']-1];
		$line = str_replace("\n",'',$line);
		
		//Для обновления index.php

		
		$newmsg = $_POST['message']-1;
		
		die(json_encode(
		array(
			'str'  => $newmsg,
			'name' => $line,
		  )
		));
	}
}
else exit;
?>

<?php
function GetInTranslit($string) {
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
        'ь' => "'",  'ы' => 'y',   'ъ' => "'",
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
        'Ь' => "'",  'Ы' => 'Y',   'Ъ' => "'",
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya', ' ' => '_',
    );
	return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}
?>