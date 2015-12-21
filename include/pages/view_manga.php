<?php
$mysql = mysql::get_instance();
$str = '';
if(isset($_GET['id'])){
	$selected_manga = manga::select_manga($_GET['id']);
	is_null($selected_manga) && die('<div style="text-align: center;">Manga does not exist (´°̥̥̥̥̥̥̥̥ω°̥̥̥̥̥̥̥̥｀).</div>');
	if(isset($_GET['comment_page'])){
		$current_page = $_GET['comment_page'];
	} else {
		$current_page = 1;
	}
	// V Second param means comments per page.
	$manga = new manga($selected_manga, 3, $current_page);
	$manga->count_votes($_GET['id']);
	is_null($manga->vote_num) && $manga->vote_num = 0;
	$str .= $manga->draw_full();
	//buttons
	$str .= $manga->draw_buttons();
	$str .= $manga->draw_comment_section();
	$str .= $manga->draw_comments_page_buttons();
} else {
	if(isset($_GET['search'])){
		// $sql = 'select * from mangas where data_url!="" and (user="'.$_GET['search'].'" or id="'.$_GET['search'].'") order by last_edit desc';
		$sql = 'select * from mangas where (user regexp "\w*'.$_GET['search'].'\w*" or id="'.$_GET['search'].'") and data_url!="" order by last_edit desc';
	} else {
		$sql = 'select * from mangas where data_url!="" order by last_edit desc';
	}
	$str .= manga::show_hide_vote();
	$str .= manga::draw_search_bar();
	$mysql->query($sql);
	$mangas = $mysql->fetch_array();
	$str .= '<div id="manga_content">';
	foreach($mangas as $obj){
		$manga = new manga($obj);
		$str .= $manga->draw();
	}
	$str .= '</div>';
	// $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}
echo $str;
?>
<script>
// document.getElementById('manga_content')
if(typeof document.location.pathname.split('/')[3] === 'undefined'){
	for(var i=0; i<2; i++){
		document.getElementsByName('tool')[i].onclick = function(){
			if(this.value == 'hide'){
				window.hideButtons = true;
				$('.like_buttons').css('visibility', 'hidden');
			} else {
				window.hideButtons = false;
				$('.like_buttons').css('visibility', 'visible');
			}
		}
	}
	document.getElementById('search_bar').onkeydown = function(e){
		var code = (e.which ? e.which : e.keyCode);
		if(code == 13){
			searchForManga();
			// alert(1);
		}
	}

}

// V here enters though it should NOT! We'll see. The if works but the variables are not assigned to anything.

if(/\d/.test(document.location.pathname)){
	window.currentCommentPage = <?php if(isset($manga))
		echo $manga->comments_current_page == 0 ? 1 : $manga->comments_current_page;
	else
		echo '""';
	 ?>;
	window.commentsNumPages = <?php if(isset($manga))
		echo $manga->comments_num_pages == 0 ? 1 : $manga->comments_num_pages; 
	else
		echo '""';
	?>;
	window.commentsPerPage = <?php if(isset($manga)) 
		echo $manga->comments_per_page; 
	else
		echo '""';
	?>;
	window.commentsType = 'manga';
	console.log(window.currentCommentPage+' '+window.commentsNumPages+' '+window.commentsPerPage);
	// if (history.pushState) {
	// 	var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?comment_page=' + window.currentCommentPage;
	// 	window.history.pushState({path:newurl},'',newurl);
	// }

}
</script>
