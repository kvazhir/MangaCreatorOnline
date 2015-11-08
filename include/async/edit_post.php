<?php
session_start();
include '/../include_all.php';
$sql = 'update forum_post set text="'.$mysql->real_escape(str_replace("\n",'',nl2br($_POST['text']))).'" where id="'.$_POST['id'].'"';
if(user::$current->id == $_POST['id'] || user::$current->status == 'admin' || user::$current->status == 'moderator')
	$mysql->query($sql);
// echo 'meowmeow';
?>
