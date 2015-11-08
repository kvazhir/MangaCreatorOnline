<?php
// echo 'mommy';
session_start();
include '/../include_all.php';
// echo isset($_SESSION['username']);
$id = $_POST['id'];
$sql = 'select * from forum_post where id="'.$id.'"';
$mysql->query($sql);
$post = $mysql->fetch();
forum::draw_post($post);
?>
