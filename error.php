<style>
body{margin:0 auto;width:50%;background-color:#eee;font-size:15px;}
</style>
<?
$rand = rand(0,2);
if($rand == '0')
{
	$link = 'http://www.youtube.com/embed/BkmRTjfFZ3w';
	$text = '<b>404!</b> <font color="RED">(\/) (;,,;) (\/)</font> WHOOP-WHOOP-WHOOP!!!';
}
else if($rand == '1')
{
	$link = 'http://www.youtube.com/embed/-7akjeomUck';
	$text = 'Ошибка <b>404</b>!';
}
else if($rand == '2')
{
	$link = 'http://www.youtube.com/embed/m5-UiePMJjA';
	$text = '<font color="ORANGE"><</font>^^) Ошибка <b>404</b>!';
}
?>
<center><iframe width="420" height="315" src="<? echo $link;?>" frameborder="0" allowfullscreen></iframe><br />
<font><? echo $text;?></font></center>

<!--Need help? http://92.243.110.79/engine/terminal/term.php-->





