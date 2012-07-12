<?php
include_once("includes/head.php");
include_once("includes/categories.php");

?>

<?php
if(isset($_POST['Firstname']))
{
		$Firstname = mysql_real_escape_string($_POST['Firstname']);
		$Lastname = mysql_real_escape_string($_POST['Lastname']);
		$Username = mysql_real_escape_string($_POST['Username']);
		$Password = mysql_real_escape_string($_POST['Password']);
		$secondPassword =mysql_real_escape_string($_POST['Password2']);
		if($Password!=$secondPassword)
		{
			$message ="Passwords are Not Identical";
		}
		$email=$_POST['email'];
		if(!validEmail($email))
		{
			$message ="EMail in INvalida format \n";
		}		
		$hashedPassword =sha1($Password);
		//Check combanation of username and password 
		$query ='Select 1 ';
		$query.='from ';
		$query.='users ';
		$query.='where ';
		$query.='Username =';
		$query.="'{$Username}'";
		
		if(ex_query1RowAns($query) !=1 && !isset($message))
		{
		//INsert into Table users for Username and Password First
		$query ='Insert into ';
		$query.='users '; 
		$query.='(Username,Password) ';
		$query.='Values( \'';
		$query.=$Username;
		$query.=' \', \'';
		$query.=$hashedPassword;
		$query.='\' ) ';
		ex_query($query);
		
		//Get the ID of the Insert that just took place 
		$query ='Select ID ';
		$query.='from ';
		$query.='users ';
		$query.='where ';
		$query.='Username =';
		$query.="'{$Username}'";
		$query.=' and  ';
		$query.='Password = ';
		$query.="'{$hashedPassword}'";
		
		$User_ID = ex_query1RowAns($query);
		/// INsert information to the user info page 
		$query ='Insert into ';
		$query.='usersinfo '; 
		$query.='(ID,first_name,last_name,email) ';
		$query.='Values( ';
		$query.=$User_ID;
		$query.=' , \'';
		$query.=$Firstname;
		$query.='\', \'';
		$query.=$Lastname;
		$query.='\', \'';
		$query.=$email;
		$query.='\') ';
		
		ex_query($query);
		// Information started Now i need to send them to the 
		// login page right to remind them of the password that they
		// used 
		redirect_to("login.php?msg=3");
		}
		else {
			if(isset($message))
			{
				$message .=" Username exists";
			}
			else{
				$message =" Username exists";
			}
			
		}

}
redirect_to("login.php?msg=3");
?>


<form id="Login" method="post" class="grid_4" action="signup.php">
	<?php
	if(isset($message))
	{
		echo $message;
	}
	?>
<table>
<tr>
<td> First name:</td> 
<td> <input type="text" name="Firstname" required="true"
	value="<?php if(isset($Firstname ))
	{
		echo $Firstname;
	}?>"
	/></td>
</tr>
<tr>
<td>Last name:</td> 
<td><input type="text" name="Lastname" required="true"
		value="<?php if(isset($Lastname ))
	{
		echo $Lastname;
	}?>" /></td>
</tr>
<tr>
<td>Username:</td> 
<td><input type="text" name="Username" required="true" 
	value="<?php if(isset($Username ))
	{
		echo $Username;
	}?>" /></td>
</tr>
<tr>
<td>Password:</td>
<td><input type="password" name="Password" required="true"/></td>
</tr>
<tr>
<td>Re-Enter Password:</td>
<td><input type="password" name="Password2" required="true"/></td>
</tr>
<td>Email Address :</td> 
<td><input type="text" name="email" required="true" <?php if(isset($email ))
	{
		echo $email;
	}?>" /></td>
</tr>
<tr>
<td><input type="submit" name="submit" value="Submit" required="true" /></td>
</tr>
</table>
</form>

  <?php
  include_once("includes/foot.php");
?>