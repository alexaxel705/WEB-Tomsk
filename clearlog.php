<?
file_put_contents('engine\include\chat\lgchat86123.txt', '');
?>

<?php  
// так получаем URL, с которого пришёл посетитель  
$back = $_SERVER['HTTP_REFERER']; // для справки, не обязательно создавать переменную

// Теперь создаём страницу, пересылающую
// в meta теге на предыдущую
echo "
<html>
  <head>
   <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
  </head>
</html>";
?>