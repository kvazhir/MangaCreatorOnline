<?php
isset($_GET['user']) ? $user = $_GET['user'] : (user::$logged_in ? $user = user::$current->username : $user = '');
$mysql = mysql::get_instance();
// echo $user;
$sql = 'select * from users where username="'.$mysql->real_escape($user).'"';
$query = $mysql->query($sql);
if($mysql->num_rows() == 0){
	echo '<div id="user_not_found">
			<div>User not found...</div>
		</div>';
	exit();
}
// echo 'asd';
$mysql->query($sql);
// $user = new user($mysql->fetch());
$user = $mysql->fetch();
// print_r($user);
$str = '';
if($user['profile_title_background'][0] == '#'){
	$settings_color = '#';
	for($i=1; $i<strlen($user['profile_title_background']); $i++){
		$settings_color .= dechex(15 - hexdec($user['profile_title_background'][$i]));
	}
} else {
	$settings_color = '#ffffff';
}
// echo $settings_color;
$str .= '
<div id="profile_title" style="background:'.$user['profile_title_background'].'; background-size:'.$user['profile_title_background_size'].'; color:'.$user['profile_title_color'].'; font-family:'.$user['profile_title_font'].';">'.
	$user['username'];
	if(user::$logged_in && user::$current->username == $user['username'])
		$str .= '
			<a href="/settings" style="color:'.$settings_color.'">
				<span class="noselect settings_button">Settings</span>
			</a>';
$str .= '
</div>
<div id="profile_header">
	<div id="profile_image_container" class="noselect">
		<img src="'.$user['avatar'].'" id="profile_image" class="noselect" />
	</div>
	<div id="profile_description" class="wrapword" style="font-family: '.$user['profile_description_font'].'; color: '.$user['profile_description_color'].'; background: '.$user['profile_description_background'].'; background-size: '.$user['profile_description_background_size'].';">
		<span id="profile_description_text">'.$user['description'].'</span>';
		if(user::$logged_in && user::$current->username == $user['username'])
			if(preg_match("/'/i", $user['profile_description_font']))
				$str .= '<span id="edit_profile_description" onclick="editDescription('.$user['profile_description_font'].');" class="noselect" title="edit">✎</span>';
			else
				$str .= '<span id="edit_profile_description" onclick="editDescription(\''.$user['profile_description_font'].'\');" class="noselect" title="edit">✎</span>';
	$str .= '
	</div>
</div>
';
$str .= '
<table id="profile_stats" style="background: '.$user['profile_stats_background'].'; background-size: '.$user['profile_stats_background_size'].';color: '.$user['profile_stats_color'].'; font-family: '.$user['profile_stats_font'].'; border: '.$user['profile_stats_border'].';">
	<tr>
		<th colspan="2">Stats</th>
	</tr>
	<tr>
		<td>
			Date registered
		</td>
		<td>';
			$date = date_create($user['register']);
			$str .= date_format($date, 'F d, Y');
		$str .= '
		</td>
	</tr>
	<tr>
		<td>
			Forum topics
		</td>
		<td>';
			$sql = 'select count(*) as topics from forum_topic where user="'.$user['username'].'"';
			$mysql->query($sql);
			$num_topics = $mysql->fetch()['topics'];
			$str .= $num_topics;
		$str .= '
		</td>
	</tr>
	<tr>
		<td>
			Forum posts
		</td>
		<td>';
			$sql = 'select count(*) as posts from forum_post where user="'.$user['username'].'"';
			$mysql->query($sql);
			$num_posts = $mysql->fetch()['posts'];
			$str .= $num_posts;
		$str .= '
		</td>
	</tr>
	<tr>
		<td>
			Manga comments
		</td>
		<td>';
			$sql = 'select count(*) as m_comments from comments where user="'.$user['username'].'" and type="manga"';
			$mysql->query($sql);
			$num_manga_comments = $mysql->fetch()['m_comments'];
			$str .= $num_manga_comments;
		$str .= '
		</td>
	</tr>
	<tr>
		<td>
			User comments
		</td>
		<td>';
			$sql = 'select count(*) as p_comments from comments where user="'.$user['username'].'" and type="user"';
			$mysql->query($sql);
			$num_user_comments = $mysql->fetch()['p_comments'];
			$str .= $num_user_comments;
		$str .= '
		</td>
	</tr>
	<tr>
		<td>
			Manga created
		</td>
		<td>';
			$sql = 'select count(*) as mangas from mangas where user="'.$user['username'].'"';
			$mysql->query($sql);
			$num_mangas = $mysql->fetch()['mangas'];
			$str .= $num_mangas;
		$str .= '
		</td>
	</tr>
	<tr>
		<td>
			Manga colected
		</td>
		<td>';
			$sql = 'select count(*) as collects from collections where user="'.$user['username'].'"';
			$mysql->query($sql);
			$num_collects = $mysql->fetch()['collects'];
			$str .= $num_collects;
		$str .= '
		</td>
	</tr>
	<tr>
		<td>
			Manga votes
		</td>
		<td>';
			$sql = 'select count(*) as votes from votes where user="'.$user['username'].'"';
			$mysql->query($sql);
			$num_votes = $mysql->fetch()['votes'];
			$str .= $num_votes;
		$str .= '
		</td>
	</tr>
	<tr>
		<td>
			Points
		</td>
		<td>';
			$points = intval((5 * $num_topics + $num_posts + $num_manga_comments + $num_user_comments + 20 * $num_mangas) / 25);
			$str .= $points;
		$str .= '
		</td>
	</tr>
</table>';
// $str .= '<div style="float: left; width: 300px;"></div>';
$select_comments = 'select * from comments where type="user" and to_id="'.$user['id'].'" order by id';
$mysql->query($select_comments);
$comments = $mysql->fetch_array();
$str .= comment::start_comment_section();
$str .= comment::draw_title();
foreach($comments as $obj){
	$comment = new comment($obj);
	$str.= $comment->draw();
}
$str .= comment::end_comment_section();
if(user::$logged_in){
	$str .= comment::draw_textarea('user', $user['id']);
}
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
</script>
