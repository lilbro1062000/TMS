<?php
require_once('functions.php');

session_start();

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
    return isset($_SESSION['User_ID']);
}
?>