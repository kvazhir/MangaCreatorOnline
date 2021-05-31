<?php
session_start();
include '../include_all.php';
// $mysql = mysql::get_instance();
$sql = 'select * from collections where user="'.user::$current->username.'" and manga_id="'.$_POST['id'].'"';
$mysql->query($sql);
if($mysql->num_rows() == 0){
	echo false;
} else {
	echo true;
}
?>
