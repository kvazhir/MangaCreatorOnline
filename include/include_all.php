<?php
error_reporting(-1);
include $_SERVER['DOCUMENT_ROOT'].'/globals.php';
include 'classes/mysql.php';
$mysql = new mysql();
//global $mysql;
include 'classes/page_viewer.php';
include 'classes/user.php';
include 'classes/response.php';
include 'classes/forum_class.php';
include 'classes/comment.php';
include 'classes/manga.php';
include 'classes/profile_class.php';
include 'classes/system.php';

if(isset($_GET['logout'])){
	unset($_SESSION['username']);
	unset($_SESSION['id']);
	// unset($_SESSION['status']);
	// unset($_GET['logout']);
} else {
	user::autologin();
	// echo 'logged in';
}
?>
