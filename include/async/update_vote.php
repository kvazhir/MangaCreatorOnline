<?php
session_start();
include '../include_all.php';
$sql = 'select count(*) as exist from votes where to_id="'.$_POST['id'].'" and user="'.user::$current->username.'" and status="'.$_POST['status'].'" limit 1';
// $sql = 'select exists(select * from votes where to_id="'.$_POST['id'].'" and user="'.user::$current->username.'" and status="'.$_POST['status'].'") from votes';
/* for test
select count(*) as exist from votes where to_id=40 and user="Rexu" and status=1
select exists(select * from votes where to_id=40 and user="Rexu" and status=1) from votes
*/
$mysql->query($sql);
$exist = $mysql->fetch()['exist'];
echo $exist;
if($exist){
	$sql = 'delete from votes where to_id="'.$_POST['id'].'" and user="'.user::$current->username.'"';
	$mysql->query($sql);
} else {
	$sql = 'delete from votes where to_id="'.$_POST['id'].'" and user="'.user::$current->username.'"';
	$mysql->query($sql);
	$sql = 'insert into votes(to_id,user,status) values ("'.$_POST['id'].'","'.user::$current->username.'",'.$_POST['status'].')';
	$mysql->query($sql);
}
if($mysql->aff_rows()){
	echo 1;
} else {
	echo 0;
}
// $sql = 'insert into votes (to_id,user,status) values ("'.$_POST['id'].'","'.user::$current->username.'",'.$_POST['status'].') on duplicate key delete;';
?>
