<?php
session_start();
include "../include_all.php";
// $mysql = mysql::get_instance();
$sql = 'update user_profile_style set description="'.$mysql->real_escape($_POST['text']).'" where user="'.user::$current->username.'"';
$mysql->query($sql);
?>
