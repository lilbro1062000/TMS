<?php
// if the person isn't verified then verify them
// check the indicator
include 'session.php';

    if(!checklogin())
    {
        redirect_to('..\login.php?msg=2');
    }
    else
    {
		//setcookie(session_name(),'',time()+1950,'/');
        return true;

    }


function checklogin()
{
    return isset($_SESSION[SESSIONUSERID]);
}
include_once 'connection.php';
require_once 'functions.php';

if (isset($_GET['ind'])) {
echo "<html>
		<head>
			<meta http-equiv=\"refresh\" content=\"5; url=../profile.php\"> 
		</head>
		<body>";
	//verify them
	// To verify we must make sure the hash in your email matches that in the database
	if (isset($_GET['email'])) {

		$hash = $_GET['hash'];
		$email = $_GET['email'];
		if (ex_query1RowAns("select VerifiedEmail from usersinfo where Email='" . $email . "' ") == $hash) {
			$query = "UPDATE  usersinfo SET  `VerifiedEmail` =1 where Email='" . $email . "' ";
			ex_query($query);
			$query = "UPDATE notifications SET visible =0 where type=\"Verify\" and userid=".GetuserIDfromEmail($email);
			ex_query($query);
			echo "<div  class=\"grid_6\"> Email Verified!!!! click <a href=\"profile.php\">Here</a></div> ";
		} else {
			echo "<div class=\"grid_6\" >invalided link!!! click <a href=\"profile.php\">Here</a></div>";
		}
	} else {
		echo "<div class=\"grid_6\" >invalided link!!! click <a href=\"profile.php\"></a>Here</div>";
	}
	
echo "</body>
	</html>";

} else {
	if (isset($_GET['hash'])) {
		if (isset($_GET['email'])) {

			$hash = $_GET['hash'];
			$email = $_GET['email'];
			$message = ' 
Thanks for signing up! 
Your account has been created, you can login after you have activated your account by pressing the url below. 
 
Please click this link to activate your account: 
 
http://www.tmsomething.com/includes/verify.php?ind=1&email=' . $email . '&hash=' . $hash . ' 
 
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

				echo "<p> Verification Email Has been sent to your email at " . $email . ".</p> <p> Please click on the link in your email to verify your paypal and contact Email address. </p>";
				echo "<p> If for any reason you did not get the email as expected please check you spam or contact us Directly at help AT tmsomething.com</p>";

			}

		} else {
			echo "<div>invalided link!!!</div>";
		}
	} else if(isset($_GET['requestpay'])){
		if(isset($_GET['ID']))
		{
			$userID =$_GET['ID'];
			$pay =$_GET['requestpay'];
			
			//update Table for request and sent Email to support@tmsomething.com
			//first update table 
			//only one request per day 
			$query = "select max(dtRequested) from payments where UserID =".$userID;
			if((time() - strtotime(ex_query1RowAns($query))) > (60*60*24)){
			$query = "Insert into payments(UserID,requested,dtRequested) Values(";
			$query .="'".$userID."',";
			$query .="'".$pay."',";
			$query .="'".to_mysqlDate(time())."'";
			$query .=")";
			
			ex_query($query);	
			require_once ("../phpmailer/class.phpmailer.php");

			$mail = new phpmailer();
			$mail -> IsSendmail();
			$mail -> SetFrom("noreply@TMSomething.com", 'Teach Me Something', '');
			$mail -> AddAddress("support@TMSOmething.com","Support");
			$mail -> Subject = "'Request Payment'";
			$mail -> Body = "ID $userID has requested payment of $pay";
			$mail -> Send();		

echo "<div class=\"grid_6\" >Request Sent Please close this box we will contact you within 10 days after the request!!!</div>";
			}
			else {
				echo "<div class=\"grid_6\" >Only 1 Request per Day Please.</div>";
			} 
			
	}
		
	}
else {
	echo "<div class=\"grid_6\" >invalided link!!!</div>";
}
}
?>