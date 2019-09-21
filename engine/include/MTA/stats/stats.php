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

$df = disk_free_space("/");
$dt = disk_total_space("/");

//	Свободное место
$freeSpace = $df / 1048576;
$freeUnit = 'Mb';
if ($freeSpace >= 1024) {
	$freeSpace /= 1024;
	$freeUnit = 'Gb';
}

//	Занятое место
$busySpace = ($dt - $df) / 1048576;
$busyUnit = 'Mb';
if ($busySpace >= 1024) {
	$busySpace /= 1024;
	$busyUnit = 'Gb';
}

//	Всего места
$totalSpace = $dt / 1048576;
$totalUnit = 'Mb';
if ($totalSpace >= 1024) {
	$totalSpace /= 1024;
	$totalUnit = 'Gb';
}

//	Проценты
$freePer = round($df / $dt * 100.0, 0);			//	Свободного
if ($freePer > 100)
	$freePer = 100;

$busyPer = 100 - $freePer;						//	Занятого


//	Округляем
$freeSpace = round($freeSpace, 1);
$busySpace = round($busySpace, 1);
$totalSpace = round($totalSpace, 1);


?>




<div id="server_stats_all_table">

<div id="server_stats_disk_space_box">
<center>
<img src="/engine/include/MTA/stats/SanAndreas.jpg" width="100%" style="vertical-align:bottom; margin-top:-25px;"/>
<div class="progressbar_server_stats" id="pb_server_stats"><div></div></div>
<div id="server_stats_space_box_var">
<div class="server_stats_space_box_stats_1 left border_shadow">Всего:</div>
<div class="server_stats_space_box_stats_2 left border_shadow">Свободно:</div>
<div class="server_stats_space_box_stats_3 left border_shadow">Занято:</div>
<div class="server_stats_space_box_stats_1 left border_shadow"><?php echo $totalSpace." GB"; ?></div>
<div class="server_stats_space_box_stats_2 left border_shadow"><?php echo $freeSpace." GB"; ?></div>
<div class="server_stats_space_box_stats_3 left border_shadow"><?php echo $busySpace." GB"; ?></div>
</div>
</center>
</div>
<div class="server_stats_users_box_max">Всего пользователей: <?php $dDir = opendir($_SERVER['DOCUMENT_ROOT'].'/database/users/');$aFileList = array();while ($sFileName=readdir($dDir)) { if ($sFileName!='.' && $sFileName!='..') {$aFileList[]=$sFileName; }}closedir ($dDir); echo count($aFileList)-4; ?>
</div>
<div class="server_stats_users_box"><?php echo "Всего смертей: ".$deaths;?></div>
<div class="server_stats_users_box"><?php echo "Среднее время в игре: ".$out_times; ?></div>








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
$busySpace = (disk_total_space("/") - disk_free_space("/")) / 1048576;
if ($busySpace >= 1024) {
	$busySpace /= 1024;
}
$totalSpace = disk_total_space("/") / 1048576;
if ($totalSpace >= 1024) {
	$totalSpace /= 1024;
}
echo round(round($busySpace, 1)/round($totalSpace, 1)*100, 1);
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
