<?php
require_once ('FB/facebook.php');
require_once ('constants.php');
$facebook = new Facebook( array('appId' => FB_APP_ID, 'secret' => FB_APP_SECRETE_KET, ));
$user = $facebook -> getUser();

function isFBLoggedin() {
	global $facebook, $user;

	if ($user) {
		try {
			$user_profile = $facebook -> api('/me');
			echo "$user_profile";
			return true;
		} catch (FacebookApiException $e) {
			error_log($e);
			$user = null;
			echo "not authenticated ";
			return false;
		}

	}
}

function GetFBlogoutURL() {
	global $facebook, $user;

	if ($user) {
		$logoutUrl = $facebook -> getLogoutUrl();
		return $logoutUrl;
	} else {
		$loginUrl = $facebook -> getLoginUrl();
		return $loginUrl;
	}

}

function redirectIfloggedIN() {
	global $facebook, $user;
	if ($user) {
		redirect_to("../index.php");
	}
}

function GetName() {
	global $facebook, $user;
	return $user['name'];

}

function fbUserExists() {
	global $facebook, $user;
	$user_profile = $facebook -> api('/me');

	$query = "Select 1 from UserInfo where ID = " . $user_profile["id"];

	if (ex_query1RowAns($query) == 1) {
		return true;
	} else {
		return false;
	}
}

function createFBUser() {
	global $facebook, $user;
	if (isFBLoggedin()) { 

		$user_profile = $facebook -> api('/me');

		$query = 'Insert into ';
		$query .= 'usersinfo ';
		$query .= '(ID,first_name,last_name,email) ';
		$query .= 'Values( ';
		$query .= $user_profile["id"];
		$query .= ' , \'';
		$query .= $user_profile["First_name"];
		$query .= '\', \'';
		$query .= $user_profile["Last_name"];
		$query .= '\', \'';
		$query .= $user_profile["email"];
		$query .= '\') ';

		ex_query($query);
		$query ='Insert into ';
		$query.='users '; 
		$query.='(ID,Username,Password) ';
		$query.='Values( \'';
		$query .= $user_profile["id"];
		$query .= ' , \'';
		$query .= $user_profile["First_name"]. " ".$user_profile["Last_name"];
		$query.=' \', \'';
		$query.="fbLoggedinNow";
		$query.='\' ) ';
		ex_query($query);

	login($user_profile["id"], $user_profile["First_name"]. " ".$user_profile["Last_name"]);
	}
	
	

}
?>