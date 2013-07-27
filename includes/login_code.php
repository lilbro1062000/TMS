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
    $id_found = ex_query1RowAns("select * from usersinfo where ID ='" . $identity . "'");

    if (isset($id_found)) {
        return true;
    } else {
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
    $email = mysql_real_escape_string($INFO['email']);
    $ID = mysql_real_escape_string($INFO['MyloginID']);

    $query = 'Insert into ';
    $query .= 'usersinfo ';
    $query .= '(ID,first_name,last_name,email) ';
    $query .= 'Values( ';
    $query .= "'$ID'";
    $query .= ' , \'';
    $query .= $Firstname;
    $query .= '\', \'';
    $query .= $Lastname;
    $query .= '\', \'';
    $query .= $email;
    $query .= '\') ';

    ex_query($query);
}

function login($var) {
    logout_code();
    session_start();
    
    $_SESSION[SESSIONUSERID] = $var;
    $_SESSION[SESSIONUSERNAME] = getUsername($var);
}

/**
 * when successfully logged into the site
 * this function will store the First name last name , email , loginID
 *This is passed
 * @return void
 * @author
 */
function StoretempLoginData($email, $fname, $lname, $identity, $success) {
    if (session_start()) {
        $_SESSION['first_name'] = $fname;
        $_SESSION['last_name'] = $lname;
        $_SESSION['email'] = $email;
        $_SESSION['loginID'] = $identity;
        $_SESSION['success'] = $success;
    }

}

/**
 * this clears out the Session values used in Store Template login Data
 *
 * @return void
 * @author
 */
function clearoutdata() {
    $_SESSION['first_name'] = "";
    $_SESSION['last_name'] = "";
    $_SESSION['email'] = "";
    $_SESSION['loginID'] = "";
    $_SESSION['success'] = "";
}
/**
 * undocumented function
 *
 * @return void
 * @author  
 */
function logout() {
    logout_code();
    javascriptRedirect('login.php');
}
function logout_code() {
    //removing all instance of session once logged out.

    $_SESSION = array();
    //empty session

    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 450000, '/');
    }

    session_destroy();

    
}

/**
 * Checks to see if your logged in
 *
 * @return boolean
 * @author
 */
function isSitelogin() {
    if (isset($_SESSION[SESSIONUSERID])) {
        return Idntityfound($_SESSION[SESSIONUSERID]);
        } else {
        return false;
    }

}

function redirect_to($location = NULL) {
    if ($location != NULL) {
        header("location:{$location}");
    } else {
        header("location: index.php");
    }

}
?>