<?php
if (isset($_GET['logout'])) {
	if ($_GET['logout'] == 1) {
		include_once ("includes/logout.php");
		loggout();
	} else if ($_GET['logout'] == 2) {
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
		$message = "Sign Up sucessfull Please enter your Credentials";
	}

}
include_once ("includes/head.php");
include_once ("includes/categories.php");
require_once ("includes/FB.php");
?>
<?php   redirectIfloggedIN();?>
 <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '<?php echo FB_APP_ID;?>',
            status     : true, 
            cookie     : true,
            xfbml      : true,
            oauth      : true,
          });
        };
        (function(d){
           var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           d.getElementsByTagName('head')[0].appendChild(js);
         }(document));
      </script>
<META HTTP-EQUIV="refresh" CONTENT="5;URL=login.php">
<form id="Login" class="grid_4">
	<table>
		<tr>
			<?php
			echo("<p>");
			if (isset($message)) {echo($message);
			}
			echo("</p>");
			?>
			<!-- <td>Username:</td> -->
			<td>
<!-- 			<input type="text" name="Username" /> -->
			</td>
		</tr>
		<tr>
		<!-- 	<td>Password:</td>
		 -->	<td>
			<!-- <input type="password" name="Password"/> -->
			</td>
		</tr>
		<tr>
			<td>
			<!-- <input type="submit" name="submit" value="Submit"/> -->
			</td>
		</tr>
		<tr>

		</tr>
	</table>
      <div class="fb-login-button" scope="email,user_checkins">Login with Facebook</div>
</form>

<?php

include_once ("includes/foot.php");
?>