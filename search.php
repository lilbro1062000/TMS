<?php

include_once ("includes/head.php");
include_once ("includes/categories.php")

?>

<?php

if(isset($_GET['Page']) && $_GET['Page']>0 && isset($_GET['VidNum']))
	{
		if(isset($_GET['Search']))
		{
		$checked = mysql_real_escape_string($_GET['Search']);
		$query ="Select Distinct VideoID from (Select keywords.VideoID from keywords, video where keywords.VideoID = video.ID and keyword like '%{$checked}%') as tempTable";
		showPages($_GET['Page'], $_GET['VidNum'],$query);
		Pages_search($query, "Search.php",$_GET['Search']);	
		}
		else {
			echo "<p class=\"grid_9\"> No results </p>";
		}
	}
	else {
					
						
			$checked = mysql_real_escape_string($_GET['Search']);
			$query ="Select Distinct VideoID from (Select keywords.VideoID from keywords, video where keywords.VideoID = video.ID and keyword like '%{$checked}%') as tempTable";
			$results = ex_query($query);
			
			$count =GenMultipleThumb($results);
			Pages_search($query, "search.php",$_GET['Search']);	
			
			if($count ==1)
			{
			    echo "<strong class=\"grid_9\">No videos found with Keyword {$checked}</strong>\n";
				
			}
	}


?>
  <?php

include_once ("includes/foot.php");

?>