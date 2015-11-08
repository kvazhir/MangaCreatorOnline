<?php
session_start();
include '/../include_all.php';
echo user::$logged_in;
// user::$current->upload_avatar($_FILES);
$sql = 'update users set avatar="/imagevault/uploaded/avatars/'.user::$current->upload_avatar($_FILES).'" where id="'.$_SESSION['id'].'"';
$mysql->query($sql);
header('Location:/profile');
?>
