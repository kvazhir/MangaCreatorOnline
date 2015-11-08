<?php
$mysql = mysql::get_instance();
$str = '';
if(isset($_GET['id'])){
	$sql = 'select * from mangas where id="'.$_GET['id'].'"';
	$mysql->query($sql);
	$manga = $mysql->fetch();
	$str .= '
	<div style="text-align: center;">
		<img src="'.$manga['data_url'].'" style="border: 1px solid black; border-radius: 5px;">
	</div>';
	$str .= '
	<table class="comments">';
	$str .= '
		<tr>
			<td colspan="2">
				<div style="text-align: center; font-size: 25px; background-color: black; color: white; font-weigth: bold; font-family: sketch_block; margin-top: 50px;">
					<span class="go_to_page_pos" onclick="scrollDown();">▼</span>
					Comments
					<span class="go_to_page_pos" onclick="scrollDown();">▼</span>
				</div>
			</td>
		</tr>
		';
	$sql = 'select * from comments where type="manga" and to_id="'.$manga['id'].'" order by id';
	$mysql->query($sql);
	$comments = $mysql->fetch_array();
	foreach($comments as $obj){
		$comment = new comment($obj);
		$str.= $comment->draw();
	}
	$str .= '</table>';
	if(user::$logged_in){
		$str .= '
		<div id="post_comment_container">
			<img src='.user::$current->avatar.' class="comment_avatar">
			<textarea id="post_comment" placeholder="Comment..."></textarea>
			<button class="gray_ button" onclick="postComment();">Post</button>
		</div>
		';
		// print_r(comment::count_comments('manga', $_GET['id']));
	}
} else {
	$sql = 'select * from mangas where data_url!="" order by last_edit desc';
	$mysql->query($sql);
	$mangas = $mysql->fetch_array();
	$str .= '<div id="manga_content">';
	foreach($mangas as $manga){
		$sql = 'select status from votes where to_id="'.$manga['id'].'" and user="'.user::$current->username.'"';
		$mysql->query($sql);
		$vote = $mysql->fetch()['status'];
		$str .= '
	<div class="manga_obj">
		<span class="like_buttons" id="like_buttons'.$manga['id'].'">';
		if(!is_null($vote)){
			if($vote){
				$str .= '<span class="like" id="like'.$manga['id'].'"><i class="fa fa-thumbs-up" onclick="voteStatus('.$manga['id'].',1);"></i></span>
				<span class="dislike" id="dislike'.$manga['id'].'"><i class="fa fa-thumbs-o-down" onclick="voteStatus('.$manga['id'].',0);"></i></span>';
			} else {
				$str .= '<span class="like" id="like'.$manga['id'].'"><i class="fa fa-thumbs-o-up" onclick="voteStatus('.$manga['id'].',1);"></i></span>
				<span class="dislike" id="dislike'.$manga['id'].'"><i class="fa fa-thumbs-down" onclick="voteStatus('.$manga['id'].',0);"></i></span>';
			}
		} else {
			$str .= '<span class="like" id="like'.$manga['id'].'"><i class="fa fa-thumbs-o-up" onclick="voteStatus('.$manga['id'].',1);"></i></span>
			<span class="dislike" id="dislike'.$manga['id'].'"><i class="fa fa-thumbs-o-down" onclick="voteStatus('.$manga['id'].',0);"></i></span>';
		}
		$str .= '
		</span>
		<a href="/manga/view/'.$manga['id'].'" class="collecting">
			<div class="manga_view noselect" style="background: url('.$manga['thumbnail'].');">
				<div>'.$manga['user'].'</div>
				<div>'.$manga['id'].'</div>
			</div>
		</a>
		<span class="collect noselect" onclick="collectManga('.$manga['id'].');">+</span>
	</div>
		';
	}
	$str .= '</div>';
}
echo $str;
?>
<script>
// document.getElementById('manga_content')
</script>
