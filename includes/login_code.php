<?php
//check to see if they are in the DB
require_once("functions.php");
require_once("connection.php");

$username = mysql_real_escape_string($_POST['Username']);
$HashedPassword = sha1(mysql_real_escape_string($_POST['Password']));

$query = 'Select ID ';
$query .= 'from ';
$query .= 'users ';
$query .= 'where ';
$query .= 'Username = \'';
$query .= $username;
$query .= '\' ';
$query .= 'and ';
$query .= 'Password = \'';
$query .= $HashedPassword;
$query .= '\'';
$User_ID = ex_query1RowAns($query);

if(!isset($User_ID))
{
    redirect_to("../login.php?msg=1");
}
else{
    include_once("session.php");
    $_SESSION['User_ID']=$User_ID;
    $_SESSION['User_Name']=$username;
	//setcookie(session_name(),'',time()+3600,'/');
    redirect_to("../index.php");
}
?>