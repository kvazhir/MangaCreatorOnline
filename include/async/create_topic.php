<?php
// echo 'asd';
include "/../include_all.php";
// echo $_SESSION['id'];
// if(!empty($_POST['text']) && !empty($_POST['title'])){
	$sql = 'insert into forum_post(user, text, topic, categ) values ("'.$mysql->real_escape($_POST['user']).'","'.$mysql->real_escape($_POST['text']).'","'.$mysql->real_escape($_POST['title']).'","'.$mysql->real_escape($_POST['categ']).'")';
	$mysql->query($sql);
	$sql = 'select count(*) as repetition from forum_topic where name="'.$mysql->real_escape($_POST['title']).'" and user="'.$mysql->real_escape($_POST['user']).'" and categ="'.$mysql->real_escape($_POST['categ']).'"';
	$repetition = $mysql->fetch($mysql->query($sql));
	if($repetition['repetition'] == 0){
		$sql = 'insert into forum_topic(name, user, categ) values ("'.$mysql->real_escape($_POST['title']).'","'.$mysql->real_escape($_POST['user']).'","'.$mysql->real_escape($_POST['categ']).'")';
		// $sql = 'insert into forum_topic(name, user, categ) values ("test","test","introductions")';
		$mysql->query($sql);
	}
	// if (!$asd)
 //    	trigger_error('Invalid query: ' . mysql_error());
?>
