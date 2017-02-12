<?php
	include $_SERVER['DOCUMENT_ROOT'].'/head_menu.php';
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/function/chat_fn.php';
	if(isset($_SESSION['username']) || isset($_SESSION['guestname']))
	{
		header("Location: http://".$_SERVER['HTTP_HOST'].'/chat.php');
	}
?>

<center>
<fieldset><legend class="bold">Чат без регистрации</legend>
<form action="/engine/include/chat/function/auth.php" method="POST">
	<input type="hidden" name="method" value="<? echo mobile_detect();?>">
	Логин:<br />
	<input type="text" name="name" required><br />
	Пароль (не обязательно):<br />
	<input type="password" name="password"><br />
	
	<input type="submit" value="Отправить"/>

</form>
</fieldset>
<?
if(isset($_GET['error_1']))
{
	if($_GET['error_1'] == '1')echo 'Ник занят!<br />';
	if($_GET['error_1'] == '2')echo 'Максимальное число символов в нике - 15!<br />';
	if($_GET['error_1'] == '3')echo 'Запрещенные символы! от [А-Я] [A-Z] [0-9] _ и -';
	if($_GET['error_1'] == '4')echo 'Пользователь с таким ником уже есть в чате.';
}
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
</center>