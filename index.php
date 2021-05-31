<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/include_all.php';

$page = new page();
//echo $page->current;
if (user::$logged_in){
	// echo 'Welcome '.user::$current->username;
};

//var_dump($_POST);
if (isset($_POST['username'])){
	$logged = user::login($_POST['username'],$_POST['password']);
	$response = new response('login');
	if ($logged[0]){
		$response->add('success', 'Logged in');
	} else {
		// print_r($response[1]);
		$response->add('error', $logged[1][0]);
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Manga Creator Online</title>
<meta charset="UTF-8">
<script src="/include/js/jquery.js"></script>
<script src="/include/js/javascript.js"></script>
<script src="/include/js/jquery.growl.js"></script>
<script src="/include/js/jquery-ui.js"></script>
<script src="/include/js/canvas_draw.js"></script>
<link type="text/css" rel="stylesheet" href="/include/css/colorpicker.css" />
<link type="text/css" rel="stylesheet" href="/include/css/style.css" />
<link type="text/css" rel="stylesheet" href="/include/css/jquery.growl.css" />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="/include/css/jquery-ui.css" />
<!-- <link rel="shortcut icon" href="favicon.ico" /> -->
</head>
<body>
<div id="wrapper" class="noselect">
<div id="header" class="noselect">
	<div class="header3">
    	<div class="active"><a href='/home' class="noselect">Home</a></div>
        <div><a href='/help' class="noselect">Help</a></div>
        <div><a href='/forum' class="noselect">Forum</a></div>
    </div>

	<div class="header1"><span style="display:block;" class="noselect">Manga</span>
    	<div class="hidden" id="firstpartheader1"><a href='/manga' class="noselect">Create</a></div>
    	<div class="hidden" id="secondpartheader1"><a href='/manga/view' class="noselect">View</a></div>
    </div>
    <!-- LOGOUT change it... unset($_SESSION['something'])-->
    <?php
	if(isset($_POST['username'])){
		$response->display();
	}
    if(isset($_SESSION['id'])) {
    	echo '<div class="header3">
    		<div><a href="/profile/'.$_SESSION['username'].'" class="noselect" style="border-left: none;">Profile</a></div>
        	<div><a href="/collection" class="noselect">Favs</a></div>
        	<div><a href="?logout" class="noselect" id="logout">Logout</a></div>
    	</div>';
    } else {
    	echo '<div class="header2">
    		<div><a id="load_login" class="noselect">Login</a></div>
    		<div><a id="load_register" class="noselect">Register</a></div>
    	</div>';
    }
    ?>
</div>

<div id="contain_login"></div>
<div id="contain_register"></div>
</div>
<div id="content">
	<?php
		$page->display();
	?>
</div>
<!-- <script type="text/javascript">
$(document).ready(function(){
	$('#load_login').click(function(){
		$("#contain_login").show();
		$('#contain_login').html('<img src="/imagevault/loading.gif"/>');
		$('#contain_login').load('/include/pages/user/login_form.php');
		$('#contain_register').hide();
	});
	$("#contain_login, #load_login").click(function(event){
		event.stopPropagation();
	});
	$(document).click(function(){
		$("#contain_login").hide();
	});

	$('#load_register').click(function(){
		$("#contain_register").show();
		$('#contain_register').html('<img src="/imagevault/loading.gif"/>');
		$('#contain_register').load('/include/pages/user/register_form.php');
		$('#contain_login').hide();
	});
	$("#contain_register, #load_register").click(function(event){
		event.stopPropagation();
	});
	$(document).click(function(){
		$("#contain_register").hide();
		$('.error, .success').fadeOut('fast');
	});
});

</script> -->
</body>
</html>
