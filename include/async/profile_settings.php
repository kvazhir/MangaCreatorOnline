<?php
session_start();
include "../include_all.php";
$sql = 'update user_profile_style set irrelevant="1"';
if($_POST['background'] != '')
	$sql .= ',background="'.$mysql->real_escape($_POST['background']).'"';
if($_POST['background_size'] != '')
	$sql .= ',background_size="'.$mysql->real_escape($_POST['background_size']).'"';
if($_POST['title_color'] != '')
	$sql .= ',title_color="'.$mysql->real_escape($_POST['title_color']).'"';
if($_POST['title_background'] != '')
	$sql .= ',title_background="'.$mysql->real_escape($_POST['title_background']).'"';
if($_POST['title_background_size'] != '')
	$sql .= ',title_background_size="'.$mysql->real_escape($_POST['title_background_size']).'"';
if($_POST['title_font'] != '')
	$sql .= ',title_font="'.$mysql->real_escape($_POST['title_font']).'"';
if($_POST['title_outline'] != '')
	$sql .= ',title_outline="'.$mysql->real_escape($_POST['title_outline']).'"';
if($_POST['description_color'] != '')
	$sql .= ',description_color="'.$mysql->real_escape($_POST['description_color']).'"';
if($_POST['description_background'] != '')
	$sql .= ',description_background="'.$mysql->real_escape($_POST['description_background']).'"';
if($_POST['description_background_size'] != '')
	$sql .= ',description_background_size="'.$mysql->real_escape($_POST['description_background_size']).'"';
if($_POST['description_font'] != '')
	$sql .= ',description_font="'.$mysql->real_escape($_POST['description_font']).'"';
if($_POST['description_outline'] != '')
	$sql .= ',description_outline="'.$mysql->real_escape($_POST['description_outline']).'"';
if($_POST['stats_color'] != '')
	$sql .= ',stats_color="'.$mysql->real_escape($_POST['stats_color']).'"';
if($_POST['stats_background'] != '')
	$sql .= ',stats_background="'.$mysql->real_escape($_POST['stats_background']).'"';
if($_POST['stats_background_size'] != '')
	$sql .= ',stats_background_size="'.$mysql->real_escape($_POST['stats_background_size']).'"';
if($_POST['stats_font'] != '')
	$sql .= ',stats_font="'.$mysql->real_escape($_POST['stats_font']).'"';
if($_POST['stats_outline'] != '')
	$sql .= ',stats_outline="'.$mysql->real_escape($_POST['stats_outline']).'"';
if($_POST['stats_border'] != '')
	$sql .= ',stats_border="'.$mysql->real_escape($_POST['stats_border']).'"';

$sql .= ' where user="'.user::$current->username.'"';
$mysql->query($sql);
?>
