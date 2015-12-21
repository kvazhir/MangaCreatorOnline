<?php
//Select profile's user
isset($_GET['user']) ? $user = $_GET['user'] : (user::$logged_in ? $user = user::$current->username : $user = '');
$mysql = mysql::get_instance();

$sql = 'select count(*) as num from users where username = "'.$mysql->real_escape($user).'"';
$mysql->query($sql);

if($user == '' || $mysql->fetch()['num'] == 0){
	echo '<div id="user_not_found">
			<div>User not found...</div>
		</div>';
	exit();
}

if(isset($_GET['comment_page']) && $_GET['comment_page'] > 0){
	$current_page = $_GET['comment_page'];
} else {
	$current_page = 1;
}

$profile = new profile($user, 3, $current_page);

// echo $profile->comments_num_pages;

$str = '';
$str .= $profile->draw_top_part();

$posts = comment::count('user', $profile->user->id);

$str .= $profile->draw_comment_section();
// echo $posts;
// echo $profile->comments_per_page;
// if(isset($_GET['comment_page'])){
$str .= $profile->draw_comments_page_buttons();
// } else {
// 	$str .= $profile->draw_comments_page_buttons();
// }
echo $str;
?>
<script>
// for(var i=0; i<document.getElementsByTagName('td').length; i++)
// 	document.getElementsByTagName('td')[i].style.border = document.getElementById('profile_stats').style.border;
var nodes = document.getElementById('profile_stats').children[0].children;
var border = document.getElementById('profile_stats').style.border;
for(var i=0; i<nodes.length; i++) {
	for(var j=0; j<2; j++){
		if(typeof document.getElementById('profile_stats').children[0].children[i].children[j] != 'undefined') {
			document.getElementById('profile_stats').children[0].children[i].children[j].style.border = border;
		}
	}
}
window.currentCommentPage = <?php echo $profile->comments_current_page == 0 ? 1 : $profile->comments_current_page; ?>;
// alert(window.currentCommentPage);
window.commentsNumPages = <?php echo $profile->comments_num_pages == 0 ? 1 : $profile->comments_num_pages; ?>;
window.commentsPerPage = <?php echo $profile->comments_per_page; ?>;
window.commentsType = 'user';
// console.log(typeof window.currentCommentPage, window.currentCommentPage);
// if (history.pushState) {
// 	var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?comment_page=' + window.currentCommentPage;
// 	window.history.pushState({path:newurl},'',newurl);
// }Skype?!Can't speak, but I can explain the way it wo

</script>
