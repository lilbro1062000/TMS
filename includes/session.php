<?php
require_once('functions.php');
require 'FB.php';

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