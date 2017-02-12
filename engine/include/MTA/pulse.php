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
</head> 



<body>
	<div id="test"></div>
</body>

<script type="text/javascript">


setInterval(function(){
	 
	 $.ajax({
      url: '/engine/include/MTA/pulse.txt',
      success: function(data) {
         $("#test").html(data.substr(data.length - 3)); 
      }
});
}, 300);

</script>