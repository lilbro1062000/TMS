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
	if($_GET['msg'] == 4)
	{
		$message = "Are you sure you want to logout?";
	}

}
include_once ("includes/head.php");
include_once ("includes/categories.php");
require_once ("includes/FB.php");
?>
<?php
  if($_GET['msg'] !=4)
	{redirectIfloggedIN();}
  else{
  	if(!isFBLoggedin())
	{
		redirect_to("index.php");
	}
  }

?>
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
        
        FB.Event.subscribe('auth.login', function(response) {
    window.location.reload();
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
	<?php 
	
	if (isset($_GET['msg']))
	{
		if($_GET['msg'] == 4)
		{
		echo "Yes i am sure i want to <a href=".GetFBlogoutURL()."> logout </a>";
		}
	} 
	else
		{
			echo "<div class=\"fb-login-button\" onlogin=\"after_login_button()\" scope=\"email,user_checkins\" data-redirect-uri=\"index.php\">Login with Facebook</div>";
		} 
	?>
      
</form>

<?php

include_once ("includes/foot.php");
?>