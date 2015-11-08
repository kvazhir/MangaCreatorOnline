<?php
class forum{
	// public $last_page;
	static $last_page;
	static $posts_per_page;
	static $just_one_done;
	static function last_forum_preview($type, $categ, $topic = '', $num = 3){
		$mysql = mysql::get_instance();
		$type == 'post' && $num = 2;
		$str = "";
		$topic == '' ? $mysql->query('select * from forum_'.$mysql->real_escape($type).' where categ="'.$mysql->real_escape($categ).'" order by id desc limit '.$mysql->real_escape($num)) : $mysql->query('select * from forum_'.$mysql->real_escape($type).' where categ="'.$mysql->real_escape($categ).'" and topic="'.$topic.'" order by id desc limit '.$mysql->real_escape($num));
		if($type == 'topic'){
			$str .= '<table class="topic_preview">';
			while($forum_topic = $mysql->fetch()){
				// strlen($forum_topic['name']) > 10 ? $title = substr($forum_topic['name'], 0, 10).'...' : $title = $forum_topic['name'];
				$title = $forum_topic['name'];
				$str .=
					'<tr>
						<td>
							<a href="/forum/'.$categ.'/'.$forum_topic['name'].'"><span style="float:left;" class="preview_topic">'.$title.'</span></a>
						</td>
						<td>
							<a href="/profile/'.$forum_topic['user'].'"><span style="float:right;" class="user">'.$forum_topic['user'].'</span></a>
						</td>
					</tr>';//.'</a>';
			}
			$str .= '</table>';
		} else {
			$forum_posts = $mysql->fetch_array();
			$just_one = false;
			foreach($forum_posts as $forum_post){
				// $just_one = false;
				forum::count_last_page($forum_post['topic'], $categ, self::$posts_per_page, $just_one);
				// $line = '';
				$str .= '
					<div class="post_preview wrapword">
						<a href="/profile/'.$forum_post['user'].'">
							<div class="post_preview_user">'.$forum_post['user'].'</div>
						</a>';
						/*$str = preg_replace_callback('/(<br\s*\/?>)/', function($match) {
						    return preg_replace('/second regex/', '###', $match[1]);
						}, $line);*/
						strlen($forum_post['text']) > 350 ? $text = substr(preg_replace('/<br\s*\/?>/', '', $forum_post['text']), 0, 345)." [...]" : $text = preg_replace('/<br\s*\/?>/', '',$forum_post['text']);
						$str .= '<a href="/forum/'.$categ.'/'.$forum_post['topic'].'/'.self::$last_page.'#add_post"><div class="post_preview_text">'.$text.'</div></a>';
					$str .= '</div>';
			}
			// $str .= '</tr>';
		}
		return $str;
	}

	static function draw_post($post){
		$mysql = mysql::get_instance();
		$sql = 'select * from users where username="'.$post['user'].'"';
		$query = $mysql->query($sql);
		$user = $mysql->fetch();
		echo '<div class="post" id="'.$post['id'].'">
					<div class="post_user">
						<a href="/profile/'.$post['user'].'"><div class="post_user_title">'.$post['user'].'</div></a>
						<img src="'.$user['avatar'].'" class="post_title_user_picture" />
					</div>
				<div class="post_title wrapword">'
				//<span class="post_title_user">'.$post['user'].'</span>
					.'<span class="post_title_time">'.$post['timestamp'].'</span>
				</div>
			<div class="post_title">';
		if(user::$logged_in){
			// $user->new user($_SESSION['username']);
			// echo $post['text'];
			echo '<div class="post_options" id="'.$post['id'].'"><span class="quote_post" onclick="window.quotePost(\''.$mysql->real_escape(htmlentities($post['text']), ENT_QUOTES).'\', \''.$post['user'].'\');">quote</span> ';
			//str_replace(array("\r","\n"),"<br />",
			if($_SESSION['username'] == $post['user'] || $_SESSION['status'] == 'admin' || $_SESSION['status'] == 'moderator')
				echo '<span class="edit_post" onclick="editPost(\''.$post['id'].'\');">edit</span> ';
			if($_SESSION['status'] == 'admin')
				echo '<span class="delete_post" onclick="deletePost(\''.$post['id'].'\');">delete</span>';
			echo '</div>';
		}
		echo '</div>
			<div class="post_text wrapword" id="post_text'.$post['id'].'">'.$post['text'].'</div>
		</div>';
	}

	static function draw_topic($categ, $topic){
		echo '<tr>
			<td class="forum_topic">
				<span class="forum_topic_name">
					<a href="/forum/'.$categ.'/'.$topic['name'].'">'.$topic['name'].' ('.self::count_posts($categ, $topic['name'], self::$posts_per_page).')</a>
				</span>';
				if(isset($_SESSION['id']) && ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'moderator'))
					echo '
				<span class="forum_topic_delete">
					<a href="?delete='.$topic['id'].'">delete</a>
				</span>';
				echo '
				<span class="last_post">
					<a href="/forum/...">'.self::last_forum_preview('post', $categ, $topic['name'], self::$posts_per_page).'</a>
				</span>
			</td>
		</tr>';
	}

	static function page_buttons($num_pages, $categ, $topic, $page){
		$str = '';
		$str .= '<div class="forum_page_buttons">';
		if($page - 7 <= 0){
			// $str .= '<a href="/forum/'.$categ.'/'.$topic.'/1"><span class="forum_page_button">1</span></a> ... ';
			if($num_pages <= 12) {
				for($i=1; $i<=$num_pages; $i++){
					$str .= '<a href="/forum/'.$categ.'/'.$topic.'/'.$i.'"><span class="forum_page_button';
					if($i == $page)
						$str .= ' active_button';
					$str .= '" id="page_button_'.$i.'">'.$i.'</span></a>';
				}
				// $str .= ' ... <a href="/forum/'.$categ.'/'.$topic.'/'.$num_pages.'"><span class="forum_page_button">'.$num_pages.'</span></a>';
			} else {
				for($i=1; $i<=11; $i++){
					$str .= '<a href="/forum/'.$categ.'/'.$topic.'/'.$i.'"><span class="forum_page_button';
					if($i == $page)
						$str .= ' active_button';
					$str .= '" id="page_button_'.$i.'">'.$i.'</span></a>';
				}
				$str .= ' ... <a href="/forum/'.$categ.'/'.$topic.'/'.$num_pages.'"><span class="forum_page_button" id="page_button_'.$num_pages.'">'.$num_pages.'</span></a>';
			}
			// if($num_pages >= 5) {
			// 	$str .= ' ... <a href="/forum/'.$categ.'/'.$topic.'/'.$num_pages.'"><span class="forum_page_button">'.$num_pages.'</span></a>';
			// }
			// $str .= '<a href="/forum/'.$categ.'/'.$topic.'/'.$num_pages.'"><span class="forum_page_button">'.$num_pages.'</span></a>';
		} elseif($page + 6 >= $num_pages){
			$str .= '<a href="/forum/'.$categ.'/'.$topic.'/1"><span class="forum_page_button" id="page_button_1">1</span></a> ... ';
			for($i=$page-5; $i<=$num_pages; $i++){
				$str .= '<a href="/forum/'.$categ.'/'.$topic.'/'.$i.'"><span class="forum_page_button';
				if($i == $page)
					$str .= ' active_button';
				$str .= '" id="page_button_'.$i.'">'.$i.'</span></a>';
			}
		} else {
			$str .= '<a href="/forum/'.$categ.'/'.$topic.'/1"><span class="forum_page_button" id="page_button_1">1</span></a> ... ';
			for($i=$page-5; $i<=$page+5; $i++){
				$str .= '<a href="/forum/'.$categ.'/'.$topic.'/'.$i.'"><span class="forum_page_button';
				if($i == $page)
					$str .= ' active_button';
				$str .= '" id="page_button_'.$i.'">'.$i.'</span></a>';
			}
			$str .= ' ... <a href="/forum/'.$categ.'/'.$topic.'/'.$num_pages.'"><span class="forum_page_button" id="page_button_'.$num_pages.'">'.$num_pages.'</span></a>';
		}

		$str .= '</div>';
		return $str;
	}
	static function count_last_page($topic, $categ, $total = 15, &$just_one = false){
		$mysql = mysql::get_instance();
		$sql = 'select * from forum_post where topic="'.$mysql->real_escape($topic).'" and categ="'.$mysql->real_escape($categ).'"';
		$mysql->query($sql);
		// return ceil($mysql->num_rows() / $total);
		// echo $mysql->num_rows();
		if($mysql->num_rows() % $total == 1 && $mysql->num_rows() > 1){
			$just_one = true;
		}
		if($just_one == true){
			if(self::$just_one_done){
				self::$last_page = ceil($mysql->num_rows() / $total) - 1;
				self::$just_one_done = false;
			} else {
				self::$last_page = ceil($mysql->num_rows() / $total);
				self::$just_one_done = true;
			}
		} else {
			self::$last_page = ceil($mysql->num_rows() / $total);
		}
	}

	static function count_posts($categ, $topic){
		$mysql = mysql::get_instance();
		$sql = 'select count(*) as number from forum_post where topic="'.$mysql->real_escape($topic).'" and categ="'.$mysql->real_escape($categ).'"';
		$post = $mysql->fetch($mysql->query($sql));
		return $post['number'];
	}

	static function delete_topic($categ, $id){
		$mysql = mysql::get_instance();
		$delete_topic = $mysql->fetch($mysql->query('select * from forum_topic where id="'.$id.'"'))['name'];
		$sql = 'delete from forum_topic where id="'.$id.'"';
		$mysql->query($sql);
		// echo $delete_topic;
		$sql = 'delete from forum_post where topic="'.$delete_topic.'" and categ="'.$categ.'"';
		$mysql->query($sql);
	}
}
?>
