<?php
session_start();
include '../include_all.php';
$sql = 'select * from mangas where user="'.$_SESSION['username'].'" order by id desc limit 1';
$mysql->query($sql);
$last = $mysql->fetch();
print_r($last);
$sql = 'update mangas set thumbnail="'.$_POST['thumbnail'].'" where id="'.$_POST['id'].'" and user="'.user::$current->username.'"';
$mysql->query($sql);
echo $mysql->aff_rows();
// echo 'I"M HERE';
?>
