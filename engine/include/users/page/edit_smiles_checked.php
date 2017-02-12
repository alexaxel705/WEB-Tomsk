<?php
session_start();
if (isset($_SESSION['username']))write_wb($_SERVER['DOCUMENT_ROOT'].'/database/users/'.$_SESSION['username'].'/chat/e_or_d_smiles.txt', $_POST['message']);
else exit('Ошибка.');
function write_wb($f, $c){$fw=fopen($f, 'wb');fwrite($fw, $c);fclose($fw);}
?>