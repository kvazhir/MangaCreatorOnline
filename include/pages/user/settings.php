<?php
$mysql = mysql::get_instance();
if(!user::$logged_in){
	die('Please log in.');
}
$sql = 'select * from users where username="'.user::$current->username.'"';
$mysql->query($sql);
$user = $mysql->fetch();
echo profile::draw_settings($user['avatar']);
?>
<script>
settingsMenuBackground = function(background){
	var backgroundSizeDefault = 'auto';
	document.getElementsByName(background+'_type')[1].onclick = function(){
		document.getElementsByName(background+'_type')[1].parentNode.parentNode.children[2].style.left = '0px';
	}
	document.getElementsByName(background+'_type')[0].onclick = function(){
		document.getElementsByName(background+'_size')[0].checked = true;
		document.getElementsByName(background+'_type')[1].parentNode.parentNode.children[2].style.left = '-9999px';
	}

	document.getElementsByName(background+'_size')[document.getElementsByName(background+'_size').length-1].onclick = function(){
		document.getElementById(background+'_size').style.left = '0px';
	}
	for(var i=0; i<document.getElementsByName(background+'_size').length-1; i++){
		// console.log(document.getElementsByName(background+'_size')[i].value);
		document.getElementsByName(background+'_size')[i].onclick = function(){
			// console.log(this.value);
			document.getElementById(background+'_size').style.left = '-9999px';
			// backgroundSizeDefault = this.value;
			// console.log(backgroundSizeDefault);

		}
	}
}

textOutlineMenu = function(part){
	// $('#'+part+'_outline').addClass('hidden_rel');
	document.getElementsByName(part+'_outline_check')[0].onclick = function(){
		document.getElementById(part+'_outline').style.left = '0px';
		document.getElementsByName(part+'_outline_check')[1].checked = false;
		if(!document.getElementsByName(part+'_outline_check')[0].checked){
			document.getElementById(part+'_outline').style.left = '-9999px';

		}
	}
	document.getElementsByName(part+'_outline_check')[1].onclick = function(){
		document.getElementById(part+'_outline').style.left = '-9999px';
		document.getElementsByName(part+'_outline_check')[0].checked = false;
	}
}

// beforeChangeSettings = function(){
// 	for(var i=0; i<document.getElementsByName(background+'_size').length; i++){
// 		if(document.getElementsByName(background+'_size')[i].checked){
// 			backgroundSizeDefault = document.getElementsByName(background+'_size')[i].value;
// 			console.log(backgroundSizeDefault);
// 		}
// 	}
// 	// changeSettings();
// }
settingsMenuBackground('top_part_background');
settingsMenuBackground('title_background');
settingsMenuBackground('description_background');
settingsMenuBackground('stats_background');
textOutlineMenu('title');
textOutlineMenu('description');
textOutlineMenu('stats');
</script>
<script src="/include/js/colorpicker.js"></script>
