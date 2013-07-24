<?php
//check to see if they are in the DB

/**
 * Returns true if the user is in the system, and false 
 * or otherwise
 *
 * @return boolean
 * @author  Abdoulaye Camara 
 */
function Idntityfound($identity) {
    $id_found = ex_query1RowAns("select ID from usersinfo where ID ='".$identity."'");
    
    if(isset($id_found))
    {
        return true;
    }
    else {
        return false;
    }
    
}
/**
 * registers the user into the system 
 *
 * @return boolean
 * @author  
 */
function registerUser($INFO) {
    /// INsert information to the user info dataase
    $Firstname = mysql_real_escape_string($INFO['first_name']);
        $Lastname = mysql_real_escape_string($INFO['last_name']);
        $email= mysql_real_escape_string($INFO['email']);
        $ID= mysql_real_escape_string($INFO['ID']);
         
        $query ='Insert into ';
        $query.='usersinfo '; 
        $query.='(ID,first_name,last_name,email) ';
        $query.='Values( ';
        $query.="'$ID'";
        $query.=' , \'';
        $query.=$Firstname;
        $query.='\', \'';
        $query.=$Lastname;
        $query.='\', \'';
        $query.=$email;
        $query.='\') ';
        
        ex_query($query);
}

function login($User_ID)
{
    session_start();
    $_SESSION[SESSIONUSERID]=$User_ID;
        
}
function loggout()
{
    //removing all instance of session once logged out. 
    
    $_SESSION = array(); //empty session
    
    if(isset($_COOKIE[session_name()]))
    {
        setcookie(session_name(),'',time()-450000,'/');
    }
    
    session_destroy();
    
    redirect_to('login.php?logout=2');
}

function isSitelogin()
{
    if(isset($_SESSION[SESSIONUSERID]) && isset($_SESSION[SESSIONUSERNAME]))
    {
        return true;
    }
    else {
        return false;
    }
}
function redirect_to($location =NULL)
{
    if($location!=NULL)
    {
        header("location:{$location}");
    }
    else{
            header("location: index.php");
    }

}
?>