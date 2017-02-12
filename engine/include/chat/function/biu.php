<?
	header('Content-type: application/json');
	session_start();
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	if (isset($_SESSION['username']) || isset($_SESSION['guestname']))
	{
	
		if (isset($_SESSION['username']))
		{
			$usr_dir = $_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/biu.arr';
		}
		else if (isset($_SESSION['guestname']))
		{
			$usr_dir = $_SERVER['DOCUMENT_ROOT'].'/database/guest/'.$_SESSION['guestname'].'_biu.arr';
		}
		$file = json_decode(file_get_contents($usr_dir));
		if($_GET['biu'] == 'b')
		{
			if($file->b == '0')
			{
				$file->b = '1';
				write_wb($usr_dir, json_encode($file));
				$biu = 'b';
				$biu_val = '1';
			}
			else
			{
				$file->b = '0';
				write_wb($usr_dir, json_encode($file));
				$biu = 'b';
				$biu_val = '0';
			}
		}
		else if($_GET['biu'] == 'i')
		{
			if($file->i == '0')
			{
				$file->i = '1';
				write_wb($usr_dir, json_encode($file));
				$biu = 'i';
				$biu_val = '1';
			}
			else
			{
				$file->i = '0';
				write_wb($usr_dir, json_encode($file));
				$biu = 'i';
				$biu_val = '0';
			}
		}
		
		die(json_encode(
		  array(
			'biu'  => $biu,
			'biu_val' => $biu_val
		  )
		));
		
	}
	else exit('Ошибка!');
?>