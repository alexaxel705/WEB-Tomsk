<?php
	session_start();
	if ($_SESSION['username'] == 'Alexey')
	{
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/engine/terminal/fn/usr_update/tmp/usr_list.txt'))
		{
			unlink($_SERVER['DOCUMENT_ROOT'].'/engine/terminal/fn/usr_update/tmp/usr_list.txt');
		}
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/engine/terminal/fn/usr_update/tmp/usr_str.txt'))
		{
			unlink($_SERVER['DOCUMENT_ROOT'].'/engine/terminal/fn/usr_update/tmp/usr_str.txt');
		}
		$u=0;
		$users_file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/db_users.arr'));//Сканирование пользователей, создание временных файлов для других задач.
		foreach($users_file as $users_file)
		{
			write_ap($_SERVER['DOCUMENT_ROOT'].'/engine/terminal/fn/usr_update/tmp/usr_list.txt', $users_file."\n");
			$u++;
		}
		echo '('.$u.') пользователей<script>users_update_stage_1(\''.$u.'\');</script>';
		write_ap($_SERVER['DOCUMENT_ROOT'].'/engine/terminal/fn/usr_update/tmp/usr_str.txt', $u);
	}
	else
	{
		exit;
	}
?>

<?php
function write_ap($f, $c){$fw=fopen($f, 'a+');fwrite($fw, $c);fclose($fw);}
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