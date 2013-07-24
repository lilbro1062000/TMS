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
        $message = "Sign Up through One of these Providers";
    }
    if ($_GET['msg'] == 4) {
        $message = "Are you sure you want to logout?";
    }

}

include_once ("includes/head.php");
include_once ("includes/categories.php");

?>
<?php
// registers a user if there is post data 
if(isset($_POST['email']))
{
    registerUser($_POST);  
    // i should check to make sure they didnt put anything malicious   
    // afterwards we should go to the profile page 
    login($_POST['ID']);
    redirect_to('profile.php');
} 
?>
<?php
if(isset($esc_identity))
{// after sucessfull login 
// show this instead of the open id if there is no user in the database 
// First Name
// Last Name
// Email


 if(Idntityfound($esc_identity))
 {
     // user exist now go to users page
     redirect_to('profile.php'); 
 }
 else {
    // user does not exist
    $newuser ="You are new to our site Please make sure the information is correct";
    
?>
<style type="text/css">

    .alert {
        border: 1px solid #e7dc2b;
        background: #fff888;
        padding: .5em;
    }
    .success {
        border: 1px solid #669966;
        background: #88ff88;
        padding: .5em;
    }
    .error {
        border: 1px solid #ff0000;
        background: #ffaaaa;
        padding: .5em;
    }
</style>

<div class="grid_12"></div>
<?php
    if (isset($msg)) { print "<div class=\"alert\">$msg</div>";
    }
?>
<?php
    if (isset($error)) { print "<div class=\"error\">$error</div>";
    }
?>
<?php
    if (isset($success)) { print "<div class=\"success\">$success</div>";
    }
?>
<?php
    if (isset($newuser)) { print "<div class=\"success\">$newuser</div>";
    }
?>

<form action="#" method="post" id="reg_form" class="grid_9">
    <input type="hidden" name="ID" value="<?php echo $esc_identity;?>"/>
    <table>
        <tr><td>Please Enter Email Address:</td>
        <td><input type="email" required="required" name="email" value="<?php echo $sreg['email']; echo $obj['http://axschema.org/contact/email'][0]; ?>"/></td>                
        </tr>
        <tr>
            <td>Please Enter First Name:</td>
            <td><input type="name" required="required" name="first_name" value="<?php echo $sreg['nickname']; echo $obj['http://axschema.org/namePerson/first'][0];?>"/></td></tr>
        <tr>
            <td>Please Enter Last Name:</td>
            <td><input type="name" required="required" name="last_name" value="<?php echo $sreg['fullname']; echo $obj['http://axschema.org/namePerson/last'][0];?>"/></td></tr>
        <tr><td><input id="newReg" type="submit" value="Register"/></td></tr>
    </table>
</form>
<?php
// user does not exist 
 }
}else {
?>

<link type="text/css" rel="stylesheet" href="css/openid.css" />
<!-- <script type="text/javascript" src="js/jquery-1.2.6.min.js"></script> -->
<script type="text/javascript" src="js/openid-jquery.js"></script>
<script type="text/javascript" src="js/openid-en.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		openid.init('openid_identifier');
		// openid.setDemoMode(true); //Stops form submission for client javascript-only test purposes

		openid.setDemoMode(false);
		//Stops form submission for client javascript-only test purposes
	}); 
</script>
<!-- /Simple OpenID Selector -->
<style type="text/css">
	/* Basic page formatting */
	body {
		font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	}
</style>
<form action="includes/try_auth.php" method="get" id="openid_form" class="grid_12">
<input type="hidden" name="action" value="verify" />
<fieldset>
<legend>Sign-in or Create New Account</legend>
<div id="openid_choice">
<p>Please click your account provider:</p>
<div id="openid_btns"></div>
</div>
<div id="openid_input_area">
<input id="openid_identifier" name="openid_identifier" type="text" value="http://" />
<input id="openid_submit" type="submit" value="Sign-In"/>
</div>
<noscript>
<p>OpenID is service that allows you to log-on to many different websites using a single indentity.
Find out <a href="http://openid.net/what/">more about OpenID</a> and <a href="http://openid.net/get/">how to get an OpenID enabled account</a>.</p>
</noscript>
</fieldset>
</form>
<?php
}
?>
<?php

include_once ("includes/foot.php");
?>