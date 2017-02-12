<?php
	header("Content-Type: text/html; charset=UTF-8");
	session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head> 
	<title><? echo function_exists("page_title") ? page_title() :  '...'; ?></title> 
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/engine/css/ih5.css"/>
	<script src="/engine/java/scripts.js"></script>
	<script src="/engine/java/jquery-ui.min.js"></script>
	<?
	if (isset($_SESSION['username']))
	{
		$set_connection = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/set_connection.arr'));
		if($set_connection['head_update'] == 1)echo '<script>head_update();</script>';
	}
	?>
</head> 
<body>

<nav id="main_menu_header_block">
<a href="/" tabindex="1" class="nav_a">Главная страница</a>
<a tabindex="2" class="nav_a" href="/chat.php">Чат</a>
<!-- <a tabindex="3" class="nav_a" href="/forum/index.php">Форум</a> -->
<a tabindex="4" class="nav_a" href="/engine/include/service/index.php">Сервисы</a>
<a tabindex="5" class="nav_a" href="/engine/include/stats/stats.php">Статистика</a>
<a tabindex="6" class="nav_a" href="/database/users_list.php">Пользователи</a>
<a tabindex="7" class="nav_a" href="/database/faq.php">Справка</a>
<span class="right">
<?
if (isset($_SESSION['username']))
{
		$news = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/board_news.txt');
		echo  '<abbr title="Непрочитанных сообщений" id="my_page_update">'.$news.'</abbr><a tabindex="8" class="nav_a" href="/database/profile.php?'.$_SESSION['username'].'">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/login_translit.txt').'</a>';
		echo ' <a href="/engine/include/users/exit.php" class="nav_a" tabindex="9">выход</a>';
}
else
{
	echo '<a href="/engine/include/chat/index.php" class="nav_a" tabindex="9">войти</a>';
}
?>
</span>
</nav>



