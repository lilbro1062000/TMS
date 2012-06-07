<?php
require_once('functions.php');

function loggout()
{
    //removing all instance of session once logged out. 
    session_start();
    
    $_SESSION = array(); //empty session
    
    if(isset($_COOKIE[session_name()]))
    {
        setcookie(session_name(),'',time()-450000,'/');
    }
    
    session_destroy();
    
    redirect_to('login.php?logout=2');
}

?>