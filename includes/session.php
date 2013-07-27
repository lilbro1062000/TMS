<?php
include_once ("head.php");
include_once ("categories.php");

/**
 * This page facilitaes the logon of the user
 * the user only has a user name and email address 
 */

 if(!isSitelogin())
 {
     // redirect to login page 
     redirect_to('login.php?msg=2');
 }
 
?>