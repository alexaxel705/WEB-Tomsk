<?php
header('Content-type: application/json');
session_start();
if ($_SESSION['username'] == 'Alexey')
{
	if($_POST['message'] == '0')
	{
		unlink($_SERVER['DOCUMENT_ROOT'].'/engine/terminal/fn/usr_update/tmp/usr_list.txt');
		unlink($_SERVER['DOCUMENT_ROOT'].'/engine/terminal/fn/usr_update/tmp/usr_str.txt');
		die(json_encode(
		array(
			'str'  => 'ok',
			'name' => 'ok',
			'pro' => 'ok'
		  )
		));
	}
	else
	{

		$fs = file($_SERVER['DOCUMENT_ROOT'].'/engine/terminal/fn/usr_update/tmp/usr_list.txt');
		$line = $fs[$_POST['message']-1];
		$line = str_replace("\n",'',$line);



		/*$torb=json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.GetInTranslit($line).'/biu.arr'));
		unset($torb->u);
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.GetInTranslit($line).'/biu.arr', json_encode($torb));*/
		//unlink($_SERVER['DOCUMENT_ROOT'].'/database/users/'.GetInTranslit($line).'/fail_password.txt');
		
		
		//Для обновления index.php
		
		//write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.GetInTranslit($line).'/board.arr', serialize(array()));
		//write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.GetInTranslit($line).'/price_html.txt', '');
		//write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.GetInTranslit($line).'/chat_top_or_bottom.txt', '0');
		//unlink($_SERVER['DOCUMENT_ROOT'].'/database/users/'.GetInTranslit($line).'/chat/chat_time.txt');
		//unlink($_SERVER['DOCUMENT_ROOT'].'/database/users/'.GetInTranslit($line).'/chat/enter_chat_speak.txt');
		//unlink($_SERVER['DOCUMENT_ROOT'].'/database/users/'.GetInTranslit($line).'/friends.php');
		//copy($_SERVER['DOCUMENT_ROOT'].'/engine/include/users/price_page.php', $_SERVER['DOCUMENT_ROOT'].'/database/users/'.GetInTranslit($line).'/price_page.php');
		//mkdir($_SERVER['DOCUMENT_ROOT']."/database/users/".GetInTranslit($line)."/blog", 0755);

		//rmdir($_SERVER['DOCUMENT_ROOT']."/database/users/".GetInTranslit($line)."/chat/");
		
		$usr_str_txt = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/terminal/fn/usr_update/tmp/usr_str.txt');
	
		$newmsg = $_POST['message']-1;
		
		die(json_encode(
		array(
			'str'  => $newmsg,
			'name' => $line,
			'pro' => '['.$_POST['message'].'/'.$usr_str_txt.']'
		  )
		));
	}
}
else exit;
?>


<?php
function rgbtohex($r, $g, $b){
$hex = "#";
$hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
$hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
$hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
return $hex;
}
function hex2rgb($h){return array(hexdec(substr($h,0,2)), hexdec(substr($h,2,2)), hexdec(substr($h,4,2)));}
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
function write_ap($f, $c){$fw=fopen($f, 'a+');fwrite($fw, $c);fclose($fw);}
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