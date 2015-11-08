<?php
session_start();
include '/../include_all.php';
// $mysql = mysql::get_instance();
$sql = 'select * from mangas where id="'.$_POST['id'].'" and user="'.user::$current->username.'"';
$mysql->query($sql);
$manga = $mysql->fetch();
echo $manga['data_url'];
?>
