
<?
	if($_SERVER['REMOTE_ADDR'] != "109.227.228.4")
	{
		return false;
	}
	include $_SERVER['DOCUMENT_ROOT'].'/engine/include/function.php';
	include($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/mta_sdk.php');
	$input = mta::getInput();
	
	$text = $input[1];
	$razdel = $input[2];
	
	
	if($input[3]) {
		$dat = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/stats/words.arr'), true);
		
		$text = $input[1];
		if(isset($dat[$text])) {
			$dat[$text] = $dat[$text]+1;
		} else {
			$dat[$text] = 1;
		}
		write_wb($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/stats/words.arr', json_encode($dat));
	}
	
	
	$md5 = md5($text);
	if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/'.$razdel.'/'.$md5.'.wav"')) {
		$text = GetInTranslit($text);
		
		$options = "";
		if($razdel == "dg") 
		{
			$options = "-Px30 -Sx20 -I";
		}
		uft8_exec($_SERVER['DOCUMENT_ROOT'].'\engine\include\MTA\Govorilka_cp.exe -E "Speech Cube Russian (Nicolai 16Khz)" '.$options.' "'.$text.'" -TO "'.$razdel.'\\'.$md5.'.wav"'); 
	
		mta::doReturn($input[0], $input[1], $input[2]);
	}
	

	mta::doReturn(false);
		
	function uft8_exec($cmd,&$output=null,&$return=null)
	{
		$cd = getcwd();
		$cmd = "@echo off
		@chcp 65001 > nul
		@cd \"$cd\"
		".$cmd;
		$tempfile = 'php_exec.bat';
		file_put_contents($tempfile,$cmd);
		exec("start /b ".$tempfile,$output,$return);
		array_pop($output);
		array_pop($output);
		
		if(count($output) == 1)
		{
			$output = $output[0];
		}
		unlink($tempfile);
		return $output;
	}
?>
