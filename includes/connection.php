<?php
if($_SERVER["SERVER_NAME"]=="www.tmsomething-dev.com")
 {
    // it thinks it server is also localhost
    // config 
    // this means i can debug  
      
     $debug=1;
 }
else{
    var_dump($_SERVER["SERVER_NAME"]);
    unset($debug);
}
    
 
if (isset($debug)) {
    include_once ("constants_debug.php");
    $connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
} else {

    include_once ("constants.php");
    $connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
}

if (!$connection) {
    die("Database connection failed: " . mysql_error());

}
//select DB to use local
//$db_select = mysql_select_db(DB_Name, $connection);
$db_select = mysql_select_db(DB_Name, $connection);
if (!$db_select) {
    die("Database cannot be selected  : " . mysql_error());
}
?>