<?php
// $mysql = new mysql();
$mysql = mysql::get_instance();
$categ = "";
$posts_per_page = 15;
$forum = new forum($posts_per_page);
if(isset($_GET['topic'])){
	// echo $_GET['categ'].' '.$_GET['topic'].'<br>';
	$forum->set_topic($_GET['categ'], $_GET['topic']);
	// print_r($forum);
	// $forum->topic = $_GET['topic'];
	$page = isset($_GET['npage']) ? $_GET['npage'] : 1;
	$page == 0 && exit(); //Secret topic, or not secret topic, that's the question.
	echo '<div id="topic_title_page"><a href="/forum/'.$_GET['categ'].'">'.ucfirst($_GET['categ']).'</a> &#8594; '.$forum->topic.'</div>';
	!isset($_GET['npage']) ? $start = 0 : $start = ($_GET['npage'] - 1)  * $posts_per_page;;
	// echo '<div style="color:red;">'.$start.'</div>';
	$sql = 'select * from forum_post where topic="'.$mysql->real_escape($forum->topic).'" and categ="'.$mysql->real_escape($_GET['categ']).'" order by id limit '.$posts_per_page.' offset '.$start;
		// limit 20';
		// echo $_GET['npage'];
	// }else{
	// 	$start = $_GET['npage'] * 20;
	// 	$sql = 'select * from forum_post where topic="'.$mysql->real_escape($forum->topic).'" and categ="'.$mysql->real_escape($_GET['categ']).'" order by id limit 20, '.$_GET['npage'];
	// }
	$mysql->query($sql);
	$posts = $mysql->fetch_array();
	$sql = 'select * from forum_post where topic="'.$mysql->real_escape($forum->topic).'" and categ="'.$mysql->real_escape($forum->categ).'"';
	$mysql->query($sql);
	$forum->num_pages = ceil($mysql->num_rows() / $posts_per_page);
	echo $forum->page_buttons(isset($_GET['npage']) ? $_GET['npage'] : 1).' <span class="go_to_page_pos" onclick="scrollDown();">▼</span>';
	foreach($posts as $post){
		// print_r($post);
		// could make pictures but... but... I'll think about it.
		$forum->draw_post($post);
		// echo 'asd';
	}
	echo $forum->page_buttons($page). '<span class="go_to_page_pos" onclick="scrollUp();">▲</span>';
	if(user::$logged_in){
		// echo '<div id="add_post_container"><textarea id="add_post" placeholder="Insert wonderful text here..."></textarea><button id="submit_post" onclick="submitPost(\'/forum/introductions/test1\');">Submit</button></div>';
		if($forum->num_pages == $page){
			// echo $num_pages.'.'.$page;
			echo '<div id="add_post_container"><textarea id="add_post" placeholder="Insert wonderful text here..."></textarea><button id="submit_post" onclick="submitPost();"v class="button gray_">Submit</button></div>';
		} else {
			// echo '<input type="text" name="text_area" style="width: 300px; height: 250px">';
			// echo '<div id="add_post_container"><a href="/forum/'.$forum->categ.'/'.$forum->topic.'/'.$forum->num_pages.'?#add_post"><textarea disabled id="add_post" placeholder="Click here to start posting..."></textarea></a></div>';
			echo '<div id="add_post_container"><a onclick="startPostingTextarea('.$forum->num_pages.');"><textarea disabled id="add_post" placeholder="Click here to start posting..." ></textarea></a></div>';
		}
	}
} elseif(isset($_GET['create']) && user::$logged_in){
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
			<td style="text-align: center;"><button id="create_topic_create" onclick="createTopic(\''.user::$current->username.'\', \''.$forum->last_page.'\');">Create Topic</button><button id="create_topic_cancel" onclick="cancelTopic();">Cancel</button></td>
			<td></td>
		</tr>
	<table></div>
	';
	// echo user::$logged_in;
} elseif(isset($_GET['categ'])){
	// $categ = $_GET['categ'];
	$forum->set_categ($_GET['categ']);
	if((isset($_GET['delete']) && user::$logged_in) && (user::$current->status == 'admin' || user::$current->status == 'moderator')){
		$forum->delete_topic($_GET['delete']);
	}
	// DO_STUFF();
	// echo '<div class="topic_title"><span>'.ucfirst($categ).'</span><a href="/include/async/create_topic.php"><span class="topic_create"> <span class="add">+</span> New topic</span></a></div>';
	echo '<div class="topic_title"><span class="forum_categ_title">'.ucfirst($forum->categ).'</span>';
	if(user::$logged_in){
		echo '<a href="/forum/'.$forum->categ.'/create_topic"><span class="topic_create"> <span class="add">+</span> New topic</span></a>';
	}
	echo '</div>';
	$sql = 'select * from forum_topic where categ="'.$mysql->real_escape($forum->categ).'" order by id desc';
	$mysql->query($sql);
	echo '<table class="forum_topics">';
	$topics = $mysql->fetch_array();
	foreach($topics as $topic){
		$forum->draw_topic($topic);
	}
	echo '</table>';
} else {
	echo $forum->categ;
	?>
	<table class="forum" align="center">
	<tr>
		<th>Forum</th>
		<th>Latest Topic</th>
		<th>Latest Post</th>
	</tr>
	<tr>
		<td id="forum_introductions"><a href="/forum/introductions">Introductions</a></td>
		<td>
			<?php
				// $mysql->query('select * from forum_topic where categ="introd" order by id desc limit 4');
				// $forum_topic = $mysql->fetch();
				echo $forum->last_forum_preview('topic', 'introductions');
			?>
		</td>
		<td>
			<?php
				echo $forum->last_forum_preview('post', 'introductions');
			?>
		</td>
	</tr>
	<tr>
		<td id="forum_discuss"><a href="/forum/discuss">Discussions</a></td>
		<td>
			<?php
				echo $forum->last_forum_preview('topic', 'discuss');
			?>
		</td>
		<td>
			<?php
				echo $forum->last_forum_preview('post', 'discuss');
			?>
		</td>
	</tr>
	<tr>
		<td id="forum_manga"><a href="/forum/manga">Manga</a></td>
		<td>
			<?php
				echo $forum->last_forum_preview('topic', 'manga');
			?>
		</td>
		<td>
			<?php
				echo $forum->last_forum_preview('post', 'manga');
			?>
		</td>
	</tr>
	<tr>
		<th>Support</th>
		<th>Latest Topic</th>
		<th>Latest Post</th>
	</tr>
	<tr>
		<td id="forum_suggestions"><a href="/forum/suggestions">Suggestions</a></td>
		<td>
			<?php
				echo $forum->last_forum_preview('topic', 'suggestions');
			?>
		</td>
		<td>
			<?php
				echo $forum->last_forum_preview('post', 'suggestions');
			?>
		</td>
	</tr>
	<tr>
		<td id="forum_report"><a href="/forum/report">Report Bugs</a></td>
		<td>
			<?php
				echo $forum->last_forum_preview('topic', 'report');
			?>
		</td>
		<td>
			<?php
				echo $forum->last_forum_preview('post', 'report');
			?>
		</td>
	</tr>

	</table>
<?php } ?>
