<?php
class comment{
	public $user;
	public $type;
	public $to_id;
	public $text;
	public $avatar;

	function __construct($obj){
		$this->id = $obj['id'];
		$this->user = $obj['user'];
		$this->type = $obj['type'];
		$this->to_id = $obj['to_id'];
		$this->text = $obj['text'];
		$this->timestamp = $obj['timestamp'];
		$this->get_avatar();
	}

	public function draw(){
		if($this->id != ''){
			$str = '
			<tr class="comment_title" id="comment_title'.$this->id.'">
				<td>
					<a href="/profile/'.$this->user.'" style="font-family: monospace;">'.$this->user.'</a>
				</td>

				<td>';
					if(user::$logged_in){
						$str .= '<div class="comment_buttons">';
						if(user::$current->username == $this->user || user::$current->status == 'admin' || user::$current->status == 'moderator'){
							$str .= '
							<span>
								<i class="fa fa-times-circle-o red__" onclick="deleteComment('.$this->id.', '.$this->to_id.');"></i>
							</span>';
							$str .= '
							<span>
								<i class="fa fa-pencil gray__" onclick="editComment('.$this->id.');"></i>
							</span>';
						}
						$str .= '<i class="fa fa-quote-right black__" onclick="quoteComment('.$this->id.');"></i>';
						$str .= '</div>';
					}
					$str .= system::ago($this->timestamp);
			$str .= '
				</td>
			</tr>

			<tr class="comment_body" id="comment_body'.$this->id.'">
				<td>
					<img src="'.$this->avatar.'" class="comment_avatar">
				</td>
				<td>
					'.$this->text.'
				</td>
			</tr>
			';
			return $str;
		}
	}

	private function get_avatar(){
		$mysql = mysql::get_instance();
		$sql = 'select avatar from users where username="'.$this->user.'"';
		$mysql->query($sql);
		$this->avatar = $mysql->fetch()['avatar'];
	}

	static function count($type, $id){
		$mysql = mysql::get_instance();
		$sql = 'select count(*) as num_comments from comments where type="'.$type.'" and to_id="'.$id.'"';
		$mysql->query($sql);
		return $mysql->fetch()['num_comments'];
	}

	static function start_section(){
		return '<table class="comments">';
	}

	static function end_section(){
		return '</table>';
	}

	static function draw_title(){
		$str = '';
		$str .= '
			<tr>
				<td colspan="2">
					<div id="comments_header">
						<span class="go_to_page_pos" onclick="scrollDown();">▼</span>
						Comments
						<span class="go_to_page_pos" onclick="scrollDown();">▼</span>
					</div>
				</td>
			</tr>
			';
		return $str;
	}

	static function draw_textarea($to_type, $to_id){
		$str = '';
		$str .= '
		<div id="post_comment_container" class="wrapword">
			<img src='.user::$current->avatar.' class="comment_avatar">
			<textarea id="post_comment" placeholder="Comment..."></textarea>
			<button class="gray_ button" onclick="postComment(\''.$to_type.'\','.$to_id.');" id="post_comment_button">Post</button>
		</div>
		';
		return $str;
	}

	// static function draw_page_buttons($id, $comments_per_page, $comments_num_pages, $comment_current_page){
	// 	$str = '';
	// 	$comment_current_page = $comment_current_page == 0 ? 1 : $comment_current_page;
	// 	$str .= '
	// 	<div style="text-align: center; font-size: 28px;" class="noselect">
	// 	';
	// 	if($comment_current_page == 1){
	// 		if($comment_current_page == $comments_num_pages){
	// 			$str .= '
	// 			<i class="fa fa-arrow-left disabled_button" style="margin-right: 10px;" onclick="commentsPageBack('.$id.','.$comments_per_page.');"></i>
	// 			<span id="comments_page_container">
	// 				<span id="show_page_num" onclick="changeCommentPage('.$id.','.$comments_per_page.','.$comments_num_pages.');">'.$comment_current_page.'</span>
	// 			</span>
	// 			<i class="fa fa-arrow-right disabled_button" style="margin-left: 10px;" onclick="commentsPageForward('.$id.','.$comments_per_page.','.$comments_num_pages.');"></i>';
	// 		} else {
	// 			$str .= '
	// 			<i class="fa fa-arrow-left disabled_button" style="margin-right: 10px;" onclick="commentsPageBack('.$id.','.$comments_per_page.');"></i>
	// 			<span id="comments_page_container">
	// 				<span id="show_page_num" onclick="changeCommentPage('.$id.','.$comments_per_page.','.$comments_num_pages.');">'.$comment_current_page.'</span>
	// 			</span>
	// 			<i class="fa fa-arrow-right" style="margin-left: 10px;" onclick="commentsPageForward('.$id.','.$comments_per_page.','.$comments_num_pages.');"></i>';
	// 		}
	// 	} else if($comment_current_page == $comments_num_pages){
	// 		$str .= '
	// 		<i class="fa fa-arrow-left" style="margin-right: 10px;" onclick="commentsPageBack('.$id.','.$comments_per_page.');"></i>
	// 		<span id="comments_page_container">
	// 			<span id="show_page_num" onclick="changeCommentPage('.$id.','.$comments_per_page.','.$comments_num_pages.');">'.$comment_current_page.'</span>
	// 		</span>
	// 		<i class="fa fa-arrow-right disabled_button" style="margin-left: 10px;" onclick="commentsPageForward('.$id.','.$comments_per_page.','.$comments_num_pages.');"></i>';
	// 	} else {
	// 		$str .= '
	// 		<i class="fa fa-arrow-left" style="margin-right: 10px;" onclick="commentsPageBack('.$id.','.$comments_per_page.');"></i>
	// 		<span id="comments_page_container">
	// 			<span id="show_page_num" onclick="changeCommentPage('.$id.','.$comments_per_page.','.$comments_num_pages.');">'.$comment_current_page.'</span>
	// 		</span>
	// 		<i class="fa fa-arrow-right" style="margin-left: 10px;" onclick="commentsPageForward('.$id.','.$comments_per_page.','.$comments_num_pages.');"></i>';
	// 	}
	// 	$str .= '
	// 	</div>';
	// 	$str .= '<div style="float: right; font-size: 43px;" onclick="$(\'html, body\').animate({ scrollTop: $(\'#comments_header\').offset().top }, 500);"><i class="fa fa-arrow-circle-o-up"></i></div>';
	// 	return $str;
	// }

	static function draw_page_buttons($id, $comments_per_page, $comments_num_pages, $comment_current_page){
		$str = '';
		$comment_current_page = $comment_current_page == 0 ? 1 : $comment_current_page;
		$str .= '
		<div style="text-align: center; font-size: 28px;" class="noselect comment_page_buttons">
		';
		if($comment_current_page == 1){
			if($comment_current_page == $comments_num_pages){
				$str .= '
				<i class="fa fa-arrow-left disabled_button" style="margin-right: 10px;" onclick="commentsPageBack('.$id.');"></i>
				<span id="comments_page_container">
					<span id="show_page_num" onclick="changeCommentPage('.$id.');">'.$comment_current_page.'</span>
				</span>
				<i class="fa fa-arrow-right disabled_button" style="margin-left: 10px;" onclick="commentsPageForward('.$id.');"></i>';
			} else {
				$str .= '
				<i class="fa fa-arrow-left disabled_button" style="margin-right: 10px;" onclick="commentsPageBack('.$id.');"></i>
				<span id="comments_page_container">
					<span id="show_page_num" onclick="changeCommentPage('.$id.');">'.$comment_current_page.'</span>
				</span>
				<i class="fa fa-arrow-right" style="margin-left: 10px;" onclick="commentsPageForward('.$id.');"></i>';
			}
		} else if($comment_current_page == $comments_num_pages){
			$str .= '
			<i class="fa fa-arrow-left" style="margin-right: 10px;" onclick="commentsPageBack('.$id.');"></i>
			<span id="comments_page_container">
				<span id="show_page_num" onclick="changeCommentPage('.$id.');">'.$comment_current_page.'</span>
			</span>
			<i class="fa fa-arrow-right disabled_button" style="margin-left: 10px;" onclick="commentsPageForward('.$id.');"></i>';
		} else {
			$str .= '
			<i class="fa fa-arrow-left" style="margin-right: 10px;" onclick="commentsPageBack('.$id.');"></i>
			<span id="comments_page_container">
				<span id="show_page_num" onclick="changeCommentPage('.$id.');">'.$comment_current_page.'</span>
			</span>
			<i class="fa fa-arrow-right" style="margin-left: 10px;" onclick="commentsPageForward('.$id.');"></i>';
		}
		$str .= '
		</div>';
		// $str .= '<div style="float: right; font-size: 43px;" onclick="$(\'html, body\').animate({ scrollTop: $(\'#comments_header\').offset().top }, 500);"><i class="fa fa-arrow-circle-o-up"></i></div>';
		$str .= '<div style="float: right; font-size: 43px; cursor: default;" onclick="scrollUpFast();"><i class="fa fa-arrow-circle-o-up"></i></div>';
		return $str;
	}
	//delete from comments where type="user" and to_id=25
}
?>
