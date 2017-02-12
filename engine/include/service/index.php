<?
include $_SERVER['DOCUMENT_ROOT'].'/head_menu.php';
include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
function page_title(){return "Сервисы";}
?>

<table id="service_table">
<tr><td>Название</td><td>Файл</td><td>Утилита</td></tr>
<tr><td>Оптимизация png</td>
<td><form action="optipng.php" enctype="multipart/form-data" method="post">
<input type="file" accept="image/png" name="userfile"/>
<input type="submit" value="Отправить"/></form></td>
<td><code>optipng file.png</code></td>
</tr>

<tr>
<td>Оптимизация jpeg</td>
<td><form action="jpegoptim.php" enctype="multipart/form-data" method="post">
<input type="file" accept="image/jpg,image/jpeg" name="userfile"/>
<input type="submit" value="Отправить"/></form></td>
<td><code>jpegoptim --strip-all file.jpg</code></td>
</tr>

<tr>
<td>scr в png</td>
<td><form action="scr2png.php" enctype="multipart/form-data" method="post">
<input type="file" name="userfile"/>
<input type="submit" value="Отправить"/></form></td>
<td><code>scr2png &lt; file.scr &gt; file.png</code></td>
</tr>
</table>