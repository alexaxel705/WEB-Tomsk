<?php
	include $_SERVER['DOCUMENT_ROOT'].'/head_menu.php';
	function page_title(){return "Справка";}
?>

<div style="padding:10px; 30px;font-size:20px;border-bottom:1px solid black;">
Чат: <a href="faq.php#about_input">Способы ввода</a>, 
<a href="faq.php#about_rules">ограничения</a>, 
<a href="faq.php#about_morse">азбука Морзе</a>, 
<a href="faq.php#about_future">планы</a><br />
Блог:  <a href="faq.php#about_blog_tags">Теги</a>
</div>

<div style="font-size:16px;padding:0 15px;">


<div id="about_input" style="font-size:22px;padding:8px 0 2px 0;">Способы ввода</div>
<ul>
<li>Клавиатура (классический)</li>
<li>Мышка (виртуальная клавиатура)</li>
<li><a href="faq.php#about_morse">Азбука Морзе</a></li>
</ul>

<div id="about_rules" style="font-size:22px;padding:8px 0 2px 0;">Ограничения</div>
<ul>
<li>Максимальная длина сообщения 800 символов (контролирует скрипт на сервере)</li>
<li>Два одинаковых сообщения подряд (контролирует скрипт на сервере)</li>
<li>Максимальная длина одного слова 200 символов</li>
<li>Не более 3-х графических смайлов за одно сообщение (контролирует скрипт у клиента)</li>
</ul>

<div id="about_morse" style="font-size:22px;padding:8px 0 2px 0;">Азбука Морзе</div>

Клавиша - End<br />
1 короткий - удерживать клавишу менее 100мс.<br />
1 длинный - удерживать клавишу более 100мс.<br />
<a href="http://ru.wikipedia.org/wiki/Азбука_Морзе">http://ru.wikipedia.org/wiki/Азбука_Морзе</a>


<br />
<div id="about_future" style="font-size:22px;padding:8px 0 2px 0;">Планы</div>
Что следует добавить:<br />
<ul>
<li>Удобное цитирование сообщений</li>
</ul>
<br />
Что следует переделать:<br />
<ul>
<li>Версию чата для iPhone\Android</li>
<li>Справку</li>
</ul>
<br />
Нет и не будет:<br />
<ul>
<li>Сбор информации о пользователе(IP, UserAgent)</li>
<li>Банов, заглушек, киков</li>
<li>Пользователей с полномочиями (администратор, модератор)</li>
<li>Разные шрифты в чате</li>
<li>Графические ники</li>
<li>Градиентные ники</li>
<li>Ников в стиле "зебра"</li>
<li>Плагинов</li>
<li>Антимата</li>
<li>Антикапса</li>
</ul>
<br />



<div id="about_blog_tags" style="font-size:22px;padding:8px 0 2px 0;">Теги</div>
[spoiler][/spoiler]<br />
[code][/code]<br />
[left][/left]<br />
[right][/right]<br />
[center][/center]<br />
[img][/img]<br />
[link][/link]<br />
<br />
</div>





