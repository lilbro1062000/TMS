<?php
//to echo all jobs that need to be done for that
//Session 
include 'session.php';
Logged_in();
include_once 'connection.php';
require_once 'functions.php';

$query ="Select Progress, VideoName, Percentage from jobs where Userid='{$_SESSION[SESSIONUSERID]}' order by ID desc";
$result =ex_query($query);
while ($row =mysql_fetch_array($result))
 {
 	$VideoName=$row['VideoName'];
	$currentProgress=$row['Percentage'];
	$Progress =$row['Progress'];
	echo "<div id=\"progress\"class=\"grid_6\">\n";
	echo "<h1> $VideoName</h1>\n";
	echo "<p>$Progress</p>";
	echo "<progress max=\"100\" value=\"$currentProgress\" id=\"progressbar\"> Please oh Please Download <a href=\"https://www.google.com/intl/en/chrome/browser/\">Google Chrome</a></progress>\n";
	if($currentProgress ==100)
	{
		echo "<a href=\"updatevid.php?videoID={$Progress}\">Edit Video INFO</a>";
	}
	echo "</div>\n";	
}
?>