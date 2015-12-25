<?php
session_start();
include '../include_all.php';
$sql = 'insert into tickets(user, title, body) values ("'.user::$current->username.'","'.$mysql->real_escape($_POST['ticket_title']).'","'.$mysql->real_escape($_POST['ticket_body']).'")';
$mysql->query($sql);
header('Location:/help?done='.$mysql->aff_rows());
?>
