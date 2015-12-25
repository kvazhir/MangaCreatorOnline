<?php
session_start();
include "../include_all.php";
$sql = 'delete from comments where type="manga" and to_id="'.$_POST['id'].'"';
$mysql->query($sql);
$sql = 'delete from votes where to_id="'.$_POST['id'].'"';
$mysql->query($sql);
$sql = 'delete from collections where manga_id="'.$_POST['id'].'"';
$mysql->query($sql);
$sql = 'delete from mangas where id="'.$_POST['id'].'"';
if(user::$logged_in){
	if(user::$current->username == $_POST['user'] || user::$current->status == 'admin' || user::$current->status == 'moderator'){
		$mysql->query($sql);
	}
}
echo $mysql->aff_rows();
?>
