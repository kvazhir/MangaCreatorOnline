<?php
include '../../include_all.php';
session_start();
?>
<div id="login_form">
	<form action="" method="post">
		<table>
			<tr>
				<td><input type="text" name="username" placeholder="Username"/></td>
			</tr>
			<tr>
				<td><input type="password" name="password" placeholder="Password" autocomplete="off"/></td>
			</tr>
			<tr>
				<td align="center"><input type="submit" name="submit" value="Log in" /></td>
			</tr>
		</table>
		<!-- <a href="forgot_password.php">Forgot Password</a>
		<a id="register">Register</a> -->
	</form>
</div>
<script type="text/javascript">
// $(document).ready(function(){
	$('#register').click(function(){
		$("#contain_login").show();
		$('#contain_login').html('<img src="/imagevault/loading.gif"/>');
		$('#contain_login').load('/include/pages/user/register_form.php');
	});
	$("#contain_register #load_register").click(function(event){
		event.stopPropagation();
	});
	$(document).click(function(){
		$("#contain_register").hide();
	});
	// alert('potao');
	$("input[name=submit]").click(function(){
		var username = $('input[name=username]').val();
		var password = $('input[name=password]').val();
		// alert('asd');
		$.post('/include/pages/user/login_form.php', {username:username, password:password}, function(data){
			// alert(data);

		});
	});
	// document.getElementsByName('submit')[0].onclick = function(){
	// 	document.reload();
	// }
	// alert('potao2');
// });
// alert('potato');
</script>
