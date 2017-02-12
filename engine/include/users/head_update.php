<?
	session_start();
	if (isset($_SESSION['username']))
	{
		$news = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/board_news.txt');
		if($news > 0)
		{
			echo $news;
		}
		else
		{
			echo ' ';
		}
		session_write_close();
	}
?>