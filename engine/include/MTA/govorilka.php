
<?
	if($_SERVER['REMOTE_ADDR'] != "109.227.228.4")
	{
		return false;
	}
	$text = "Я по делу";
	$razdel = "gg"; //gg dg
	
	//{"наркоман наверное", "вот я в твои годы", "куда катится мир", "какая молодежь пошла"}
	$md5 = md5($text);
	echo $md5;
	$text = GetInTranslit($text);
	
	$options = "";
	if($razdel == "dg") 
	{
		$options = "-Px30 -Sx20";
	}
	//uft8_exec('Z:\home\test1\www\engine\include\MTA\Govorilka_cp.exe -E "Speech Cube Russian (Nicolai 16Khz)" '.$options.' "'.$text.'" -TO "'.$razdel.'\\'.$md5.'.wav"'); 

	
	function uft8_exec($cmd,&$output=null,&$return=null)
	{
    //get current work directory
    $cd = getcwd();

    // on multilines commands the line should be ended with "\r\n"
    // otherwise if unicode text is there, parsing errors may occur
    $cmd = "@echo off
    @chcp 65001 > nul
    @cd \"$cd\"
    ".$cmd;


    //create a temporary cmd-batch-file
    //need to be extended with unique generic tempnames
    $tempfile = 'php_exec.bat';
    file_put_contents($tempfile,$cmd);

    //execute the batch
    exec("start /b ".$tempfile,$output,$return);

    // get rid of the last two lin of the output: an empty and a prompt
    array_pop($output);
    array_pop($output);

    //if only one line output, return only the extracted value
    if(count($output) == 1)
    {
        $output = $output[0];
    }

    //delete the batch-tempfile
    unlink($tempfile);

    return $output;

}

function GetInTranslit($string) {
    $replace = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => "'",  'ы' => 'y',   'ъ' => "'",
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
 
        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => "'",  'Ы' => 'Y',   'Ъ' => "'",
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya', ' ' => '_',
    );
	return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}


?>
