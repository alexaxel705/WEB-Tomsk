<?
	include($_SERVER['DOCUMENT_ROOT'].'/engine/include/MTA/mta_sdk.php');
	$input = mta::getInput();
	mta::doReturn($input[0]);
	
	
	$input[1] = preg_replace('/([^\s]{200})[^\s]+/', '$1...', $input[1]);
	$input[1] = str_replace('>','&gt;',$input[1]) ;
	$input[1] = str_replace('<','&lt;',$input[1]);
	$input[1] = str_replace("\r\n", '', $input[1]);
	$input[1] = str_replace("\n", '', $input[1]);
	$input[1] = str_replace('&lt;br&gt;', '', $input[1]);
	$burn_file = fopen($_SERVER['DOCUMENT_ROOT'].'/engine/include/chat/lgchat86123.txt', 'a+');
	

	fwrite($burn_file, "\n".'<!--<[name_'.$input[0].']>-->['.date("H:i:s").'] [MTA] <b onclick="print_message(this); return false;" class="cursor_pointer bold" style="color:'.$input[2].';">'.$input[0].'</b>: <span class="chat_usr_message_text" style="color:#000000">'.$input[1].'</span>');//Записываем сообщение
	fclose($burn_file);
	
	
	
		// Minecraft
	$url = 'http://minecraft.neeboo.ru/chat/send';
	$params = array(
		'name' => $input[0], 
		'message' => $input[1],
	);
	$result = file_get_contents($url, false, stream_context_create(array(
		'http' => array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => http_build_query($params)
		)
	)));
	//-------------
?>