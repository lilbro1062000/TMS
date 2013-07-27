<?php
include_once ("includes/session.php");
?>


<?php 

if(isset($_GET['Page']) && $_GET['Page']>0 && isset($_GET['VidNum']))
	{
		$query="Select id from video where hash in"; 
		$query.= "(Select VideoID from favorites where UserID=";
		$query.= $_SESSION[SESSIONUSERID];
		$query.=" order by ID asc)";
		
		showPages($_GET['Page'], $_GET['VidNum'],$query);
		Pages($query, "faves.php");
}
else 
{
	$count =1;							
	// A list of videos that has been watched under account 
	//Select the video by date ascending 
	//right now there are no videos 
	$query="Select id from video where hash in"; 
	$query.= "(Select VideoID from favorites where UserID=";
	$query.= $_SESSION[SESSIONUSERID];
	$query.=" order by ID asc)";
	$results = ex_query($query);


		while($row = mysql_fetch_array($results))
		{
			if($count<7)
				{
				 GEnerateImageThumb($row[0]);	
				}
				$count++;	    
		}

		Pages($query, "faves.php");
		

if($count==1){
	echo "<strong class=\"grid_9\">No Favorites</strong>\n";
	}
}
?>
<?php
include_once ("includes/foot.php");
?>