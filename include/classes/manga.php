<?php
class manga{
	public $id;
	public $user;
	public $type;
	public $vote_status;
	public $vote_num;
	public $collect_status;
	public $data;
	public $thumbnail;
	public $comments_per_page;
	public $comments_num_pages;
	public $comments_current_page;

	function __construct($obj, $comments_per_page = 15, $comments_num_pages = 1){
		$this->id = $obj['id'];
		$this->user = $obj['user'];
		$this->data = $obj['data_url'];
		$this->thumbnail = $obj['thumbnail'];
		if(user::$logged_in){
			$this->update_voted_status();
			$this->update_collect_status();
		}
		$this->comments_per_page = $comments_per_page;
		$this->comments_total_num = comment::count('manga', $this->id);
		$this->comments_num_pages = ceil($this->comments_total_num / $this->comments_per_page);
		if($this->comments_num_pages == 0){
			$this->comments_num_pages = 1;
		}
		if($comments_num_pages <= $this->comments_num_pages)
			$this->comments_current_page = $comments_num_pages;
		else
			$this->comments_current_page = $this->comments_num_pages;
	}

	private function update_voted_status(){
		$mysql = mysql::get_instance();
		$sql = 'select status from votes where to_id='.$this->id.' and user="'.user::$current->username.'"';
		$mysql->query($sql);
		$this->vote_status = $mysql->fetch()['status'];
	}

	public function draw($collect = true, $vote = true){
		$this->count_votes();
		$str = '';
		$str .= '
		<div class="manga_obj" id="manga_obj'.$this->id.'">';
			if($vote){
				$str .= '
				<span class="like_buttons" id="like_buttons'.$this->id.'">';
				if(!is_null($this->vote_status)){
					if($this->vote_status == 1){
						$str .= '
						<span class="like" id="like'.$this->id.'"><i class="fa fa-thumbs-up liked" onclick="voteStatus('.$this->id.',1);"></i></span>
						<span class="dislike" id="dislike'.$this->id.'"><i class="fa fa-thumbs-o-down" onclick="voteStatus('.$this->id.',-1);"></i></span>';
					} else {
						$str .= '
						<span class="like" id="like'.$this->id.'"><i class="fa fa-thumbs-o-up" onclick="voteStatus('.$this->id.',1);"></i></span>
						<span class="dislike" id="dislike'.$this->id.'"><i class="fa fa-thumbs-down disliked" onclick="voteStatus('.$this->id.',-1);"></i></span>';
					}
				} else {
					$str .= '
					<span class="like" id="like'.$this->id.'"><i class="fa fa-thumbs-o-up" onclick="voteStatus('.$this->id.',1);"></i></span>
					<span class="dislike" id="dislike'.$this->id.'"><i class="fa fa-thumbs-o-down" onclick="voteStatus('.$this->id.',-1);"></i></span>';
				}
			}
			if($this->thumbnail != '')
				$str .= '
				</span>
				<a href="/manga/view/'.$this->id.'" class="collecting">
					<div class="manga_view noselect" style="background: url('.$this->thumbnail.');">
						<div>'.$this->user.'</div>
						<div>'.$this->id.'</div>
					</div>
				</a>';
			else
				$str .= '
				</span>
				<a href="/manga/view/'.$this->id.'" class="collecting">
					<div class="manga_view noselect" style="background: url('.$this->data.');">
						<div>'.$this->user.'</div>
						<div>'.$this->id.'</div>
					</div>
				</a>';
			if($collect)
				$str .= '
				<span class="collect noselect" onclick="collectManga('.$this->id.');">+</span>';
			else
				$str .= '
				<span class="collect noselect" style="padding: 0px 1px;" onclick="uncollectManga('.$this->id.');">X</span>';
			$str .= '
			</div>';
		return $str;
	}

	public function draw_full(){
		$str = '
		<div style="text-align: center;">
			<img src="'.$this->data.'" style="border: 1px solid black; border-radius: 5px;">
		</div>';
		return $str;
	}

	public function draw_for_edit(){
		$str = '';
		$str .= '
		<div class="manga_obj spaced" id="manga_obj'.$this->id.'">
			<span style="position: relative; left: 20px;"><i class="fa fa-trash-o" onclick="deleteManga('.$this->id.',\''.$this->user.'\');"></i></span>
			<a href="/manga/draw/'.$this->id.'">
				<div style="background: url('.$this->thumbnail.');" class="manga_preview">
					';
					// <div>'.$manga['user'].'</div>
					$str .= '
					<div>'.$this->id.'</div>
				</div>
			</a>
		</div>
		';
		return $str;
	}

	public function collect_button(){
		if(user::$logged_in){
			if($this->collect_status)
				$str = '
				<div id="remove_from_collection" class="add_remove_from_collection noselect" onclick="uncollectManga('.$this->id.',false); changeCollectButton(1,'.$this->id.');">
					<span><i class="fa fa-star"></i></span>
					<span>Remove...</span>
				</div>
				';
			else
				$str = '
				<div id="add_to_collection" class="add_remove_from_collection noselect" onclick="collectManga('.$this->id.',false); changeCollectButton(0,'.$this->id.');">
					<span><i class="fa fa-star-o"></i></span>
					<span>Add...</span>
				</div>
				';
		} else {
			$str = '
			<div class="add_remove_from_collection noselect disabled">
				<span><i class="fa fa-star-o"></i></span>
				<span>Add...</span>
			</div>
			';
		}
		return $str;
	}

	private function update_collect_status(){
		$mysql = mysql::get_instance();
		$sql = 'select count(*) as collected from collections where manga_id="'.$this->id.'" and user="'.user::$current->username.'"';
		$mysql->query($sql);
		$this->collect_status = $mysql->fetch()['collected'];
	}

	public function count_votes(){
		$mysql = mysql::get_instance();
		$sql = 'select sum(status) as votes from votes where to_id='.$this->id;
		$mysql->query($sql);
		$this->vote_num = $mysql->fetch()['votes'];
	}

	static function select_manga($id){
		$mysql = mysql::get_instance();
		$sql = 'select * from mangas where id="'.$id.'"';
		$mysql->query($sql);
		// $a = $mysql->fetch();
		// print_r($a);
		return $mysql->fetch();
	}

	static function show_hide_vote(){
		$str = '';
		$str .= '<div id="tools">
			<label class="hide_like"><input type="radio" name="tool" value="hide"checked><span></span></label>
			<label class="show_like"><input type="radio" name="tool" value="show"><span><i class="fa fa-thumbs-up"></i></span></label>
		</div>';
		return $str;
	}

	public function vote_buttons(){
		$str = '';
		$str .= '
		<div id="vote_buttons" style="display: inline-block; float: left;">';
		if(user::$logged_in){
			if(!is_null($this->vote_status)){
				if($this->vote_status == 1)
					$str .= '
					<span name="vote" id="like'.$this->id.'" onclick="voteStatus('.$this->id.',1,true);"><i class="fa fa-thumbs-up liked noselect"></i></span>
					<span id="vote_count">'.$this->vote_num.'</span>
					<span name="vote" id="dislike'.$this->id.'" onclick="voteStatus('.$this->id.',-1,true);"><i class="fa fa-thumbs-o-down noselect"></i></span>';
				else
					$str .= '
					<span name="vote" id="like'.$this->id.'" onclick="voteStatus('.$this->id.',1,true);"><i class="fa fa-thumbs-o-up noselect"></i></span>
					<span id="vote_count">'.$this->vote_num.'</span>
					<span name="vote" id="dislike'.$this->id.'" onclick="voteStatus('.$this->id.',-1,true);"><i class="fa fa-thumbs-down disliked noselect"></i></span>';
			} else {
				$str .= '
				<span name="vote" id="like'.$this->id.'" onclick="voteStatus('.$this->id.',1,true);"><i class="fa fa-thumbs-o-up noselect"></i></span>
				<span id="vote_count">'.$this->vote_num.'</span>
				<span name="vote" id="dislike'.$this->id.'" onclick="voteStatus('.$this->id.',-1,true);"><i class="fa fa-thumbs-o-down noselect"></i></span>';
			}
		} else {
			$str .= '
			<span name="vote" id="like'.$this->id.'" class="disabled"><i class="fa fa-thumbs-o-up noselect"></i></span>
			<span id="vote_count" class="disabled">'.$this->vote_num.'</span>
			<span name="vote" id="dislike'.$this->id.'" class="disabled"><i class="fa fa-thumbs-o-down noselect"></i></span>';
		}
		$str .= '
		</div>
		';
		return $str;
	}

	public function edit_button(){
		$str = '';
		if(user::$logged_in && $this->user == user::$current->username)
			$str = '<div class="edit_manga_button_container"><span class="button gray_" onclick="document.location.pathname = \'/manga/draw/'.$this->id.'\';">Edit <i class="fa fa-pencil-square-o"></i></span></div>';
		return $str;
	}

	public function delete_button(){
		$str = '';
		if(user::$logged_in && ($this->user == user::$current->username || user::$current->status == 'admin' || user::$current->status == 'moderator')){
			$str = '<div class="delete_manga_button_container"><span class="button red_" onclick="var ok = confirm(\'Are you sure? This cannot be undone! Σ(゜゜)\'); if(ok){ deleteManga('.$this->id.', \''.$this->user.'\'); document.location.pathname = \'/manga/view\';}">Delete <i class="fa fa-trash-o"></i></span></div>';
		}
		return $str;
	}

	public function draw_comment_section(){
		$mysql = mysql::get_instance();
		$str = '';
		$str .= comment::start_section();
		$str .= comment::draw_title();
		$select_comments = 'select * from comments where type="manga" and to_id="'.$this->id.'" order by id limit '.$this->comments_per_page.' offset '.intval(($this->comments_current_page-1)*$this->comments_per_page);
		$mysql->query($select_comments);
		$comments = $mysql->fetch_array();
		foreach($comments as $obj){
			// print_r($obj);
			$comment = new comment($obj);
			$str.= $comment->draw();
		}
		$str .= comment::end_section();
		if(user::$logged_in){
			$str .= comment::draw_textarea('manga', $this->id);
		}
		return $str;
	}

	public function draw_buttons(){
		$str = '';
		$str .= '<div class="first_line_manga_buttons">';
		$str .= $this->vote_buttons();
		$str .= $this->collect_button();
		$str .= '</div>';
		$str .= '<div class="second_line_manga_buttons">';
		$str .= $this->edit_button();
		$str .= $this->delete_button();
		$str .= '</div>';
		return $str;
	}

	public function draw_comments_page_buttons(){
		// echo $this->id.' '. $this->comments_per_page.' '. $this->comments_num_pages.' '. $this->comments_current_page;
		return comment::draw_page_buttons($this->id, $this->comments_per_page, $this->comments_num_pages, $this->comments_current_page);
	}

	static function draw_search_bar($in_what = 'all'){
		return '<div style="text-align: center; margin-bottom: 20px; margin-top: -20px;">
			<input type="text" style="height: 25px; padding-left: 10px;" id="search_bar">
			<button class="button gray_" onclick="searchForManga(\''.$in_what.'\');">Search</button>
		</div>';
	}
}
?>
