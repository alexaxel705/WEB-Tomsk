<?
	if($_SERVER['REMOTE_ADDR'] != "109.227.228.4")
	{
		return false;
	}
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	include($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/mta_sdk.php');
	$input = mta::getInput();
	mta::doReturn($input[0]);
	
	
	$dat = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/stats/zones.arr'), true);

	$arr = json_decode($input[0]);
	
	while(list($key, $val) = each($arr)){
		while(list($x, $val2) = each($val)){
			while(list($y, $val3) = each($val2)){
				if(isset($dat[$x][$y])) {
					$dat[$x][$y] = $dat[$x][$y]+1;
				}
				else {
					$dat[$x][$y] = 1;
				}
			}
		}
	}
	
	write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/stats/zones.arr', json_encode($dat));
?>