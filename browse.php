<?php
include_once ("includes/head.php");
include_once ("includes/categories.php")

?>
<?php
//Browse page if the category is set show 30 random video thumbnails as links to the video page 
//if not set show 30 random thumbnails 
// Generate thumbnails first 
// first get 20 random IDs in the DB 
//Select ID from Video LIMIT 0 , 30
//loop through each row and add to array 
//shuffle them and select the first 10 or 20 
if(isset($_GET['Views']))
{
	$query ="Select Video_ID From views  order by Numwatched desc limit  0, 7";
	 $results= ex_query($query);
	 while($row = mysql_fetch_array($results))
    {
             GEnerateImageThumb($row[0]);    
    }
}
elseif(isset($_GET['Recent']))
{
	$query ="Select id From video order by ID desc limit 0, 7";
	 $results= ex_query($query);
	 GenMultipleThumb($results);
}

elseif (isset($_GET['Category']))
{
	$cat = $_GET['Category'];
		if(isset($_GET['Page']) && $_GET['Page']>0 && isset($_GET['VidNum']))
	{
		$query ="select id from video where hash in ((Select hash from videocatinfo where Category='".$cat."'))";
		showPages($_GET['Page'], $_GET['VidNum'],$query);
		Cat_Pages($query, "browse.php",$cat);
		
	}
	else{
		    
			$query ="select id from video where hash in ((Select hash from videocatinfo where Category='".$cat."'))";
			$results= ex_query($query);
			GenMultipleThumb($results);
			Cat_Pages($query, "browse.php",$cat);
			   
		}
} else
{
	if(isset($_GET['Page']) && $_GET['Page']>0 && isset($_GET['VidNum']))
	{
		showPages($_GET['Page'], $_GET['VidNum'],"select id from video ");
		Pages("select ID from video", "browse.php");
		
	}
	else {
					
				
			  	$count=1; 
			   	$results= ex_query("Select ID from video;");
				$count=GenMultipleThumb($results);
				Pages("Select ID from video", "browse.php");
	}
  
   
}

?>

<?php
include_once ("includes/foot.php");
?>