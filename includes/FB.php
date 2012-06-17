<?php
require_once ('FB/facebook.php');
require_once ('constants.php');
$facebook = new Facebook( array('appId' => FB_APP_ID, 'secret' => FB_APP_SECRETE_KET, ));


function isFBLoggedin() {
	global $facebook;
	$user = $facebook -> getUser();

	if ($user) {
		try {
			$user_profile = $facebook -> api('/me');
			echo "$user_profile";
			//return true;
		} catch (FacebookApiException $e) {
			//error_log($e);
			$user = null;
			echo "not authenticated ";
			//return false;
		}

	}
}
?>