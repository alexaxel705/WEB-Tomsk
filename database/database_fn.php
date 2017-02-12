<?
function get_time($data)
{
	$date_elems = explode(" ",$data);
	$date = explode("-", $date_elems[0]);
	$time = explode(":", $date_elems[1]); 
	$result =  mktime($time[0], $time[1],$time[2], $date[1],$date[2], $date[0]);

	$str_date_1 = date("Y-m-d H:i:s");
	$date_elems_1 = explode(" ",$str_date_1);
	$date_1 = explode("-", $date_elems_1[0]);
	$time_1 = explode(":", $date_elems_1[1]); 
	$result_1 =  mktime($time_1[0], $time_1[1],$time_1[2], $date_1[1],$date_1[2], $date_1[0]);

	$sec = $result_1-$result;
	if($sec < 180)
	{
		return 'онлайн';
	}
}

function gfc_old($obj)
{
	$dir = $_SERVER['DOCUMENT_ROOT'].'/database/users/'.$obj.'/friends/'; 
	$old_f=0;
	$files = scandir($dir);
	array_shift($files);
	array_shift($files);
	for($i=0; $i<sizeof($files); $i++)
	{
		if(file_get_contents($dir.$files[$i]) != '0')
		{
			$old_f++;
		}
	}
	if($old_f==0) return;
	else return '('.$old_f.')';
}

function gfc_new($obj)
{
	$dir = $_SERVER['DOCUMENT_ROOT'].'/database/users/'.$obj.'/friends/'; 
	$new_f=0;
	$files = scandir($dir);
	array_shift($files);
	array_shift($files);
	for($i=0; $i<sizeof($files); $i++)
	{
		if(file_get_contents($dir.$files[$i]) == '0')
		{
			$new_f++;
		}
	}
	if($new_f>0 && $obj == $_SESSION['username'])return '+'.$new_f;
	else return;
}
?>