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
	
	$mer = array_merge($arr, $dat);
	
	write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/stats/zones.arr', json_encode($mer, JSON_FORCE_OBJECT));
?>