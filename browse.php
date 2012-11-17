<?php
include_once ("includes/head.php");
include_once ("includes/categories.php")

?>
<div class="grid_12">
	<nav>
 <p>
  <a href="/" rel="index up">Main</a> >
  <a href="browse.php" rel="up up">Browse</a> >
  	<?php
  	// This is for bread Crumb
  	// For each Category start with the last and go backwards
  	$breakcrumb="up up";
  	if(isset($_GET['Category']))
	{
		
		$category = $_GET['Category'];
		//first we make our way up the three then down to find the base
		$n="nt";
		while ($n!="no") {
		$n=ex_query1RowAns("Select Name from categories where PrevName='$category'");
			if($n=="NULL")
			{
				$n= "no";
			}	
			else {
				$category = $n;
			}
		} 
		 // from the bottom we work our way up
		
		$breakcrumb = $breakcrumb ." up";
		$final= " <a href=\"browse.php?Category=$category\" rel=\"$breakcrumb\">$category</a>\n";
		$query = "Select PrevName from categories where Name='$category'";
		$fname =ex_query1RowAns($query);
		while($fname!="NULL")
		{
			$breakcrumb = $breakcrumb ." up";
			//  first i should get the previous name for the Category
			$query = "Select PrevName from categories where Name='$fname'";
			$fname =ex_query1RowAns($query);
			echo " <a href=\"browse.php?Category=$fname\" rel=\"$breakcrumb\">$fname</a>\n";
			
		}
  	  	$category = $_GET['Category'];
  		$query = "Select PrevName from categories where Name='$category'";
		
  	} 
	
  	?>
  	</p>
</nav>
</div>
  <div class="grid_12">
  	<?php
  	// This is for bread Crumb
  	?>
  	<?php
  	// so there should be a query 
  	// this is to create a bread crumb trail and link for a search 
  	// this will appear as a string of some length 
  	// than a box will appear with the information 
  	$query ="Select Name from  where Name=''"  	?>
  	something cool alwayse cool and never gone  
  </div>
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