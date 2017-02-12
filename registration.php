<?php
	include $_SERVER['DOCUMENT_ROOT'].'/head_menu.php';
	if(isset($_SESSION['username']))header("Location: http://".$_SERVER['HTTP_HOST'].'/index.php');
	function page_title(){return "Регистрация в чате";}
?>

<div style="text-align:center;">
<b>Регистрация</b>
<form action="/engine/include/users/create/save_user.php" method="POST">
	Логин:<br />
	<input type="text" name="login" required/><br />
	Пароль:<br />
	<input type="password" name="password" required/><br />
	<select size="1" name="reg_sex">
	    <option value="Мужской">Мужской</option>
	    <option value="Женский">Женский</option>
 	</select><br />
	<?
		$a=rand(1, 9);
		$b=rand(1, 9);
		echo $a.'+'.$b.'=?<br />';
	?>
	<input type="hidden" name="reg_bot_test_a" value="<? echo $a;?>"/>
	<input type="hidden" name="reg_bot_test_b" value="<? echo $b;?>"/>
	<input type="text" size="2"  maxlength="2" name="reg_bot_test"/><br />
	<input value="Отправить" type="submit"/>
</form>
</div>
