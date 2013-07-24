<?php
require_once('functions.php');
// require 'FB.php';
/**
 * This page facilitaes the logon of the user
 * the user only has a user name and email address 
 */
function Logged_in()
{
    if(!checklogin())
    {
        redirect_to('login.php?msg=2');
    }
    else
    {
		//setcookie(session_name(),'',time()+1950,'/');
        return true;

    }
}

function checklogin()
{
    return isset($_SESSION[SESSIONUSERID]);
}
?>