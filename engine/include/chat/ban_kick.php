<?php
	$ban_file = file_get_contents('users_banned.txt');
	$users_ip = getenv("REMOTE_ADDR");
	if (preg_match("/".$users_ip."/", $ban_file))
	{

	}
	else
	{
		echo "ban";
	}
?>

