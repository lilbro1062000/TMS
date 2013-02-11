<?php
if (isset($_GET['logout'])) {
	if ($_GET['logout'] == 2) {
		$message = ' You have been logged out!';
	}
}
if (isset($_GET['msg'])) {
	if ($_GET['msg'] == 1) {
		$message = "USERNAME or Password is Wrong.";
	}
	if ($_GET['msg'] == 2) {
		$message = "You Must be logged In";
	}
	if ($_GET['msg'] == 3) {
		$message = "Sign Up Through FaceBook";
	}
	if ($_GET['msg'] == 4) {
		$message = "Are you sure you want to logout?";
	}

}

if(isset($_POST['submit']))
{
	if (trim($_POST['id'] == '')) {
    die("ERROR: Please enter a valid OpenID.");    
  }
	
	require_once "includes/openid/Auth/OpenID/Consumer.php";
  	require_once "includes/openid/Auth/OpenID/FileStore.php";	
}
include_once ("includes/head.php"); 
include_once ("includes/categories.php");
require_once ("includes/FB.php");
?>
<?php
if ($_GET['msg'] != 4) {
	redirectIfloggedIN();
} else {
	if (!isFBLoggedin()) {
		redirect_to("index.php");
	}
}
?>

<script>
	window.fbAsyncInit = function() {
FB.init({
appId      : '<?php echo FB_APP_ID; ?>
	',
	status     : true,
	cookie     : true,
	xfbml      : true,
	oauth      : true,
	});
	};

	FB.Event.subscribe('auth.login', function(response) {
	window.location = "../index.php";
	});
	FB.Event.subscribe('auth.logout', function(response) {
	window.location.reload();
	});
	(function(d){
	var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	d.getElementsByTagName('head')[0].appendChild(js);
	}(document));
	function after_login_button(){
	FB.getLoginStatus(function(response) {
	if (response.status=="connected") {
	//User logged in! Do your code here
	window.location = "../index.php";
	}
	}, true);
	}
</script>
<form id="Login" class="grid_12">
	<table>
		<tr>
			<?php ?>
			<br />
			<br />
			<br />
			<?php
			if (isset($message)) {echo($message);
			}
			?>
			<!-- <td>Username:</td> -->
			<td><!-- 			<input type="text" name="Username" /> --></td>
		</tr>
		<tr>
			<!-- 	<td>Password:</td>
			-->
			<td><!-- <input type="password" name="Password"/> --></td>
		</tr>
		<tr>
			<td><!-- <input type="submit" name="submit" value="Submit"/> --></td>
		</tr>
		<tr>

		</tr>
	</table>

	<?php

	if (isset($_GET['msg']) && $_GET['msg'] == 4) {

		echo "Yes i am sure i want to <a href=" . GetFBlogoutURL() . "> logout </a>";

	} else {
		?>
		<table>
			<tr>
				<td >
					<form method="post" action="#">
      Sign in with your OpenID: <br/>
      <input type="text" name="id" size="30" />
      <br />
      <input type="submit" name="submit" value="Log In" /> 
</form>
				</td>
			</tr>
			<tr>
				<td>
					OR
				</td>
			</tr>
			<tr>
				<td>
		<?php
		echo "<div id=\"fbloginbox\" class=\"fb-login-button\"  scope=\"email,user_checkins\" data-redirect-uri=\"index.php\">Login with Facebook</div>\n <br/>";
		echo "Click <a href=\"index.php\"> Here</a> after login if you are not automatically logged in.";
		?>			
				</td>
			</tr>
		</table>
		<?php

	}
	?>
</form>

<?php

include_once ("includes/foot.php");
?>