<?php



include_once ("includes/head.php");
include_once ("includes/categories.php");
?>
<?php

if (isset($_GET['logout'])) {
    if ($_GET['logout'] == 2) {
        $message = ' You have been logged out!';
        
    }
}
if (isset($_GET['canceled'])) {
    $msg = "Verification cancelled";
}
if (isset($_GET["failed"])) {
    $error = $_GET["failed"];
}
if (isset($_GET["success"])) {
    $success = urldecode($_GET["success"]);
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
      logout();
    }

}

// registers a user if there is post data
if (isset($_POST['MyloginID'])) {
    if ($_POST['MyloginID'] == $_SESSION['loginID']) {
        registerUser($_POST);
        // i should check to make sure they didn't put anything malicious
        // afterwards we should go to the profile page
        var_dump($_POST);
        login($_SESSION['loginID']);
        clearoutdata();
        javascriptRedirect('profile.php', 0);
        //exit;
    } else {
        // the Session does not match so go back to regular login
        $msg = " Session Does not match form";
        javascriptRedirect('login.php', 0);
        //exit;
    }

}
?>
<div class="grid_12"></div>
<?php if (isset($msg)) { print "<div class=\"alert\">$msg</div>";}?>
<?php if (isset($error)) { print "<div class=\"error\">$error</div>";}?>
<?php if (isset($success)) { print "<div class=\"success\">$success</div>";}?>
<?php if (isset($newuser)) { print "<div class=\"success\">$newuser</div>";}
if(isset($_SESSION['loginID'])&&$_SESSION['loginID']!="")
{
 if(Idntityfound($_SESSION['loginID']))
 {
     login($_SESSION['loginID']);
     javascriptRedirect('profile.php', 0); 
 }
 else {
    // user does not exist
    $newuser ="You are new to our site Please make sure the information is correct";
    $success =$_SESSION['success'];
?>

<form action="#" method="post" id="reg_form" class="grid_9">
    <input type="hidden" name="MyloginID" value="<?php echo $_SESSION['loginID']; ?>"/>
    <table>
        <tr><td>Please Enter Email Address:</td>
        <td><input type="email" required="required" name="email" value="<?php echo $_SESSION['email']; ?>"/></td>                
        </tr>
        <tr>
            <td>Please Enter First Name:</td>
            <td><input type="name" required="required" name="first_name" value="<?php echo $_SESSION['first_name']; ?>"/></td></tr>
        <tr>
            <td>Please Enter Last Name:</td>
            <td><input type="name" required="required" name="last_name" value="<?php  echo $_SESSION['last_name']; ?>"/></td></tr>
        <tr><td><input id="newReg" type="submit" value="Register"/></td></tr>
    </table>
</form>
<?php
// user does not exist
}
}else {
?>

<link type="text/css" rel="stylesheet" href="stylesheets/openid.css" />
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