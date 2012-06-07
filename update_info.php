<?php
include_once("includes/session.php");
Logged_in();
?>
<?php
if(isset($_POST['fname']))
{
    include_once("includes/functions.php");
    require_once ("includes/connection.php");
    //Check if anything has changed 
    $_POST['fname'] =mysql_real_escape_string($_POST['fname']);
    $_POST['lname'] =mysql_real_escape_string($_POST['lname']);
    $_POST['email'] =mysql_real_escape_string($_POST['fname']);
    
    $query =" Select 1 from userinfo where First_name='{$_POST['fname']}' ";
    $query.=" and Last_Name='{$_POST['lname']}'";
    $query.=" Email ='{$_POST['email']}'"; 
    $query.=" Where ID='{$_SESSION[SESSIONUSERID]}'";
    if(ex_query1RowAns($query)!=1)
    {
    $query = 'UPDATE usersinfo SET';
    $query.=" First_Name ='{$_POST['fname']}'"; 
    $query.=" Last_Name ='{$_POST['lname']}'";
    $query.=" Email ='{$_POST['email']}'"; 
    $query.=" Where ID='{$_SESSION[SESSIONUSERID]}'";
    ex_query($query);
        $message =" Information Updated!!!!";
    }
    else{
        $message =" Nothing changed!!!!";
    }
    
}

?>

<?php
include_once ("includes/head.php");
include_once ("includes/categories.php");
//should show all the information needed on a page 

?>
<?php

$query ="Select * from user_info where ID=".$_SESSION[SESSIONUSERID];
$row =ex_query1Row($query);
$First_Name = $row['First_Name'];
$Lastname =$row['Last_Name'];
$email=$row['Email'];
?>
<form id="updateUserInfo" method="POST" action="update_info.php">
<table>
    <tr><?php if(isset($message)){echo $message;}?>
        <td>First Name</td>
        <td><input type="text" value="<?php echo($First_Name);?>"  name="fname" readonly="true" /></td>
    </tr>
    <tr>
    <td>Last Name</td>
    <td><input type="text" value="<?php echo($Lastname);?>" readonly="true" name="lname"/></td>
    </tr>
    <tr>
    <td>Email</td>
    <td><input type="text" value="<?php echo($email);?>" name="email"/></td>
    </tr>
    <tr><input type="submit" value="Submit"/></tr>
</table>
</form>
<?php


?>
<?php
include_once ("includes/foot.php");
?>