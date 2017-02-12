<?php
include $_SERVER['DOCUMENT_ROOT'].'/head_menu.php';
function page_title(){return "Список пользователей";}
?>


<div class="l_height_20px tx_align_center">
<div class="width_25pr left height_20px"><div class="border_r border_b">Имя</div></div>
<div class="width_25pr bg_c_F7F7F7 left height_20px border_b"><div class="border_r">Последний визит</div></div>
<div class="width_25pr left height_20px"><div class="border_r border_b">Имя</div></div>
<div class="width_25pr bg_c_F7F7F7 left height_20px border_b"><div class="border_r ">Последний визит</div></div>
<?php
	$users_file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/db_users.arr'));
	foreach($users_file as $users_file )
	{
		echo '<div class="users_list_users_content_empty height_20px  width_25pr left "><div class="border_b border_r"><a href="/database/profile.php?'.GetInTranslit($users_file).'">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.GetInTranslit($users_file).'/login_translit.txt').'</a></div></div><div class="bg_c_F7F7F7 users_list_users_content_empty height_20px width_25pr left border_b"><div class="border_r">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/database/users/'.GetInTranslit($users_file).'/last_visit.txt').'</div></div>';
	}
?>
</div>
<?php
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