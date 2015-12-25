<?php
include "../include_all.php";
if(isset($_POST['text']) && isset($_POST['title'])){
	$sql = 'select count(*) as repetition from forum_topic where name="'.$mysql->real_escape($_POST['title']).'" and categ="'.$mysql->real_escape($_POST['categ']).'"';
	$repetition = $mysql->fetch($mysql->query($sql));
	if($repetition['repetition'] != 0){
		echo 'exists';
	}
}
?>
