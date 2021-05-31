<?php
session_start();
include '../include_all.php';
$sql = 'select * from comments where id > '.$_POST['id'].' and to_id = '.$_POST['to_id'].' limit 1';
$mysql->query($sql);
$comment = new comment($mysql->fetch());
echo $comment->draw();

?>
