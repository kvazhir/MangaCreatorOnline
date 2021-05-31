<?php
session_start();
include '../../include_all.php';
echo "<div id='response'></div>";

if(isset($_POST['email'])){
$user = $_POST['username'];
$pass = $_POST['password'];
$email = $_POST['email'];
$response = user::register($user, $pass, $email);
$response->display();
if ($response->issuccessful()) {
	?>
	<script>
	$("#register_form").fadeOut();
	</script>
	<?php
}
//}
//echo 'potato';
exit(0);
}

?>
<div id="register_form">
	<table>
		<tr>
			<td><input name="username" type="text" placeholder="Username (4-16 char)" autocomplete="off"/></td>
		</tr>
		<tr>
			<td><input name="password" type="password" placeholder="Password (8-64 char)" autocomplete="off"/></td>
		</tr>
		<tr>
			<td><input name="email" type="text" placeholder="Email" autocomplete="off"/></td>
		</tr>
		<tr>
			<td><button type="button" name="submit">Register</button></td>
		</tr>
    </table>
	<!-- <a id='login'>Log in</a> -->
</div>

<script type="text/javascript">
// $(document).ready(function(){
	$('#login').click(function(){
		$("#contain_login").show();
		$('#contain_login').html('<img src="/imagevault/loading.gif"/>');
		$('#contain_login').load('/include/pages/user/login_form.php');
		$("#contain_register").hide();
	});
	$("#contain_login #load_register").click(function(event){
		event.stopPropagation();
	});
	$(document).click(function(){
		$("#contain_login").hide();
	});

	$("[name=submit]").click(function(){
		var username = $('input[name=username]').val();
		var password = $('input[name=password]').val();
		var email = $('input[name=email]').val();
		//alert('asd');
		$.post('/include/pages/user/register_form.php', {username:username, password:password, email:email}, function(data){
			$(".me_growly").hide();
			$("#response").html(data);
		});
	});
// });
</script>
