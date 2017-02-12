<?
include 'head_menu.php';
function page_title(){return "Томский чат свободного общения";}
include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
?>



<?php
	$users_file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/db_users.arr'));
	
	$outusr=0;
	$dh = opendir($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/online/');
	while ($file = readdir($dh)): 
	if ($file != '.' && $file != '..')
	{
		$outusr++;
	}
	endwhile; 
	closedir($dh);
?>

<table class="width_100pr"><tr>
<td style="width:340px;vertical-align:top;">
<div class="bg_m_h border_b tx_align_center">События</div>
<?
$arr_act=json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/last_act.arr'));
for($i=0;$i<=20;$i++)
{
	echo '<p class="main_act_list">'.$arr_act[$i].'</p>';
}
?>
</td>

<td  style="vertical-align:top;">
<h1 class="bg_m_h border_b tx_align_center">Информация о чате</h1>
<div style="padding:0 5px;">
<ul><li>Возможность редактировать содержимое чата (локально)</li>
<li>Игнор</li>
<li>Антифлуд</li>
<li>Личные сообщения</li>
<li>Графические смайлы (опционально)</li>
<li>Возможность выбрать цвет ника</li>
<li>Возможность выбрать цвет текста</li>
<li>Аватары</li>
<li>Автоматическая смена статуса после простоя</li>
<li>Индикатор печати</li></ul>
</div>
</td>

<td style="width:240px;vertical-align:top;" class="tx_align_center">
<div class="bg_m_h border_b">Сейчас в чате <? echo $outusr;?> чел.</div>
<? if(isset($_SESSION['username']) || isset($_SESSION['guestname']))
{
	echo '<div class="main_page_input_style_div">
		<div style="width:100%;">
		<form style="display: inline;" method="get" action="'.mobile_detect().'"><input tabindex="12" class="main_button"  type="submit" value="Войти"/></form>
		<form style="display: inline;" method="post" action="/engine/include/users/exit.php"><input tabindex="13" class="main_button" type="submit" value="Выйти"/></form>
		</div>
		</div>';
}
else
{
	echo '<form style="display: inline;" action="/engine/include/chat/function/auth.php" method="post">
		<input type="hidden" name="method" value="'.mobile_detect().'">
		<input type="text" class="main_input" title="Логин" placeholder="Логин" name="name" required/>
		<input type="password" class="main_input" title="Для зарегистрированных" placeholder="Пароль" name="password"/>
		<input type="submit" class="main_button" value="Войти"/>
	</form>
	<form style="display: inline;" action="/registration.php"><input class="main_button_reg" type="submit" value="Регистрация"/></form><br />';
}
?>
<a href="/info.php">Версия для iPhone\Android</a><br />
<a href="/chat.wml">Мобильная версия (WAP)</a><br />
<a href="/chat.php">Версия для ПК</a><br />
<br />
<b>Minecraft:</b><br />
<a href="/Minecraft Distr.zip">Клиент</a><br />90.188.118.7:25566<br /><br />
<b>MTA SA:</b><br />
<a href="/RPG RealLife Mod.zip">Исходники RPG RealLife</a><br />109.227.228.4:22003<br />
<div style="padding:2px 0;" class="width_100pr border_t"><a href="mailto:alexaxel705@gmail.com">Техническая поддержка</a></div>
</td>
</tr></table>



<?php
/*foreach (glob("download/*.txd") as $Picture)
{
    echo '&#60;file src="'.$Picture.'" download="false" /&#62;</br>';
}*/



/*foreach (glob("download/*.txd") as $Picture)
{
	$order   = array("download/", ".txd", "\r");
	$replace = '';

	// Обрабатывает сначала \r\n для избежания их повторной замены.
	echo $newstr = '"'.str_replace($order, $replace, $Picture).'",</br>';

}*/
?>





<?
	include $_SERVER['DOCUMENT_ROOT'].'/footer.php';
	function mobile_detect()
	{
	    $user_agent = $_SERVER['HTTP_USER_AGENT'];
	
	    $ipod = strpos($user_agent,"iPod");
	    $iphone = strpos($user_agent,"iPhone");
	    $android = strpos($user_agent,"Android");
	    $symb = strpos($user_agent,"Symbian");
	    $winphone = strpos($user_agent,"WindowsPhone");
	    $wp7 = strpos($user_agent,"WP7");
	    $wp8 = strpos($user_agent,"WP8");
	    $operam = strpos($user_agent,"Opera M");
	    $palm = strpos($user_agent,"webOS");
	    $berry = strpos($user_agent,"BlackBerry");
	    $mobile = strpos($user_agent,"Mobile");
	    $htc = strpos($user_agent,"HTC_");
	    $fennec = strpos($user_agent,"Fennec/");
	
	    if ($ipod || $iphone || $android || $symb || $winphone || $wp7 || $wp8 || $operam || $palm || $berry || $mobile || $htc || $fennec) 
	    {
	        return "/info.php";
	    } 
	    else
	    {
	        return "/chat.php";
	    }
}
?>


</body>
</html>



