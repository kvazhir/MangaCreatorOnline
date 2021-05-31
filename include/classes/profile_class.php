<?php
class profile{
	public $user;
	public $description;
	public $title_background;
	public $title_background_size;
	public $title_color;
	public $title_font;
	public $title_outline;
	public $description_background;
	public $description_background_size;
	public $description_color;
	public $description_font;
	public $description_outline;
	public $stats_background;
	public $stats_background_size;
	public $stats_color;
	public $stats_font;
	public $stats_outline;
	public $stats_border;
	public $settings_color;
	public $comments_total_num;
	public $comments_per_page;
	public $comments_num_pages;
	public $comments_current_page;

	//lel \$this->(\w+) = (?:'#?[\w- ]*')?(?:\$\w+->\w+)?
	function __construct($username, $comments_per_page = 25, $comments_num_pages = 1){
		$mysql = mysql::get_instance();
		$sql = 'select * from user_profile_style where user="'.$username.'"';
		$mysql->query($sql);
		$profile = $mysql->fetch();
		$sql = 'select id from users where username="'.$profile['user'].'"';
		$mysql->query($sql);
		$user_id = $mysql->fetch()['id'];
		$this->user = new user($user_id);
		$this->description = $profile['description'];
		$this->title_background = $profile['title_background'];
		$this->title_background_size = $profile['title_background_size'];
		$this->title_color = $profile['title_color'];
		$this->title_font = $profile['title_font'];
		$this->title_outline = $profile['title_outline'];
		$this->description_background = $profile['description_background'];
		$this->description_background_size = $profile['description_background_size'];
		$this->description_color = $profile['description_color'];
		$this->description_font = $profile['description_font'];
		$this->description_outline = $profile['description_outline'];
		$this->stats_background = $profile['stats_background'];
		$this->stats_background_size = $profile['stats_background_size'];
		$this->stats_color = $profile['stats_color'];
		$this->stats_font = $profile['stats_font'];
		$this->stats_outline = $profile['stats_outline'];
		$this->stats_border = $profile['stats_border'];
		$this->background = $profile['background'];
		$this->background_size = $profile['background_size'];
		$this->comments_per_page = $comments_per_page;
		$this->comments_total_num = comment::count('user', $this->user->id);
		$this->comments_num_pages = ceil($this->comments_total_num / $this->comments_per_page);
		if($this->comments_num_pages == 0){
			$this->comments_num_pages = 1;
		}
		if($comments_num_pages <= $this->comments_num_pages)
			$this->comments_current_page = $comments_num_pages;
		else
			$this->comments_current_page = $this->comments_num_pages;
		$this->settings_color = $this->determine_settings_color();
		// echo $this->comments_current_page.' '.$this->comments_num_pages;
	}

	public function determine_settings_color(){
		$color = '';
		if($this->title_background[0] == '#'){
			$color = '#';
			for($i=1; $i<strlen($this->title_background); $i++){
				$color .= dechex(15 - hexdec($this->title_background[$i]));
			}
			return $color;
		} else {
			return $this->title_color;
			// return '#ffffff';
		}
	}

	static function draw_settings($avatar){
		$str = '';
		$str .= '
		<div class="preview"></div>
		<div class="colorpicker" style="display:none; z-index: 9999;">
			<canvas id="picker" var="3" width="299" height="300"></canvas>
			<div class="controls">
				<div><label>R</label> <input type="text" id="rVal" /></div>
				<div><label>G</label> <input type="text" id="gVal" /></div>
				<div><label>B</label> <input type="text" id="bVal" /></div>
				<div><label>RGB</label> <input type="text" id="rgbVal" /></div>
				<div><label>HEX</label> <input type="text" id="hexVal" /></div>
			</div>
		</div>
		<table id="settings_title">
			<tr>
				<td>
					<input type="text" placeholder="Top part background" id="top_part_background">
				</td>
				<td>
					<input type="radio" name="top_part_background_type" value="color" checked>color; <input type="radio" name="top_part_background_type" value="url">url
				</td>
				<td>
					<input type="radio" name="top_part_background_size" value="auto" checked>auto; <input type="radio" name="top_part_background_size" value="cover">cover; <input type="radio" name="top_part_background_size" value="contain">contain; <input type="radio" name="top_part_background_size" value="custom">custom <input type="text" id="top_part_background_size" placeholder="Custom size" title="example: 50px 50px or 75% 75%">
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" placeholder="Title color" id="title_color">
				</td>
				<td>
					<input type="text" placeholder="Title font-family" id="title_font-family">
				</td>
				<td>
					Text stroke: Y<input type="checkbox" value="on" name="title_outline_check" class="title_outline_check"> N<input type="checkbox" value="off" name="title_outline_check" class="title_outline_check"><input type="text" id="title_outline" placeholder="Stroke color">
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" placeholder="Title background" id="title_background">
				</td>
				<td>
					<input type="radio" name="title_background_type" value="color" checked>color; <input type="radio" name="title_background_type" value="url">url
				</td>
				<td>
					<input type="radio" name="title_background_size" value="auto" checked>auto; <input type="radio" name="title_background_size" value="cover">cover; <input type="radio" name="title_background_size" value="contain">contain; <input type="radio" name="title_background_size" value="custom">custom <input type="text" id="title_background_size" placeholder="Custom size" title="example: 50px 50px or 75% 75%">
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" placeholder="Description font color" id="description_color">
				</td>
				<td>
					<input type="text" placeholder="Description font-family" id="description_font-family">
				</td>
				<td>
					Text stroke: Y<input type="checkbox" value="on" name="description_outline_check" class="description_outline_check"> N<input type="checkbox" value="off" name="description_outline_check" class="description_outline_check"><input type="text" id="description_outline" placeholder="Stroke color">
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" placeholder="Description background" id="description_background">
				</td>
				<td>
					<input type="radio" name="description_background_type" value="color" checked>color; <input type="radio" name="description_background_type" value="url">url
				</td>
				<td>
					<input type="radio" name="description_background_size" value="auto" checked>auto; <input type="radio" name="description_background_size" value="cover">cover; <input type="radio" name="description_background_size" value="contain">contain; <input type="radio" name="description_background_size" value="custom">custom <input type="text" id="description_background_size" placeholder="Custom size" title="example: 50px 50px or 75% 75%">
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" placeholder="Stats font color" id="stats_color">
				</td>
				<td>
					<input type="text" placeholder="Stats font-family" id="stats_font-family">
				</td>
				<td>
					Text stroke: Y<input type="checkbox" value="on" name="stats_outline_check" class="stats_outline_check"> N<input type="checkbox" value="off" name="stats_outline_check" class="stats_outline_check"><input type="text" id="stats_outline" placeholder="Stroke color">
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" placeholder="Stats background" id="stats_background">
				</td>
				<td>
					<input type="radio" name="stats_background_type" value="color" checked>color; <input type="radio" name="stats_background_type" value="url">url
				</td>
				<td>
					<input type="radio" name="stats_background_size" value="auto" checked>auto; <input type="radio" name="stats_background_size" value="cover">cover; <input type="radio" name="stats_background_size" value="contain">contain; <input type="radio" name="stats_background_size" value="custom">custom <input type="text" id="stats_background_size" placeholder="Custom size" title="example: 50px 50px or 75% 75%">
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" placeholder="Stats border *(only px)" id="stats_border" title="Pattern: Xpx style color, example: 5px outset green (shorthand property)">
				</td>
				<td>
					Documentation: <a href="http://www.w3schools.com/css/css_border.asp" style="text-decoration: underline;" title="W3Schools (shorthand property)">->٩(^ᴗ^)۶</a>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<button onclick="changeSettings();" class="button gray_">Update</button>
				</td>
			</tr>
		</table>';
		$str .= '
		<div id="settings_profile_picture">
			<img src="'.$avatar.'" class="noselect" id="profile_image">
			<form action="/include/sync/change_avatar.php" method="post" enctype="multipart/form-data">
				<input type="file" name="fileToUpload"><br />
				<input type="submit" value="Change">
			</form>
		</div>
		';
		return $str;
	}

	public function draw_title(){
		$str = '';
		$str .= '
		<div id="profile_title" style="background:'.$this->title_background.'; background-size:'.$this->title_background_size.'; color:'.$this->title_color.'; font-family:'.$this->title_font.'; text-shadow:'.$this->title_outline.';">'.
			$this->user->username;
			if(user::$logged_in && user::$current->username == $this->user->username)
				$str .= '
					<a href="/settings" style="color:'.$this->settings_color.'; text-shadow:none; font-family:monospace;">
						<span class="noselect settings_button"><i class="fa fa-cogs"></i></span>
					</a>';
		$str .= '
		</div>';
		return $str;
	}

	public function draw_description(){
		$str = '';
		$str .= '
		<div id="profile_description_container">
			<div id="profile_image_container" class="noselect">
				<img src="'.$this->user->avatar.'" id="profile_image" class="noselect" />
			</div>
			<div id="profile_description" class="wrapword" style="font-family: '.$this->description_font.'; color: '.$this->description_color.'; background: '.$this->description_background.'; background-size: '.$this->description_background_size.'; text-shadow:'.$this->description_outline.';">
				<span id="profile_description_text">'.$this->description.'</span>';
				if(user::$logged_in && user::$current->username == $this->user->username)
					if(preg_match("/'/i", $this->description_font))
						$str .= '<span id="edit_profile_description" onclick="editDescription('.$this->description_font.');" class="noselect" title="edit">✎</span>';
					else
						$str .= '<span id="edit_profile_description" onclick="editDescription(\''.$this->description_font.'\');" class="noselect" title="edit">✎</span>';
			$str .= '
			</div>
		</div>
		';
		return $str;
	}

	// public function draw_comment_section(){
	// 	$mysql = mysql::get_instance();
	// 	$str = '';
	// 	$select_comments = 'select * from comments where type="user" and to_id="'.$this->user->id.'" order by id';
	// 	$mysql->query($select_comments);
	// 	$comments = $mysql->fetch_array();
	// 	$str .= comment::start_comment_section();
	// 	$str .= comment::draw_title();
	// 	foreach($comments as $obj){
	// 		$comment = new comment($obj);
	// 		$str.= $comment->draw();
	// 	}
	// 	$str .= comment::end_comment_section();
	// 	if(user::$logged_in){
	// 		$str .= comment::draw_textarea('user', $this->user->id);
	// 	}
	// 	return $str;
	// }


	public function draw_comments_page_buttons(){
		return comment::draw_page_buttons($this->user->id, $this->comments_per_page, $this->comments_num_pages, $this->comments_current_page);
	}

	public function draw_comment_section(){
		$mysql = mysql::get_instance();
		$offset = intval(($this->comments_current_page-1)*$this->comments_per_page) < 0 ? 1 : intval(($this->comments_current_page-1)*$this->comments_per_page);
		$str = '';
		//
		$select_comments = 'select * from comments where type="user" and to_id="'.$this->user->id.'" order by id limit '.$this->comments_per_page.' offset '.$offset;
		// echo $select_comments;
		$mysql->query($select_comments);
		$comments = $mysql->fetch_array();
		$str .= comment::start_section();
		$str .= comment::draw_title();
		foreach($comments as $obj){
			$comment = new comment($obj);
			$str.= $comment->draw();
		}
		$str .= comment::end_section();
		if(user::$logged_in){
			$str .= comment::draw_textarea('user', $this->user->id);
		}
		return $str;
	}

	public function draw_stats(){
		$mysql = mysql::get_instance();
		$str = '';
		$str .= '
		<table id="profile_stats" style="background: '.$this->stats_background.'; background-size: '.$this->stats_background_size.';color: '.$this->stats_color.'; font-family: '.$this->stats_font.'; border: '.$this->stats_border.'; text-shadow:'.$this->stats_outline.';">
			<tr>
				<th colspan="2">Stats</th>
			</tr>
			<tr>
				<td>
					Date registered
				</td>
				<td>';
					$date = date_create($this->user->register_date);
					$str .= date_format($date, 'F d, Y');
				$str .= '
				</td>
			</tr>
			<tr>
				<td>
					Forum topics
				</td>
				<td>';
					$sql = 'select count(*) as topics from forum_topic where user="'.$this->user->username.'"';
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
					$sql = 'select count(*) as posts from forum_post where user="'.$this->user->username.'"';
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
					$sql = 'select count(*) as m_comments from comments where user="'.$this->user->username.'" and type="manga"';
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
					$sql = 'select count(*) as p_comments from comments where user="'.$this->user->username.'" and type="user"';
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
					$sql = 'select count(*) as mangas from mangas where user="'.$this->user->username.'"';
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
					$sql = 'select count(*) as collects from collections where user="'.$this->user->username.'"';
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
					$sql = 'select count(*) as votes from votes where user="'.$this->user->username.'"';
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
		return $str;
	}

	public function draw_top_part(){
		$str = '';
		$str .= '<div class="profile_top_part" style="background: '.$this->background.'; background-size: '.$this->background_size.';">';
		// $str .= '<div class="profile_top_part" style="background: '.$this->top_part_background.'; position: absolute; left: 0; top: 0; width: 100%; height: 100%; z-index: -1;">';
		$str .= $this->draw_title();
		$str .= $this->draw_description();
		$str .= $this->draw_stats();
		$str .= '</div>';
		return $str;
	}	
}
?>
