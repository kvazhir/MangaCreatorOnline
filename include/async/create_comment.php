<?php
session_start();
include '../include_all.php';
if(user::$logged_in){
	$sql = $_POST['type'] == 'manga' ? 'select id from '.$_POST['type'].'s where id="'.$_POST['to_id'].'" and data_url!=""' : 'select id from '.$_POST['type'].'s where id="'.$_POST['to_id'].'"';
	// $sql = 'select id from '.$_POST['type'].'s where id="'.$_POST['to_id'].'" and data_url!=""';
	$mysql->query($sql);
	if($mysql->num_rows() > 0){
		$sql = 'insert into comments (user,type,to_id,text) values ("'.user::$current->username.'","'.$_POST['type'].'","'.$_POST['to_id'].'","'.$mysql->real_escape($_POST['text']).'")';
		$mysql->query($sql);
		echo $mysql->get_last_id();
	}
}
?>
