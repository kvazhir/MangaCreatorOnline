<?php
session_start();
include "../include_all.php";
if(user::$logged_in){
	if(user::$current->status == 'admin' || user::$current->status == 'moderator'){
		$sql = 'delete from comments where id="'.$_POST['id'].'"';
		$mysql->query($sql);
	} else {
		$sql = 'delete from comments where id="'.$_POST['id'].'" and user="'.user::$current->username.'"';
		$mysql->query($sql);
	}
}
echo $mysql->aff_rows();
?>
