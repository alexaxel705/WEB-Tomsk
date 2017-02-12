<?
session_start();
if($_GET['l'] == 0)$_SESSION['lang'] = 0;
else if($_GET['l'] == 1)$_SESSION['lang'] = 1;
if($_SERVER['HTTP_REFERER']=='')$r='/index.php';
else $r=$_SERVER['HTTP_REFERER'];
header("Request-URI: ".$r);
header("Content-Location: ".$r);
header("Location: ".$r);
?>