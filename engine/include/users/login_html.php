<?php
	include $_SERVER['DOCUMENT_ROOT'].'/head_menu.php';
	if(isset($_SESSION['username']))header("Location: http://".$_SERVER['HTTP_HOST'].'/index.php');
?>
<form action="/engine/include/users/login.php" method="POST">
<center>
	Логин:<br />
	<input type="text" name="name" required><br />
	Пароль:<br />
	<input type="password" name="password" required><br />
	
	<input type="submit" value="Отправить"/>
</center>
</form>