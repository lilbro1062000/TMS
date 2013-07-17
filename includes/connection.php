<?php
if ($debug == 1) {
    require_once ("constants_debug.php");

} else {

    require_once ("constants.php");

}
$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
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