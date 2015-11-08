<?php
session_start();
include '/../include_all.php';
// $mysql = mysql::get_instance();
$str = '';
$select_comments = 'select * from comments where type="'.$_POST['type'].'" and to_id="'.$_POST['id'].'" order by id limit '.$_POST['comments_per_page'].' offset '.intval(($_POST['page']-1)*$_POST['comments_per_page']);
$mysql->query($select_comments);
$comments = $mysql->fetch_array();
// $str .= comment::start_comment_section();
$str .= comment::draw_title();
foreach($comments as $obj){
	$comment = new comment($obj);
	$str.= $comment->draw();
}
// $str .= comment::end_comment_section();
echo $str;
?>
