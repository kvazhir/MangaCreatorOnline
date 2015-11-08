<?php
// include '/../../include_all.php';
$mysql = mysql::get_instance();
if(!user::$logged_in){
	die('Please log in...');
}
// echo user::$current->username;
$sql = 'select * from collections where user="'.user::$current->username.'" order by date_collected desc';
$str = '';
$mysql->query($sql);
$collects = $mysql->fetch_array();
$str .= manga::draw_search_bar('collections');
$str .= '<div id="manga_content">';
foreach($collects as $collect){
	// $sql = 'select * from mangas where id="'.$collect['manga_id'].'"';
	// $mysql->query($sql);
	$obj = manga::select_manga($collect['manga_id']);
	// $obj = $mysql->fetch();
	$manga = new manga($obj);
	$str .= $manga->draw(false, false);
}
$str .= '</div>';
echo $str;
?>
<script>
document.getElementById('search_bar').onkeydown = function(e){
	var code = (e.which ? e.which : e.keyCode);
	if(code == 13){
		searchForManga('collections');
		// alert(1);
	}
}
</script>