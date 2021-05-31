<?php
session_start();
include '../include_all.php';
// echo isset($_POST['id']);
$id = $_POST['id'];
$sql = 'delete from forum_post where id="'.$id.'"';
if(user::$current->status == 'admin' || user::$current->status == 'moderator')
	$mysql->query($sql);
?>
