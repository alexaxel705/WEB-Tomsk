<?
session_start();
if($_POST['name'] == '')exit;
date_default_timezone_set('Etc/GMT-7');
$_POST['name'] = str_replace(' ','',$_POST['name']);
$real_post = $_POST['name'];
$_POST['name'] = GetInTranslit($_POST['name']);//Если русский ник

if($_POST['method'] == '/chat.php')
{
	$index_auth = '/engine/include/chat/index.php';
	$index_chat = '/chat.php';
}
else if($_POST['method'] == '/info.php')
{
	$index_auth = '/engine/include/chat/index.php';
	$index_chat = '/info.php';
}
else if($_POST['method'] == '/chat.wml')
{
	$index_auth = '/engine/include/chat/index.wml';
	$index_chat = '/chat.wml';
}



if($_POST['password'] == '')//Гостевая сессия
{
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/'.$_POST['name'].'.txt'))
	{
		header("Location: http://".$_SERVER['HTTP_HOST'].$index_auth.'?error_1=4');exit;
	}
	if(is_dir($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['name']))
	{
		header("Location: http://".$_SERVER['HTTP_HOST'].$index_auth.'?error_1=1');exit;
	}
	else
	{
		if(mb_strlen($_POST['name'], "UTF-8") > 15)
		{
			header("Location: http://".$_SERVER['HTTP_HOST'].$index_auth.'?error_1=2');exit;
		}
		$valids = '0123456789qwertyuioplkjhgfdsazxcvbnmёйцукенгшщзхъэждлорпавыфячсмитьбюQWERTYUIOPLKJHGFDSAZXCVBNMЁЙЦУКЕНГШЩЗХЪЭЖДЛОРПАВЫФЯЧСМИТЬБЮ_-\'';
		if (strspn($_POST['name'], $valids) != strlen($_POST['name'])) 
		{
			header("Location: http://".$_SERVER['HTTP_HOST'].$index_auth.'?error_1=3');exit;
		}
	}
	write_wb($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_POST['name'].'.txt', $real_post);
	write_wb($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_POST['name'].'_biu.arr', json_encode(array('b' => '0','i' => '0','u' => '0')));
	
	$r = rand(0,200);
	$g = rand(0,200);
	$b = rand(0,200);
	write_wb($_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_POST['name'].'_color.arr', json_encode(array('one' => rgbtohex($r, $g, $b),'two' => rgbtohex($b, rand(0,200), $r))));
	$_SESSION['guestname'] = $_POST['name'];
	header("Location: http://".$_SERVER['HTTP_HOST'].$index_chat);exit;
}
else
{
	if(is_dir($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['name'])) 
	{
		$password = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['name'].'/password.txt');
		
		if($password != password($_POST['password']))
		{
			header("Location: http://".$_SERVER['HTTP_HOST'].$index_auth);
		}
		else
		{
			$_SESSION['username'] = $_POST['name'];
			write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_POST['name'].'/last_visit.txt', date("Y-m-d H:i:s"));
			header("Location: http://".$_SERVER['HTTP_HOST'].$index_chat);
		}
	}
	else
	{
		header("Location: http://".$_SERVER['HTTP_HOST'].$index_auth);
	}
}
?>


<?

function rgbtohex($r, $g, $b){
$hex = "#";
$hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
$hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
$hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
return $hex;
}
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