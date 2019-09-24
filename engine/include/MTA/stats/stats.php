<?php
include $_SERVER['DOCUMENT_ROOT'].'/head_menu.php';
function page_title(){return "Статистика";}


$playtime = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/stats/time.arr'), true)/1000;
$h = intval($playtime / 3600);
$m = intval($playtime / 60)%60;
$s = intval($playtime % 60);
$out_times = "";
if($h >= 1)
{
	$out_times = $h.' ч. '.$m.' м. '.$s.' с.';
}
else if($m >= 1)
{
	$out_times = $m.' мин. '.$s.' сек.';
}
else if($s > -1)
{
	$out_times = $s.' сек.';
}




$dat = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/stats/deaths.arr'), true);
$deaths = 0;

while(list($key, $val) = each($dat)){
	while(list($key2, $val2) = each($val)){
		
		$deaths = $deaths+$val2;
	}
}


?>


<script>
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight+'px';
    obj.style.width = obj.contentWindow.document.body.scrollWidth+'px';
  }
  
	function showmap() {
        document.getElementById("map").src = "http://109.227.228.4/engine/include/MTA/stats/zonesmap.php";
    }
	function showdeaths() {
        document.getElementById("map").src = "http://109.227.228.4/engine/include/MTA/stats/deathmap.php";
    }  
</script>

<div id="server_stats_all_table">

<div id="server_stats_disk_space_box">
<center>
<iframe src="http://109.227.228.4/engine/include/MTA/stats/deathmap.php" id="map" frameborder="0" scrolling="no" onload="resizeIframe(this)"> </iframe>
<br />
<b onclick="showdeaths()">Смерти</b> - <b onclick="showmap()">Зоны</b>
<div class="progressbar_server_stats" id="pb_server_stats"><div></div></div>
<div id="server_stats_space_box_var">
<div class="server_stats_space_box_stats_1 left border_shadow">Всего</div>
<div class="server_stats_space_box_stats_2 left border_shadow">Свободно</div>
<div class="server_stats_space_box_stats_3 left border_shadow">Занято</div>
<div class="server_stats_space_box_stats_1 left border_shadow"><?php echo "свободно"; ?></div>
<div class="server_stats_space_box_stats_2 left border_shadow"><?php echo "свободно"; ?></div>
<div class="server_stats_space_box_stats_3 left border_shadow"><?php echo $busySpace."свободно"; ?></div>
</div>
</center>
</div>
<div class="server_stats_users_box_max">Всего жителей: <?php $dDir = opendir($_SERVER['DOCUMENT_ROOT'].'/database/users/');$aFileList = array();while ($sFileName=readdir($dDir)) { if ($sFileName!='.' && $sFileName!='..') {$aFileList[]=$sFileName; }}closedir ($dDir); echo count($aFileList)-4; ?>
</div>
<div class="server_stats_users_box"><?php echo "Количество смертей: ".$deaths;?></div>
<div class="server_stats_users_box"><?php echo "Среднее время в игре: ".$out_times; ?></div>
<div class="server_stats_users_box">
Популярные фразы: <br />
	<?php
		include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
		$dat = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/stats/words.arr'), true);
		
		foreach ($dat as $x => $value) {
			$text = $x;
			echo $value.": ".$text."<br />";
		}
	?>
</div>








<style>
.server_stats_users_box_max{
	text-align:center;
	height:25px;
	line-height:25px;
	width:44%;
	color: #fff;
	background: #111;
	border: 1px solid #000;
	border-right: 1px solid #353535;
	border-bottom: 1px solid #353535;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	float:left;
}

.server_stats_users_box{
	text-align:center;
	height:25px;
	line-height:25px;
	width:22%;
	color: #fff;
	background: #111;
	border: 1px solid #000;
	border-right: 1px solid #353535;
	border-bottom: 1px solid #353535;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	float:left;
}




.server_stats_space_box_stats_1{
width:30%;
height:25px;
line-height:25px;
}
.server_stats_space_box_stats_2{
width:40%;
height:25px;
line-height:25px;
}
.server_stats_space_box_stats_3{
width:30%;
height:25px;
line-height:25px;
}
#server_stats_space_box_var{
background-color:white;
color:black;
width:100%;
height:50px;
}


#server_stats_disk_space_box
{
	float:left;
	width:50%;
	color: #fff;
	padding: 2%;
	background: #111;
	border: 1px solid #000;
	border-right: 1px solid #353535;
	border-bottom: 1px solid #353535;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}
div.progressbar_server_stats
{
	width:100%;
	-moz-box-shadow: 0 0 4px rgba(0,0,0,0.4) inset; /* Для Firefox */
	-webkit-box-shadow: 0 0 4px rgba(0,0,0,0.4) inset; /* Для Safari и Chrome */
	box-shadow: 0 0 4px rgba(0,0,0,0.4) inset; /* Параметры тени */
	background-color: white;
	border-radius: 3px 3px 0 0;
	-o-border-radius: 3px 3px 0 0;
	-moz-border-radius: 3px 3px 0 0;
	-webkit-border-radius: 3px 3px 0 0;	
	width:100%;
}

div.progressbar_server_stats div
{
	width:0px;
	background: url('/engine/images/progress_bar_bg.gif') 0px 0px repeat;
	height: 20px;
	text-align: center;
	font-size: 11px; font-weight: bold; color: #fff; line-height: 20px;
	text-shadow: 0px 0px 3px #000;
	-o-text-shadow: 0px 0px 3px #000;
	-moz-text-shadow: 0px 0px 3px #000;
	-webkit-text-shadow: 0px 0px 3px #000;
	border-radius: 2px;
	-o-border-radius: 2px;
	-moz-border-radius: 2px;
	-webkit-border-radius: 2px;
}
#server_stats_all_table{
padding:2%;
background-color:#222;
width:96%;
height:100%;
float:left;
}
</style>





<script type="text/javascript">
var procent = "<?php 
echo 40;
?>";
$('#pb_server_stats div').stop(true).animate({width: procent + '%'});
$('#pb_server_stats div').text(procent + '%');
</script>

<?php
function file_size($size)
{
    $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 0) . $filesizename[$i] : '0 Bytes';
}
function dir_size($dir) {
$totalsize=0;
if ($dirstream = @opendir($dir)) {
while (false !== ($filename = readdir($dirstream))) {
if ($filename!="." && $filename!="..")
{
if (is_file($dir."/".$filename))
$totalsize+=filesize($dir."/".$filename);

if (is_dir($dir."/".$filename))
$totalsize+=dir_size($dir."/".$filename);
}
}
}
closedir($dirstream);
return $totalsize;
}
?>

