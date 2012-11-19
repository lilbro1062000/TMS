<?php 
//includes for processing 
require_once ("connection.php");
require_once ("functions.php");
//increase the view count when view is more then minute long and IP address is the same 
//logs view and updates the views in the views table 


//what if this page is requested 400 times with the same IP ?
// well i will set a limit a day for the video watches 
$hash =$_GET['videoID'];

$ip=$_SERVER['REMOTE_ADDR'];

//first check to see if the Ip has logged with that video in the last 5 *60  seconds (which is 5 minutes)

$query = "Select 1 from viewlog where ipaddress='$ip' and videoID ='".GetVideoID($hash)."' and datetime < '".to_mysqlDate(time())."' and datetime > '".to_mysqlDate(time() - (5*60))."'";

if(ex_query1RowAns($query)!=1)
{
	// So they haven't seen this video in the last 5 minutes  
	$query ="Select count(1) from viewlog where ipaddress='$ip' and videoID ='".GetVideoID($hash)."' and datetime < '".to_mysqlDate(time())."' and datetime > '".to_mysqlDate(time() - (24*60*60))."'";
	 if(ex_query1RowAns($query) < 400)
	 {
	 	// SO one IP haven't seen this more then 400 times a day 
	 	
	 	//Now we add them to the table 
	 	$query = "INSERT INTO viewlog (`ipaddress`, `videoID`, `datetime`) VALUES ('$ip', '".GetVideoID($hash)."', '".to_mysqlDate(time())."')";
	 	ex_query($query);
	 	// Now that its inserted we need to update the view
	 	
	 	$query ="UPDATE  views SET  `Numwatched` =  Numwatched + 1 WHERE  `views`.`Video_ID` =".GetVideoID($hash);
		ex_query($query);
		//Now that is updated we are done. 
		
		/**
		 * Have to add libraries and make sure that it works on my local
		 */
	 }
} 

//end case no matter what
//return the new view  
//return the views that are stored in the system
$query =	"select Numwatched from views where Video_ID =".GetVideoID($hash);
echo "View Count: ".ex_query1RowAns($query);
 ?>