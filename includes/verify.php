<?php
// if the person isn't verified then verify them
// check the indicator
include 'session.php';
Logged_in();
include_once 'connection.php';
require_once 'functions.php';

if (isset($_GET['ind'])) {
	include_once ("includes/head.php");
	include_once ("includes/categories.php");
	//verify them
	// To verify we must make sure the hash in your email matches that in the database
	if (isset($_GET['email'])) {

		$hash = $_GET['hash'];
		$email = $_GET['email'];
		if (ex_query1RowAns("select VerifiedEmail from usersinfo where Email='" . $email . "' ") == $hash) {
			$query = "UPDATE  usersinfo SET  `VerifiedEmail` =1";
			ex_query($query);
			echo "<div  class=\"grid_6\" >Email Verified!!!!</div>";
		} else {
			echo "<div class=\"grid_6\" >invalided link!!!</div>";
		}
	} else {
		echo "<div class=\"grid_6\" >invalided link!!!</div>";
	}
	include_once ("includes/foot.php");

} else {
	if (isset($_GET['hash'])) {
		if (isset($_GET['email'])) {

			$hash = $_GET['hash'];
			$email = $_GET['email'];
			$message = ' 
Thanks for signing up! 
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below. 
 
Please click this link to activate your account: 
 
http://www.' . $_SERVER["HTTP_HOST"] . '.com/verify.php?ind=1&email=' . $email . '&hash=' . $hash . ' 
 
';
			// Our message above including the link
			require_once ("../phpmailer/class.phpmailer.php");

			$mail = new phpmailer();
			$mail -> IsSendmail();
			$mail -> SetFrom("noreply@TMSomething.com", 'Teach Me Something', '');
			$mail -> AddAddress($email);
			$mail -> Subject = "'Email | Verification'";
			$mail -> Body = $message;
			if (!$mail -> Send()) {
				// $msg = "Mailer Error: " . $mail -> ErrorInfo;
				echo "Sorry Seems it didnt go through. Please try again or send an EMail";
			} else {
				//insert the hash into the table then show message

				$query = "UPDATE  usersinfo SET  `VerifiedEmail` ='";
				$query .= $hash;
				$query .= "' WHERE   Email ='" . $email . "'";

				ex_query($query);

				echo "<p> Verification Email Has been sent you your email at " . $email . ".</p> <p> Please click on the link in your email to verify your paypal and contact Email address. </p>";
				echo "<p> If for any reason you did not get the email as expected please check you spam or contact us Directly at help AT tmsomething.com</p>";

			}

		} else {
			echo "<div>invalided link!!!</div>";
		}
	} else {
		echo "<div class=\"grid_6\" >invalided link!!!</div>";
	}
}
?>