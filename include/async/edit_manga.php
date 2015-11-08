<?php
session_start();
include '/../include_all.php';
// $mysql = mysql::get_instance();
$sql = 'select * from mangas where user="'.user::$current->username.'" order by id desc limit 1';
$mysql->query($sql);
$last = $mysql->fetch();
// print_r($last);
$sql = 'update mangas set last_edit="'.date('Y-m-d H:i:s').'", data_url="'.$_POST['data'].'" where id="'.$_POST['id'].'" and user="'.user::$current->username.'"';
// echo $mysql->get_last_id();
$mysql->query($sql);
echo $mysql->aff_rows();
?>
