<?
file_put_contents('engine\include\chat\lgchat86123.txt', '');
?>

<?php  
// ��� �������� URL, � �������� ������ ����������  
$back = $_SERVER['HTTP_REFERER']; // ��� �������, �� ����������� ��������� ����������

// ������ ������� ��������, ������������
// � meta ���� �� ����������
echo "
<html>
  <head>
   <meta http-equiv='Refresh' content='0; URL=".$_SERVER['HTTP_REFERER']."'>
  </head>
</html>";
?>