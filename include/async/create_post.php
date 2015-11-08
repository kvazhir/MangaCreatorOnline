<?php
session_start();
include '/../include_all.php';
// $mysql = mysql::get_instance();
if(isset($_POST['text'])){
	// echo nl2br($_POST['text']);
	// echo $_POST['text'];
	// $string = trim(preg_replace('/\s\s+/', ' ', $_POST['text']));
	$sql = 'insert into forum_post(user,text,topic,categ) values("'.user::$current->username.'","'.$mysql->real_escape(str_replace("\n",'',nl2br($_POST['text']))).'","'.$_POST['topic'].'","'.$_POST['categ'].'")';
	// echo '<div style="position:absolute; top:50vh; left:50vw; z-index:13; background-color:blue;">'.$sql.'</div>';
	$mysql->query($sql);
	echo $mysql->get_last_id();
}
?>
