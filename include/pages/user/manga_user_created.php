<?php
if(!user::$logged_in){
	die('Please log in...');
}
$mysql = mysql::get_instance();
$sql = 'select * from mangas where user="'.user::$current->username.'" and data_url!="" order by id desc';
$mysql->query($sql);
$mangas = $mysql->fetch_array();
$str = '';
$str .= '<div>';
foreach($mangas as $obj){
	$manga = new manga($obj);
	$str .= $manga->draw_for_edit();
}
$str .= '</div>';
echo $str;
?>
