<?php
if(!user::$logged_in){
	die('<div style="color:red; text-align: center; width: 100%;">Must log in...</div>');
}
$mysql = mysql::get_instance();
$sql = 'select * from mangas where user="'.user::$current->username.'" and data_url=""';
$query = $mysql->query($sql);
if($mysql->num_rows() == 0){
	$sql = 'insert into mangas (user) values ("'.user::$current->username.'")';
	$mysql->query($sql);
	header("Location: /manga/draw/".$mysql->get_last_id());
} else {
	$manga = $mysql->fetch();
	// echo $manga['id'];
	header("Location: /manga/draw/".$manga['id']);
}
?>
