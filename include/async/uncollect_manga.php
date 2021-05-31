<?php
session_start();
include "../include_all.php";
$sql = 'delete from collections where user="'.user::$current->username.'" and manga_id="'.$_POST['id'].'"';
$mysql->query($sql);
echo $mysql->aff_rows();
?>
