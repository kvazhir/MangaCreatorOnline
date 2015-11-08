<?php
session_start();
include "/../include_all.php";
if(user::$logged_in){
	if(user::$current->status == 'admin' || user::$current->status == 'moderator'){
		$sql = 'update comments set text="'.$mysql->real_escape($_POST['text']).'" where id="'.$_POST['id'].'"';
		$mysql->query($sql);
	} else {
		$sql = 'update comments set text="'.$mysql->real_escape($_POST['text']).'" where id="'.$_POST['id'].'" and user="'.user::$current->username.'"';
		$mysql->query($sql);
	}
}
echo $mysql->aff_rows();
?>
