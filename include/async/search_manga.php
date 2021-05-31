<?php
session_start();
include '../include_all.php';
$str = '';
if($_POST['text'] != ''){
	// $sql = 'select * from mangas where user regexp "(?:\w(?!'.$_POST['text'].'))*'.$_POST['text'].'\w*"';
	// $sql = 'select * from mangas where (user regexp "\w*'.$_POST['text'].'\w*" or id="'.$_POST['text'].'") and data_url!="" order by last_edit desc';
	$sql = 'select * from mangas where (user regexp "\w*'.$_POST['text'].'\w*" or id regexp "\d*'.$_POST['text'].'\d*") and data_url!="" order by last_edit desc';
	// echo $sql;
	// $sql = 'select * from mangas where (user="'.$_POST['text'].'" or id="'.$_POST['text'].'") and data_url!="" order by last_edit desc';
} else {
	$sql = 'select * from mangas order by last_edit desc';
}
$mysql->query($sql);
$mangas = $mysql->fetch_array();
// print_r($mangas);
foreach($mangas as $obj){
	//
	if($_POST['in_what'] == 'collections'){
		$sql = 'select count(*) as num from collections where user="'.user::$current->username.'" and manga_id="'.$obj['id'].'"';
		$mysql->query($sql);
		$num = $mysql->fetch()['num'];
	} else {
		$num = 1;
	}
	//
	if($num != 0){
		$manga = new manga($obj);
		if($_POST['in_what'] == 'collections')
			$str .= $manga->draw(false, false);
		else
			$str .= $manga->draw();
	}
}
echo $str;
?>
