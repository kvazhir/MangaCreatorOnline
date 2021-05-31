<?php
// $mysql = new mysql();
$mysql = mysql::get_instance();
$categ = "";
$posts_per_page = 15;
forum::$posts_per_page = $posts_per_page;
// if(isset($_POST['text'])){
// 	echo 'ASDASDADASDAD';
// 	// exit();
// }
// $submitPost = false;
// echo $_GET['npage'];
if(isset($_GET['topic'])){
	$page = isset($_GET['npage']) ? $_GET['npage'] : 1;
	$page == 0 && exit(); //Secret topic, or not secret topic, that's the question.
	$topic = $_GET['topic'];
	echo '<div id="topic_title_page"><a href="/forum/'.$_GET['categ'].'">'.ucfirst($_GET['categ']).'</a> &#8594; '.$topic.'</div>';
	!isset($_GET['npage']) ? $start = 0 : $start = ($_GET['npage'] - 1)  * $posts_per_page;;
	// echo '<div style="color:red;">'.$start.'</div>';
	$sql = 'select * from forum_post where topic="'.$mysql->real_escape($topic).'" and categ="'.$mysql->real_escape($_GET['categ']).'" order by id limit '.$posts_per_page.' offset '.$start;
		// limit 20';
		// echo $_GET['npage'];
	// }else{
	// 	$start = $_GET['npage'] * 20;
	// 	$sql = 'select * from forum_post where topic="'.$mysql->real_escape($topic).'" and categ="'.$mysql->real_escape($_GET['categ']).'" order by id limit 20, '.$_GET['npage'];
	// }
	$mysql->query($sql);
	$posts = $mysql->fetch_array();
	$sql = 'select * from forum_post where topic="'.$mysql->real_escape($topic).'" and categ="'.$mysql->real_escape($_GET['categ']).'"';
	$mysql->query($sql);
	$num_pages = ceil($mysql->num_rows() / $posts_per_page);
	echo forum::page_buttons($num_pages, $_GET['categ'], $topic, isset($_GET['npage']) ? $_GET['npage'] : 1);
	foreach($posts as $post){
		// print_r($post);
		// could make pictures but... but... I'll think about it.
		forum::draw_post($post);
		// echo 'asd';
	}
	echo forum::page_buttons($num_pages, $_GET['categ'], $topic, $page);
	if(user::$logged_in){
		// echo '<div id="add_post_container"><textarea id="add_post" placeholder="Insert wonderful text here..."></textarea><button id="submit_post" onclick="submitPost(\'/forum/introductions/test1\');">Submit</button></div>';
		if($num_pages == $page){
			// echo $num_pages.'.'.$page;
			echo '<div id="add_post_container"><textarea id="add_post" placeholder="Insert wonderful text here..."></textarea><button id="submit_post" onclick="submitPost();">Submit</button></div>';
		} else {
			echo '<div id="add_post_container"><a href="/forum/'.$_GET['categ'].'/'.$_GET['topic'].'/'.$num_pages.'#add_post"><textarea disabled id="add_post" placeholder="Click here to start posting..."></textarea></a></div>';
		}
	}
} elseif(isset($_GET['create']) && isset($_SESSION['id'])){
	echo '
	<div id="contain_create_topic"><table id="create_topic">
		<tr>
			<td colspan="3"><input type="text" placeholder="Title goes here... *(no-spaces)" id="create_topic_title"></td>
		</tr>
		<tr>
			<td colspan="3"><textarea placeholder="Text goes here..." id="create_topic_text"></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td style="text-align: center;"><button id="create_topic_create" onclick="createTopic(\''.$_SESSION['username'].'\');">Create Topic</button><button id="create_topic_cancel" onclick="cancelTopic();">Cancel</button></td>
			<td></td>
		</tr>
	<table></div>
	';
	// echo $_SESSION['id'];
} elseif(isset($_GET['categ'])){
	$categ = $_GET['categ'];
	if((isset($_GET['delete']) && isset($_SESSION['id'])) && ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'moderator')){
		forum::delete_topic($_GET['categ'], $_GET['delete']);
	}
	// DO_STUFF();
	// echo '<div class="topic_title"><span>'.ucfirst($categ).'</span><a href="/include/async/create_topic.php"><span class="topic_create"> <span class="add">+</span> New topic</span></a></div>';
	echo '<div class="topic_title"><span>'.ucfirst($categ).'</span>';
	if(isset($_SESSION['id'])){
		echo '<a href="/forum/'.$_GET['categ'].'/create_topic"><span class="topic_create"> <span class="add">+</span> New topic</span></a>';
	}
	echo '</div>';
	$sql = 'select * from forum_topic where categ="'.$mysql->real_escape($categ).'" order by id desc';
	$mysql->query($sql);
	echo '<table class="forum_topics">';
	$topics = $mysql->fetch_array();
	foreach($topics as $topic){
		// $post = forum::last_forum_preview('post', $topic['name']);
		// $topic_underscore = str_replace(' ','_',$topic['name']);
		// echo $post;
		// echo $topic['name'];
		// preg_match('/\s/',$topic['name']); Nah...
		// echo '<tr>
		// 	<td class="forum_topic">
		// 		<span class="forum_topic_name">
		// 			<a href="/forum/'.$_GET['categ'].'/'.$topic['name'].'">'.$topic['name'].' ('.forum::count_posts($_GET['categ'], $topic['name'], $posts_per_page).')</a>
		// 		</span>';
		// 		if(isset($_SESSION['id']) && ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'moderator'))
		// 			echo '
		// 		<span class="forum_topic_delete">
		// 			<a href="?delete='.$topic['id'].'">delete</a>
		// 		</span>';
		// 		echo '
		// 		<span class="last_post">
		// 			<a href="/forum/...">'.forum::last_forum_preview('post', $_GET['categ'], $topic['name'], $posts_per_page).'</a>
		// 		</span>
		// 	</td>
		// </tr>';
		forum::draw_topic($_GET['categ'], $topic);
	}
	echo '</table>';
} else {
	echo $categ;
	?>
	<table class="forum" align="center">
	<tr>
		<th>Forum</th>
		<th>Latest Topic</th>
		<th>Latest Post</th>
	</tr>
	<tr>
		<td><a href="/forum/introductions">Introductions</a></td>
		<td>
			<?php
				// $mysql->query('select * from forum_topic where categ="introd" order by id desc limit 4');
				// $forum_topic = $mysql->fetch();
				echo forum::last_forum_preview('topic', 'introductions');
			?>
		</td>
		<td>
			<?php
				echo forum::last_forum_preview('post', 'introductions');
			?>
		</td>
	</tr>
	<tr>
		<td><a href="/forum/discuss">Discussions</a></td>
		<td>
			<?php
				echo forum::last_forum_preview('topic', 'discuss');
			?>
		</td>
		<td>
			<?php
				echo forum::last_forum_preview('post', 'discuss');
			?>
		</td>
	</tr>
	<tr>
		<td><a href="/forum/manga">Manga</a></td>
		<td>
			<?php
				echo forum::last_forum_preview('topic', 'manga');
			?>
		</td>
		<td>
			<?php
				echo forum::last_forum_preview('post', 'manga');
			?>
		</td>
	</tr>
	<tr>
		<th>Support</th>
		<th>Latest Topic</th>
		<th>Latest Post</th>
	</tr>
	<tr>
		<td><a href="/forum/suggestions">Suggestions</a></td>
		<td>
			<?php
				echo forum::last_forum_preview('topic', 'suggestions');
			?>
		</td>
		<td>
			<?php
				echo forum::last_forum_preview('post', 'suggestions');
			?>
		</td>
	</tr>
	<tr>
		<td><a href="/forum/report">Report Bugs</a></td>
		<td>
			<?php
				echo forum::last_forum_preview('topic', 'report');
			?>
		</td>
		<td>
			<?php
				echo forum::last_forum_preview('post', 'report');
			?>
		</td>
	</tr>

	</table>
<?php } ?>
