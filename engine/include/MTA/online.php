<?
	include($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/mta_sdk.php');
	$input = mta::getInput();
	mta::doReturn($input[0]);
	
	$input[0] = str_replace(";", '', $input[0]);
	$burn_file = fopen($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/online.txt', 'w');
	fwrite($burn_file, $input[0]);//Записываем сообщение
	fclose($burn_file);
?>