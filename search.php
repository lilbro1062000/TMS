<?php

include_once ("includes/head.php");
include_once ("includes/categories.php")

?>

<?php

if(isset($_GET['Page']) && $_GET['Page']>0 && isset($_GET['VidNum']))
	{ 
		if(isset($_GET['Search']))
		{ 
			$query ="Select Distinct ID from 
		(Select ID from video
		 left join keywords on video.ID = keywords.VideoID
		 left join videodesc on video.ID = videodesc.VidID
		 where (";		
		$checked = explode(' ', mysql_real_escape_string($_GET['Search']));
		$r ="";
		for ($i=0; $i < count($checked); $i++) {
			if ($i>0) {
				 $query =$query." or ";
			 } 
		$query = $query."
		 LOWER(keyword) like LOWER('%$checked[$i]%')
		  or
		 LOWER(video.VideoName) like LOWER('%$checked[$i]%')
		 or 
		 LOWER(videodesc.txtDesc) like LOWER('%$checked[$i]%')
		 ";
			 
		}
		
		 $query =$query."
		 )  
		 ) as tempTable";
			
		showPages($_GET['Page'], $_GET['VidNum'],$query);
		Pages_search($query, "Search.php",$_GET['Search']);	
		}
		else {
			echo "<p class=\"grid_9\"> No results </p>";
		}
	}
	else {
					
			$query ="Select Distinct ID from 
		(Select ID from video
		 left join keywords on video.ID = keywords.VideoID
		 left join videodesc on video.ID = videodesc.VidID
		 where (";			
		$checked = explode(' ', mysql_real_escape_string($_GET['Search']));
		$r ="";
		for ($i=0; $i < count($checked); $i++) {
			if ($i>0) {
				 $query =$query." or ";
			 } 
		$query = $query."
		 LOWER(keyword) like LOWER('%$checked[$i]%')
		 or
		 LOWER(video.VideoName) like LOWER('%$checked[$i]%')
		 or 
		 LOWER(videodesc.txtDesc) like LOWER('%$checked[$i]%')
		 ";
		}
		
		 $query =$query."
		 )  
		 ) as tempTable";
			
			$results = ex_query($query);
			
			$count =GenMultipleThumb($results);
			Pages_search($query, "search.php",$_GET['Search']);	
			
			if($count ==1)
			{
			    echo "<strong class=\"grid_9\">No videos found with Keyword $checked</strong>\n";
				
			}
	}


?>
  <?php

include_once ("includes/foot.php");

?>