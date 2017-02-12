<?
	include("mta_sdk.php");
	$input = mta::getInput();
	mta::doReturn($input[0]);
	
	
	$input[1] = preg_replace('/([^\s]{200})[^\s]+/', '$1...', $input[1]);
	$input[1] = str_replace('>','&gt;',$input[1]) ;
	$input[1] = str_replace('<','&lt;',$input[1]);
	$input[1] = str_replace("\r\n", '', $input[1]);
	$input[1] = str_replace("\n", '', $input[1]);
	$input[1] = str_replace('&lt;br&gt;', '', $input[1]);
	$burn_file = fopen($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/lgchat86123.txt', 'a+');
	

	fwrite($burn_file, "\n".'<!--<[name_'.$input[0].']>--><time <[time_v]>>['.date("H:i:s").']</time> [MTA] <b onclick="print_message(this); return false;" class="cursor_pointer bold" style="color:'.$input[2].';">'.$input[0].'</b>: <span class="chat_usr_message_text bold" style="color:#000000">'.$input[1].'</span>');//Записываем сообщение
	fclose($burn_file);
?>