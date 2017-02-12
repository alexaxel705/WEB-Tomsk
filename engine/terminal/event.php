<?php
session_start();
if (!isset($_SESSION['username']))exit("Fatal error");

$valids = '0123456789qwertyuioplkjhgfdsazxcvbnmёйцукенгшщзхъэждлорпавыфячсмитьбюQWERTYUIOPLKJHGFDSAZXCVBNMЁЙЦУКЕНГШЩЗХЪЭЖДЛОРПАВЫФЯЧСМИТЬБЮ_?:)=! +-'.implode('',range('a','z')).'&%$';
if (strspn($_POST['message'], $valids) != strlen($_POST['message'])) 
{
	exit('fatal error');
}
if($_POST['message'] == '4 8 15 16 23 42')
{
	if(file_exists('on/'.$_SESSION['username'].'.txt') == true)
	{
		$fp=fopen('/var/www/engine/terminal/on/'.$_SESSION['username'].'.txt', 'wb');
		fwrite($fp, $_SERVER['REQUEST_TIME']);
		fclose($fp);
		echo "<script>document.getElementById('term_body').innerHTML = '<div id=term_pol>>: <input id=term_input onblur=this.focus() onkeydown=if(event.keyCode==13){go_term();} type=text/></div>';document.getElementById('term_input').focus();document.getElementById('term_beep').play();</script>";
	}
	else
	{
		$fp=fopen('/var/www/engine/terminal/on/'.$_SESSION['username'].'.txt', 'wb');
		fwrite($fp, $_SERVER['REQUEST_TIME']);
		fclose($fp);
		$cont = '<center><div id="term_head_str_1">1</div><div id="term_head_str_2">0</div><div id="term_head_str_3">8</div><div id="term_head_str_4">0</div><div id="term_head_str_5">0</div></center>';
		echo "<script>
		document.getElementById('term_body').innerHTML  = '';
		document.getElementById('term_cont').innerHTML += '".$cont."';
		document.getElementById('term_body').innerHTML += '# By now your name and particulars have been fed into every laptop, desktop, mainframe and supermarket scanner that collectively make up the global information conspiracy, otherwise known as \"The Beast.\"<div id=term_pol>>: <input id=term_input onblur=this.focus() onkeydown=if(event.keyCode==13){go_term();} type=text/></div>'; 
		document.getElementById('term_input').focus();
		document.getElementById('term_beep').play();
		term_display();</script>";
	}
	
}
if($_POST['message'] == 'help')
{
	echo ">: You see this little hole? This moth's just about to emerge. It's in there right now, struggling. It's digging it's way through the thick hide of the cocoon. Now, I could help it - take my knife, gently widen the opening, and the moth would be free - but it would be too weak to survive. Struggle is nature's way of strengthening it...";
}
else if($_POST['message'] == 'chess')
{
		echo '>: Computers have already beaten the Communists at chess. Next thing you know, they\'ll be beating humans.';
}
else if($_POST['message'] == 'start users update')
{
	if ($_SESSION['username'] == 'Alexey')
	{
		echo '<div id="fn_users_update">Сканирование пользователей</div><script>start_users_update();</script>';
	}
	else
	{
		echo 'Нет прав доступа...';
	}
}
else if($_POST['message'] == 'edit smile')
{
	if ($_SESSION['username'] == 'Alexey')
	{
		echo '<script>start_smile_edit();</script>';
	}
	else
	{
		echo 'Нет прав доступа...';
	}
}
else if($_POST['message'] == 'start smile update')
{
	if ($_SESSION['username'] == 'Alexey')
	{
		echo '<div id="fn_users_update">Процесс генерации смайлов...</div><script>start_smile_update();</script>';
	}
	else
	{
		echo 'Нет прав доступа...';
	}
}
else
{
	echo ">: ".$_POST['message'].': command not found';
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

?>
