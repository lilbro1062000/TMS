<?php
include_once ("includes/head.php");
include_once ("includes/categories.php")

?>
<div class="grid_12">
	<nav>
 <p>
  <a href="/" rel="index up">Main</a> >
  <a href="/browse.php" rel="up up">Browse</a> >
  	<?php
  	// This is for bread Crumb
  	// For each Category start with the last and go backwards
  	$breakcrumb="up up";
  	if(isset($_GET['Category']))
	{
		
		$category = $_GET['Category'];
		//first we make our way up the three then down to find the base
		$n="nt";
		$count=0;
		$some = $category;
		while ($n!=="no") {
		$n=ex_query1RowAns("Select PrevName from categories where Name='$some'");
			$count++;
			//$final = "<a href=\"browse.php?Category=$fname\" rel=\"$breakcrumb\">$fname</a>\n".$final;
			
			if($n=="NULL"|| empty($n))
			{
				
				$n= "no";
			}	
			else {
				$some = $n;
			}
		} 
		 // from the top we work our way down
		
		$n=$category;
		while ($n!="no") {
			$breakcrumb = "up up";
			for ($i=0; $i < $count; $i++) { 
				$breakcrumb =$breakcrumb ." up";
			}
			$count--;
			$final = "<a href=\"/Category/$n\" rel=\"$breakcrumb\">$n</a> >\n".$final;
			$n=ex_query1RowAns("Select PrevName from categories where Name='$n'");
			//$final = "<a href=\"browse.php?Category=$fname\" rel=\"$breakcrumb\">$fname</a>\n".$final;
			if($n=='NULL')
			{
				$n= "no";
			}if(empty($n))
			{	$n= "no";}	
		} 
		 // from the top we work our way down
		
		echo "$final";
  	} 
	
  	?>
  	</p>
</nav>
</div>
  <div class="grid_12">
  	<?php
  	// so there should be a query 
  	// this is to create a bread crumb trail and link for a search 
  	// this will appear as a string of some length 
  	// than a box will appear with the information
  	if(isset($_GET['Category']))
	{
	$query = "Select Name from categories where Prevname ='".$_GET['Category']."'";	
	}
	else {
		$query = "Select Name from categories where Prevname ='NULL'";
	}
	
	$result = ex_query($query);
	echo "<nav id=\"Navmenu\">";
	echo "<ul>";
	while ($row = mysql_fetch_array($result)) {
		
		echo "\n<li><a href=\"/Category/$row[0]\">$row[0]</a></li>\n";
	}echo "</ul>";
  	 echo "</nav>";
  		?>
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
	$query ="Select Video_ID From views  order by Numwatched desc limit  0, 24";
	 $results= ex_query($query);
	 while($row = mysql_fetch_array($results))
    {
             GEnerateImageThumb($row[0]);    
    }
}
elseif(isset($_GET['Recent']))
{
	$query ="Select id From video order by ID desc limit 0, 24";
	 $results= ex_query($query);
	 GenMultipleThumb($results);
}
elseif (isset($_GET['Category']))
{
	$cat = $_GET['Category'];
		if(isset($_GET['Page']) && $_GET['Page']>0 && isset($_GET['VidNum']))
	{
		$query ="select id from video where hash in ((Select hash from videocatinfo where LOWER(Category)=LOWER('".$cat."')))";
		
		showPages($_GET['Page'], $_GET['VidNum'],$query);
		Cat_Pages($query, "browse.php",$cat);
	}
	else{
			$query ="select id from video where hash in ((Select hash from videocatinfo where LOWER(Category)=LOWER('".$cat."')))";
		
			$results= ex_query($query);
			GenMultipleThumb($results);
			Cat_Pages($query, "browse.php",$cat);   
		}
}elseif(isset($_GET['user']))
{
	$user =$_GET['user'];
	
	$query = "Select id from video where UserID in (Select ID from users where UserName='$user')";
	$results =ex_query($query);
	GenMultipleThumb($results);
	Pages($query, "browse.php");
	
} 
else
{
	if(isset($_GET['Page']) && $_GET['Page']>0 && isset($_GET['VidNum']))
	{
		showPages($_GET['Page'], $_GET['VidNum'],"select id from video ");
		Pages("select ID from video", "/browse.php");	
	}
	else {
			   	$results= ex_query("Select ID from video;");
				$count=GenMultipleThumb($results);
				Pages("Select ID from video", "/browse.php");
		}  
}
?>
<?php
include_once ("includes/foot.php");
?>