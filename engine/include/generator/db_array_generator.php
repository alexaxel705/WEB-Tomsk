<?php
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/database/users/db_users.arr') == false)
	{
		$fp1=fopen($_SERVER['DOCUMENT_ROOT'].'/database/users/db_users.arr', 'wb');
		fwrite($fp1, "");
		fclose($fp1);
	}
	else
	{
	$users = array();
		
		$dir = "/var/www/database/users/"; 
		if(is_dir($dir)) 
		{
			$files = scandir($dir);  
			for($i=0; $i<sizeof($files); $i++)
			{
				if (strpos($files[$i], '.') !== false)//Если это не папка
				{

				} 
				else
				{
					$users[] = file_get_contents($dir.$files[$i].'/login_translit.txt');
				}
			}
		} 
		
		


		
		$fp2=fopen($_SERVER['DOCUMENT_ROOT'].'/database/users/db_users.arr', 'wb');
		fwrite($fp2, json_encode($users));//Сохраняем как текстовую строку
		fclose($fp2);
	}
?>