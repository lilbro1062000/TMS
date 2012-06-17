<?php
require_once ('FB/facebook.php');
require_once ('constants.php');
require_once ('functions.php');
$facebook = new Facebook( array('appId' => FB_APP_ID, 'secret' => FB_APP_SECRETE_KET, 'cookie' => true, ));
$user = $facebook -> getUser();
$token = $facebook -> getAccessToken();
function isFBLoggedin() {
	global $facebook, $user, $token;

	if ($user) {
		try {
			$user_profile = $facebook -> api('/'.$user, 'GET');
			return true;
		} catch (FacebookApiException $e) {
			error_log($e -> getType());
			error_log($e -> getMessage());
			$user = null;
			$login_URL = $facebook -> getLoginURL();
			echo "Please <a href=" . $login_URL . '"> login.</a>';
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

	if (isFBLoggedin()) {
		redirect_to("../index.php");
	}
}

function GetName() {
	global $facebook, $user;
	return $user['name'];

}

function GetFBUserID() {
	global $facebook, $user, $token;
	$user_profile = $facebook -> api('/me' . $token);
	return $user_profile['id'];

}

function GetFBUserName() {
	global $facebook, $user, $token;
	$user_profile = $facebook -> api('/me' . $token);
	return $user_profile["name"];

}

function fbUserExists() {
	global $facebook, $user, $token;
	$user_profile = $facebook -> api('/me' . $token);

	$query = "Select 1 from users where ID = " . $user_profile["id"];

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
		$query .= $user_profile["first_name"];
		$query .= '\', \'';
		$query .= $user_profile["last_name"];
		$query .= '\', \'';
		$query .= $user_profile["email"];
		$query .= '\') ';

		ex_query($query);
		$query = 'Insert into ';
		$query .= 'users ';
		$query .= '(ID,Username,Password) ';
		$query .= 'Values( \'';
		$query .= $user_profile["id"];
		$query .= '\' , \'';
		$query .= $user_profile["name"];
		$query .= ' \', \'';
		$query .= "fbLoggedinNow";
		$query .= '\' ) ';
		ex_query($query);
	}

}
?>