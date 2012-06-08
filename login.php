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
?>
<form id="Login" method="post" class="grid_4" action="includes/login_code.php" >
	<table>
		<tr>
			<?php
			echo("<p>");
			if (isset($message)) {echo($message);
			}
			echo("</p>");
			?>
			<td>Username:</td>
			<td>
			<input type="text" name="Username" />
			</td>
		</tr>
		<tr>
			<td>Password:</td>
			<td>
			<input type="password" name="Password"/>
			</td>
		</tr>
		<tr>
			<td>
			<input type="submit" name="submit" value="Submit"/>
			</td>
		</tr>
		<tr>

		</tr>
	</table>
</form>

<?php

include_once ("includes/foot.php");
?>