<?php
session_start();
if (!isset($_SESSION['username']))exit();

	if(file_exists('on/'.$_SESSION['username'].'.txt') == true)
	{
		$old = file_get_contents('on/'.$_SESSION['username'].'.txt');
		$now = $_SERVER['REQUEST_TIME'];
		$str = $now - $old;
		$dead = 6480 - $str;
		for($min = 0; $dead >= 60; $dead-=60)
		{
			$min++;
		}
		
		
		if(strlen($min) == 3)
		{
			if(strlen($dead) == 2)
			{
				echo "<script>
				document.getElementById('term_head_str_1').innerHTML = '".mb_substr($min,0,1)."';
				document.getElementById('term_head_str_2').innerHTML = '".mb_substr($min,1,1)."';
				document.getElementById('term_head_str_3').innerHTML = '".mb_substr($min,2,1)."';
				document.getElementById('term_head_str_4').innerHTML = '".mb_substr($dead,0,1)."';
				document.getElementById('term_head_str_5').innerHTML = '".mb_substr($dead,1,1)."';
				</script>";
			}
			else
			{
				echo "<script>
				document.getElementById('term_head_str_1').innerHTML = '".mb_substr($min,0,1)."';
				document.getElementById('term_head_str_2').innerHTML = '".mb_substr($min,1,1)."';
				document.getElementById('term_head_str_3').innerHTML = '".mb_substr($min,2,1)."';
				document.getElementById('term_head_str_4').innerHTML = '0';
				document.getElementById('term_head_str_5').innerHTML = '".mb_substr($dead,0,1)."';
				</script>";
			}
		}
		else if(strlen($min) == 2)
		{
			if(strlen($dead) == 2)
			{
				echo "<script>
				document.getElementById('term_head_str_1').innerHTML = '0';
				document.getElementById('term_head_str_2').innerHTML = '".mb_substr($min,0,1)."';
				document.getElementById('term_head_str_3').innerHTML = '".mb_substr($min,1,1)."';
				document.getElementById('term_head_str_4').innerHTML = '".mb_substr($dead,0,1)."';
				document.getElementById('term_head_str_5').innerHTML = '".mb_substr($dead,1,1)."';
				</script>";
			}
			else
			{
				echo "<script>
				document.getElementById('term_head_str_1').innerHTML = '0';
				document.getElementById('term_head_str_2').innerHTML = '".mb_substr($min,0,1)."';
				document.getElementById('term_head_str_3').innerHTML = '".mb_substr($min,1,1)."';
				document.getElementById('term_head_str_4').innerHTML = '0';
				document.getElementById('term_head_str_5').innerHTML = '".mb_substr($dead,0,1)."';
				</script>";
			}
		}
		else if(strlen($min) == 1)
		{
			if($min <= 0 && $dead <= 0)
			{
				echo "<script>
				document.getElementById('term_head_str_1').innerHTML = 'e';
				document.getElementById('term_head_str_1').style = 'color:red;';
				document.getElementById('term_head_str_2').innerHTML = 'r';
				document.getElementById('term_head_str_2').style = 'color:red;';
				document.getElementById('term_head_str_3').innerHTML = 'r';
				document.getElementById('term_head_str_3').style = 'color:red;';
				document.getElementById('term_head_str_4').innerHTML = 'o';
				document.getElementById('term_head_str_4').style = 'color:black;background-color:red;';
				document.getElementById('term_head_str_5').innerHTML = 'r';
				document.getElementById('term_head_str_5').style = 'color:black;background-color:red;';
				document.getElementById('term_beep').play();
				</script>";
			}
			else
			{
				if(strlen($dead) == 2)
				{
					echo "<script>
					document.getElementById('term_head_str_1').innerHTML = '0';
					document.getElementById('term_head_str_2').innerHTML = '0';
					document.getElementById('term_head_str_3').innerHTML = '".mb_substr($min,0,1)."';
					document.getElementById('term_head_str_4').innerHTML = '".mb_substr($dead,0,1)."';
					document.getElementById('term_head_str_5').innerHTML = '".mb_substr($dead,1,1)."';
					document.getElementById('term_beep').play();
					</script>";
				}
				else
				{
					echo "<script>
					document.getElementById('term_head_str_1').innerHTML = '0';
					document.getElementById('term_head_str_2').innerHTML = '0';
					document.getElementById('term_head_str_3').innerHTML = '".mb_substr($min,0,1)."';
					document.getElementById('term_head_str_4').innerHTML = '0';
					document.getElementById('term_head_str_5').innerHTML = '".mb_substr($dead,0,1)."';
					document.getElementById('term_beep').play();
					</script>";
				}
			}
		}
	//	echo "<script>alert('".$min."min.sec:".$dead."');</script>";
	}
?>