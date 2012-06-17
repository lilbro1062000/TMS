<?php
include_once ("includes/session.php");
Logged_in();
include_once ("includes/head.php");
include_once ("includes/categories.php");
?>

<?php

if(isset($_GET['Page']) && $_GET['Page']>0 && isset($_GET['VidNum']))
	{
	$query="Select id from video where hash in"; 
	$query.= "(Select VideoID from History where UserID=";
	$query.= $_SESSION[SESSIONUSERID];
	$query.=" order by Date desc)";
		showPages($_GET['Page'], $_GET['VidNum'],$query);
		Pages($query, "history.php");
		
	}
	else {
					


$count=1;			
// A list of videos that has been watched under account 

//Select the video by date ascending 
//right now there are no videos 
$query="Select id from video where hash in"; 
$query.= "(Select VideoID from history where UserID=";
$query.= $_SESSION[SESSIONUSERID];
$query.=" order by Date desc)";
$results = ex_query($query);

			$count =GenMultipleThumb($results);
				Pages($query, "history.php");

if($count==1){
	    echo "<strong class=\"grid_9\">No History</strong>\n";
		}
	}
?>
<?php include_once ("includes/foot.php"); ?>


