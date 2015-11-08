<?php
class forum{
	public $posts_per_page;
	public $categ;
	public $topic;
	public $num_pages;
	public $last_page;
	private $total_posts;
	private $just_one_done;

	function __construct($posts_per_page){
		$this->posts_per_page = $posts_per_page;
		$this->mysql = mysql::get_instance();
	}

	public function set_topic($categ, $topic){
		$this->set_categ($categ);
		$this->topic = $topic;
		$this->count_posts();
		$this->num_pages = ceil($this->total_posts / $this->posts_per_page);
		// echo $this->total_posts;
		// echo $this->posts_per_page;
		// echo '<br>'.$this->num_pages.'asdadasd';
		// echo $this->total_posts;
		// echo '<br>'.$this->categ.' '.$this->topic.'<br>';
	}

	public function set_categ($categ){
		$this->categ = $categ;
	}

	function last_forum_preview($type, $categ, $topic = '', $num = 3){
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
			$this->just_one = false;
			foreach($forum_posts as $forum_post){
				// $just_one = false;
				$this->count_last_page($categ, $forum_post['topic']);
				// $line = '';
				// echo $forum_post['topic'];
				$str .= '
					<div class="post_preview wrapword">
						<a href="/profile/'.$forum_post['user'].'">
							<div class="post_preview_user">'.$forum_post['user'].'</div>
						</a>';
						/*$str = preg_replace_callback('/(<br\s*\/?>)/', function($match) {
						    return preg_replace('/second regex/', '###', $match[1]);
						}, $line);*/
						strlen($forum_post['text']) > 350 ? $text = substr(preg_replace('/<br\s*\/?>/', '', $forum_post['text']), 0, 345)." [...]" : $text = preg_replace('/<br\s*\/?>/', '',$forum_post['text']);
						$str .= '<a href="/forum/'.$categ.'/'.$forum_post['topic'].'/'.$this->last_page.'#add_post"><div class="post_preview_text">'.$text.'</div></a>';
					$str .= '</div>';
			}
			// $str .= '</tr>';
		}
		return $str;
	}

	public function draw_post($post){
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
					.'<span class="post_title_time">'.system::ago($post['timestamp']).'</span>
				</div>
			<div class="post_title">';
		if(user::$logged_in){
			// echo $this->total_posts;// % $this->posts_per_page;
			echo '<div class="post_options" id="options'.$post['id'].'"><span class="quote_post" onclick="window.quotePost(\''.$mysql->real_escape(htmlentities($post['text']), ENT_QUOTES).'\', \''.$post['user'].'\');">quote</span>';
			//str_replace(array("\r","\n"),"<br />",
			if(user::$current->username == $post['user'] || user::$current->status == 'admin' || user::$current->status == 'moderator')
				echo '<span class="edit_post" onclick="editPost(\''.$post['id'].'\');">edit</span>';
			if(user::$current->status == 'admin')
				echo '<span class="delete_post" onclick="deletePost(\''.$post['id'].'\');"><i class="fa fa-trash-o"></i></span>';
			echo '</div>';
		}
		echo '</div>
			<div class="post_text wrapword" id="post_text'.$post['id'].'">'.$post['text'].'</div>
		</div>';
	}

	function draw_topic($topic){
		$this->topic = $topic['name'];
		$this->count_posts();
		echo '<tr>
			<td class="forum_topic">
				<span class="forum_topic_name">
					<a href="/forum/'.$this->categ.'/'.$topic['name'].'">'.$topic['name'].' ('.$this->total_posts.')</a>
				</span>';
				if(user::$logged_in && (user::$current->status == 'admin' || user::$current->status == 'moderator'))
					echo '
				<span class="forum_topic_delete">
					<a href="?delete='.$topic['id'].'" class="delete_button_topic"><i class="fa fa-trash-o"></i></a>
				</span>';
				echo '
				<span class="last_post">
					<a href="/forum/...">'.$this->last_forum_preview('post', $this->categ, $topic['name'], $this->posts_per_page).'</a>
				</span>
			</td>
		</tr>';
	}

	function page_buttons($page){
		$str = '';
		$str .= '<div class="forum_page_buttons">';
		if($page - 7 <= 0){
			// $str .= '<a href="/forum/'.$categ.'/'.$topic.'/1"><span class="forum_page_button">1</span></a> ... ';
			if($this->num_pages <= 12) {
				for($i=1; $i<=$this->num_pages; $i++){
					$str .= '<a href="/forum/'.$this->categ.'/'.$this->topic.'/'.$i.'"><span class="forum_page_button';
					if($i == $page)
						$str .= ' active_button';
					$str .= '" id="page_button_'.$i.'">'.$i.'</span></a>';
				}
				// $str .= ' ... <a href="/forum/'.$this->categ.'/'.$this->topic.'/'.$this->num_pages.'"><span class="forum_page_button">'.$this->num_pages.'</span></a>';
			} else {
				for($i=1; $i<=11; $i++){
					$str .= '<a href="/forum/'.$this->categ.'/'.$this->topic.'/'.$i.'"><span class="forum_page_button';
					if($i == $page)
						$str .= ' active_button';
					$str .= '" id="page_button_'.$i.'">'.$i.'</span></a>';
				}
				$str .= ' ... <a href="/forum/'.$this->categ.'/'.$this->topic.'/'.$this->num_pages.'"><span class="forum_page_button" id="page_button_'.$this->num_pages.'">'.$this->num_pages.'</span></a>';
			}
			// if($this->num_pages >= 5) {
			// 	$str .= ' ... <a href="/forum/'.$this->categ.'/'.$this->topic.'/'.$this->num_pages.'"><span class="forum_page_button">'.$this->num_pages.'</span></a>';
			// }
			// $str .= '<a href="/forum/'.$this->categ.'/'.$this->topic.'/'.$this->num_pages.'"><span class="forum_page_button">'.$this->num_pages.'</span></a>';
		} elseif($page + 6 >= $this->num_pages){
			$str .= '<a href="/forum/'.$this->categ.'/'.$this->topic.'/1"><span class="forum_page_button" id="page_button_1">1</span></a> ... ';
			for($i=$page-5; $i<=$this->num_pages; $i++){
				$str .= '<a href="/forum/'.$this->categ.'/'.$this->topic.'/'.$i.'"><span class="forum_page_button';
				if($i == $page)
					$str .= ' active_button';
				$str .= '" id="page_button_'.$i.'">'.$i.'</span></a>';
			}
		} else {
			$str .= '<a href="/forum/'.$this->categ.'/'.$this->topic.'/1"><span class="forum_page_button" id="page_button_1">1</span></a> ... ';
			for($i=$page-5; $i<=$page+5; $i++){
				$str .= '<a href="/forum/'.$this->categ.'/'.$this->topic.'/'.$i.'"><span class="forum_page_button';
				if($i == $page)
					$str .= ' active_button';
				$str .= '" id="page_button_'.$i.'">'.$i.'</span></a>';
			}
			$str .= ' ... <a href="/forum/'.$this->categ.'/'.$this->topic.'/'.$this->num_pages.'"><span class="forum_page_button" id="page_button_'.$this->num_pages.'">'.$this->num_pages.'</span></a>';
		}

		$str .= '</div>';
		return $str;
	}

	function count_last_page($categ, $topic){
		$mysql = mysql::get_instance();
		$sql = 'select * from forum_post where topic="'.$mysql->real_escape($topic).'" and categ="'.$mysql->real_escape($categ).'"';
		$mysql->query($sql);
		// return ceil($mysql->num_rows() / $this->posts_per_page);
		// echo $mysql->num_rows();
		if($mysql->num_rows() % $this->posts_per_page == 1 && $mysql->num_rows() > 1){
			$this->just_one = true;
		}
		if($this->just_one == true){
			if($this->just_one_done){
				$this->last_page = ceil($mysql->num_rows() / $this->posts_per_page) - 1;
				$this->just_one_done = false;
			} else {
				$this->last_page = ceil($mysql->num_rows() / $this->posts_per_page);
				$this->just_one_done = true;
			}
		} else {
			$this->last_page = ceil($mysql->num_rows() / $this->posts_per_page);
		}
	}

	private function count_posts(){
		$mysql = mysql::get_instance();
		$sql = 'select count(*) as number from forum_post where topic="'.$this->topic.'" and categ="'.$this->categ.'"';
		$mysql->query($sql);
		$post = $mysql->fetch();
		$this->total_posts = $post['number'];
	}

	public function delete_topic($id){
		$mysql = mysql::get_instance();
		$delete_topic = $mysql->fetch($mysql->query('select * from forum_topic where id="'.$id.'"'))['name'];
		$sql = 'delete from forum_topic where id="'.$id.'"';
		$mysql->query($sql);
		// echo $delete_topic;
		$sql = 'delete from forum_post where topic="'.$delete_topic.'" and categ="'.$this->categ.'"';
		$mysql->query($sql);
	}
}
?>
