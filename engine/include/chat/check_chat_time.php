<?php
	//date_default_timezone_set('Etc/GMT-7');
	session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	if (isset($_SESSION['username']))//Определение сессии. Есть ли ник
	{
		write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/last_visit.txt', date("Y-m-d H:i:s"));
		
		$file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_h.arr'));
		
		$file->m++;
		if($file->m >= 60)
		{
			$file->h++;
			$file->m = 0;
			write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_h.arr', json_encode($file));
		}
		else
		{
			write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat_h.arr', json_encode($file));
		}
	}
	session_write_close();
?>