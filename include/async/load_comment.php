<?php
session_start();
include '../include_all.php';
$sql = 'select * from comments where id="'.$_POST['id'].'"';
$mysql->query($sql);
$obj = $mysql->fetch();
$comment = new comment($obj);
echo $comment->draw();
?>
