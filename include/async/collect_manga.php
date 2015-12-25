<?php
session_start();
include '../include_all.php';
$sql = 'insert into collections(user, manga_id) values ("'.user::$current->username.'", "'.$_POST['id'].'")';
$query = $mysql->query($sql);
echo $mysql->aff_rows();
?>
