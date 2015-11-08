<?php
class page{
	public $current = 0;
	function __construct(){
		if (isset($_GET['page'])){
			$this->current = $_GET['page'];
			// echo $_GET['page']; //comment out later... Cuz it's nasty...
		}else{
			$this->current = DEFAULT_PAGE;
		}
	}
	function display(){
		//include '/include/pages/'.$this->current.'.php';

		// Could use regex... Hm...
		switch($this->current){
			case 'home':
				include '/include/pages/home.php';
				break;
			case 'help':
				include '/include/pages/help.php';
				break;
			case 'forum':
				include '/include/pages/forum.php';
				break;
			case 'settings':
				include '/include/pages/user/settings.php';
				break;
			case 'manga':
				include '/include/pages/create_manga_menu.php';
				break;
			case 'manga_create':
				include '/include/pages/create_manga.php';
				break;
			case 'manga_edit':
				include '/include/pages/manga_canvas.php';
				break;
			case 'manga_user_created':
				include '/include/pages/user/manga_user_created.php';
				break;
			case 'manga_view':
				include '/include/pages/view_manga.php';
				break;
			case 'profile':
				include '/include/pages/user/profile.php';
				break;
			case 'collection':
				include '/include/pages/user/collection.php';
				break;
		}
	}
}
?>
