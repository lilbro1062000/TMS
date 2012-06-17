<?php
require_once ('FB/facebook.php');
require_once ('constants.php');
require_once ('functions.php');
$facebook = new Facebook( array('appId' => FB_APP_ID, 'secret' => FB_APP_SECRETE_KET, ));
$user = $facebook -> getUser();

function isFBLoggedin() {
	global $facebook, $user;

	if ($user) {
		try {
			$user_profile = $facebook -> api('/me');
			return true;
		} catch (FacebookApiException $e) {
			error_log($e);
			$user = null;
			return false;
		}

	}
}

function GetFBlogoutURL() {
	if(isFBLoggedin())
	{
		redirect_to("../index.php");
	}
}

function redirectIfloggedIN() {
	global $facebook,$user; 
	
	try{
		$user_profile = $facebook -> api('/me');
	if ($user_profile) {
		redirect_to("../index.php");
		}
	}
	catch(FacebookApiException $e){
		error_log($e);
	}	
	
	
}

function GetName() {
	global $facebook, $user;
	return $user['name'];

}
function GetFBUserID() {
	global $facebook, $user;
	$user_profile = $facebook -> api('/me');
	return $user_profile['id'];

}
function GetFBUserName() {
	global $facebook, $user;
	$user_profile = $facebook -> api('/me');
	return $user_profile["name"];

}

function fbUserExists() {
	global $facebook, $user;
	$user_profile = $facebook -> api('/me');

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
		$query ='Insert into ';
		$query.='users '; 
		$query.='(ID,Username,Password) ';
		$query.='Values( \'';
		$query .= $user_profile["id"];
		$query .= '\' , \'';
		$query .= $user_profile["name"];
		$query.=' \', \'';
		$query.="fbLoggedinNow";
		$query.='\' ) ';
		ex_query($query);
	}
	
	

}
?>