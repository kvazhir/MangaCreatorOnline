<?php
session_start();
include '/../include_all.php';
$sql = 'select count(*) as nr from comments where type="'.$_POST['type'].'" and to_id="'.$_POST['id'].'"';
$mysql->query($sql);
// if($mysql->fetch()['nr'] % $_POST['comments_per_page'] == 0){
// 	echo 1;
// } else {
// 	echo 0;
// }
echo $mysql->fetch()['nr'] % $_POST['comments_per_page'];
?>
