<?php
	session_start();
	date_default_timezone_set('Etc/GMT-7');
	$_POST['name'] = GetInTranslit($_POST['name']);//Если русский ник
	if(is_dir($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['name'])) 
	{
		$password = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['name'].'/password.txt');
		
		if($password != password($_POST['password']))
		{
			header("Location: http://".$_SERVER['HTTP_HOST'].'/engine/include/users/login_html.php');
		}
		else
		{
			$_SESSION['username'] = $_POST['name'];
			session_write_close();
			write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['name'].'/last_visit.txt', date("Y-m-d H:i:s"));
			header("Location: http://".$_SERVER['HTTP_HOST'].'/index.php');
		}
	}
	else
	{
		header("Location: http://".$_SERVER['HTTP_HOST'].'/engine/include/users/login_html.php');
	}
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

function password($password){return md5($password.'fjsjk904utfssdvvxetlerkte3252efggfghfgh...');} 
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
function write_ap($f, $c){$fw=fopen($f, 'a+');fwrite($fw, $c);fclose($fw);}
?>