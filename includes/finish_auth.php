<?php

require_once "common.php";
require 'functions.php';

function escape($thing) {
    return htmlentities($thing);
}

function run() {
    $consumer = getConsumer();

    // Complete the authentication process using the server's
    // response.
    $return_to = getReturnTo();
    $response = $consumer->complete($return_to);

    // Check the response status.
    if ($response->status == Auth_OpenID_CANCEL) {
        // This means the authentication was cancelled.
        $msg = 'Verification cancelled.';
        redirect_to("../login.php?canceled=1");
    } else if ($response->status == Auth_OpenID_FAILURE) {
        // Authentication failed; display the error message.
        $msg = "OpenID authentication failed: " . $response->message;
        redirect_to("../login.php?failed=".urlencode($response->message));
    } else if ($response->status == Auth_OpenID_SUCCESS) {
        // This means the authentication succeeded; extract the
        // identity URL and Simple Registration data (if it was
        // returned).
        $openid = $response->getDisplayIdentifier();
        $esc_identity = escape($openid);
        $identity=$esc_identity;
        $success = sprintf('You have successfully verified ' .
                           '%s as your identity Please Log in .',
                           $esc_identity);

        if ($response->endpoint->canonicalID) {
            $escaped_canonicalID = escape($response->endpoint->canonicalID);
            $success .= '  (XRI CanonicalID: '.$escaped_canonicalID.') ';
        }
        // AX info 
        $ax = new Auth_OpenID_AX_FetchResponse();
        $obj = $ax->fromSuccessResponse($response);

        
        // Print me raw
        // echo '<pre>';
        // print_r($obj->data);
        //var_dump($obj);
        // echo '</pre>';
        
        
        $fname=$obj->data['http://axschema.org/namePerson/first'][0];
        $lname=$obj->data['http://axschema.org/namePerson/last'][0];
        $email=$obj->data['http://axschema.org/contact/email'][0];
        
        $sreg_resp = Auth_OpenID_SRegResponse::fromSuccessResponse($response);

        $sreg = $sreg_resp->contents();
        
        if (@$sreg['email']) {
            $success .= "  You also returned '".escape($sreg['email']).
                "' as your email.";
        $email=$obj->data['http://axschema.org/contact/email'][0];
        }

        if (@$sreg['nickname']) {
            $success .= "  Your nickname is '".escape($sreg['nickname']).
                "'.";
        $fname=$obj->data['http://axschema.org/namePerson/first'][0];
        }

        if (@$sreg['fullname']) {
            $success .= "  Your fullname is '".escape($sreg['fullname']).
                "'.";
        $lname=$obj->data['http://axschema.org/namePerson/last'][0];
        }
        
	$pape_resp = Auth_OpenID_PAPE_Response::fromSuccessResponse($response);

	if ($pape_resp) {
            if ($pape_resp->auth_policies) {
                $success .= "<p>The following PAPE policies affected the authentication:</p><ul>";

                foreach ($pape_resp->auth_policies as $uri) {
                    $escaped_uri = escape($uri);
                    $success .= "<li><tt>$escaped_uri</tt></li>";
                }

                $success .= "</ul>";
            } else {
                $success .= "<p>No PAPE policies affected the authentication.</p>";
            }

            if ($pape_resp->auth_age) {
                $age = escape($pape_resp->auth_age);
                $success .= "<p>The authentication age returned by the " .
                    "server is: <tt>".$age."</tt></p>";
            }

            if ($pape_resp->nist_auth_level) {
                $auth_level = escape($pape_resp->nist_auth_level);
                $success .= "<p>The NIST auth level returned by the " .
                    "server is: <tt>".$auth_level."</tt></p>";
            }

	} else {
            $success .= "<p>No PAPE response was sent by the provider.</p>";
	}
	// maybe temporarily store in DB so that when i send the info its checked
	// I need to pass the first name and last name to the page .
	// security dictates that i should store this in DB or something 
	
	//If i pass it to the page then everyone could just anything 
	// and create accounts that can favorite everything 
	// They can create accounts by passing stuff  
	// set session values from the login page
	// INformation needed 
	//ID
	//email
    //first_name last_name 
    // Session variables 
    
    StoretempLoginData($email,$fname,$lname,$identity,$success);
	redirect_to("../login.php?success=".urlencode($success));
    }
    
    
}

run();

?>