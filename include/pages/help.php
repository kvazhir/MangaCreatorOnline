
<!-- <h1 class="title">HELP ∑(O_O；)</h1> -->
<ul id="help_menu" class="noselect">
	<li class="how_to">How To
    	<ul class="drop_how_to_menu">
        	<li id="how_to_create">How to create <span class="emoji">(oﾟ▽ﾟ)o</span></li>
            <li id="how_to_view">How to view <span class="emoji">°˖✧◝(⁰▿⁰)◜✧˖°</span></li>
			<li id="how_to_edit_profile">How to edit profile</li>
			<li id="how_to_find_user">How to watch other's profile</li>
			<li id="how_to_like">How to collect or like</li>
        </ul>
    </li>
    <li id="faq">FAQ</li>
    <li id="partners">Partners</li>
    <li id="about_me">About Me</li>
    <li class="support">Support
    	<ul class="drop_how_to_menu">
        	<li>Filling space ?(ﾉ)・´ω・(ヾ)</li>
            <li>(?・・)σ... Passing by...</li>
        	<li id="submit_ticket">Submit a ticket</li>
            <li id="terms_of_service">Terms of Service</li>
            <li id="privacy">Privacy Policy</li>
        </ul>
    </li>
</ul>
<div id="help_container">
<?php
if(isset($_GET['done'])){
    if($_GET['done'] == 1){
        echo '<span style="color: #6CC924>"Submit successful...</span>';
    } else {
        echo '<span style="color: red;">Submit failed, try again.</span>';
    }
}
?>
</div>
</div>

