<?php

require_once ("constants.php");
//connect to db local
//$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
//aws db
$connection = mysql_connect(AWS_DB_SERVER, AWS_DB_USER, AWS_DB_PASS);
if (!$connection)
{
    die("Database connection failed: " . mysql_error());

}
//select DB to use local
//$db_select = mysql_select_db(DB_Name, $connection);
$db_select = mysql_select_db(AWS_DB_Name, $connection);
if (!$db_select)
{
    die("Database cannot be selected  : " . mysql_error());
}

?>