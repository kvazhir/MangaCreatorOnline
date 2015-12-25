<?php
session_start();
include '../include_all.php';
// $mysql = mysql::get_instance();
$sql = 'insert into mangas(user, data_url) values ("'.user::$current->username.'", "'.$_POST['data'].'")';
$mysql->query($sql);
?>
