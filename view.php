<?php
include_once("includes/session.php");
include_once("includes/head.php");
include_once ("includes/categories.php")
?>
<?php
	if(isset($_POST['VideoID']))
{
	$query= "Insert into comments(VideoID,UserID,Comment,DateSubmited) Values( ";
	$query.="'".GetVideoID($_POST['VideoID'])."',";
	$query.="'".$_SESSION[SESSIONUSERID]."',";
	$query.="'".mysql_real_escape_string($_POST['PComment'])."',";
	$query.="'" .to_mysqlDate(time())."')";
	
	ex_query($query);
	 //redirect_to("../view.php?videoID={$_GET['videoID']}");
}
if(isset($_GET['videoID']))
{
$hash =$_GET['videoID'];    
$row = ex_query1Row("select * from video where hash =\"".$hash."\"");
echo("<div class=\"grid_5\"  id=\"VideoContainer\">\n");
echo("<h2> ".$row['VideoName']."</h2> \n");
echo("<video id=\"Video\" ");
echo("poster=\"includes/image.php?vid=1&fname=".$row['videoImage']."\" ");
echo(" controls=\"controls\">\n");
echo("  <source src=\"".$row['mp4Path']."\" type='video/mp4; codecs=\"avc1.42E01E, mp4a.40.2\"' />\n");
echo(" <source src=\"".$row['webMPath']."\" type='video/webm; codecs=\"vp8, vorbis\"' />\n")
?>
Your Browser does not support this video tag 
<a href="https://www.google.com/chrome/index.html?hl=en&brand=CHNG&utm_source=en-hpp&utm_medium=hpp&utm_campaign=en"> Dowload Chrome </a> 
for the Best Views
<?php

echo("</video>\n");
echo("<br />\n");

?>


<script type="application/javascript"> 
$(document).load(function()
{
$('#Comment').onclick(function()
{
$('#Comment').empty();	
});
$9'#Comment').onfocusout(function()
{
	$('#Comment').html(...Add a comment);
});
});

	</script>
<div id="BottemVideoPanel">
<ul>
<li id="Description">
<?php
$descrow =ex_query1Row("select txtDesc from videodesc where VidID=".$row['ID']);
echo($descrow[0]);
?>
</li>

<?php 
if(checklogin())
{
	echo "<li id=\"FavoriteLink\">";
	echo "<a href=\"";
	if(!Favorited($_SESSION['User_ID'],$hash))
	{
	    //Show favorite button
	    echo("includes/operations.php?fav=1&videoID="); 
	    echo($_GET['videoID']);
	    echo("\" />");
	    echo('Favorite');
	}
	else
	{
	    //show unfavorite button
	    echo("includes/operations.php?fav=0&videoID="); 
	    echo($_GET['videoID']);
	    echo("\" />");
	    echo('UnFavorite');
	}
	echo "</a> </li>";
}
else{
	echo "#";
}
?>

<?php
if(checklogin())
{
	if(!liked($_SESSION['User_ID'],GetVideoID($hash)))
	{
	    //Show liked button
	    echo "<li id=\"Like\">";
		echo "<a href=\"";
	    echo("includes/operations.php?liked=1&videoID="); 
	    echo($_GET['videoID']);
	    echo("\" />");
	    echo('Like');
		echo "</a> </li>\n";
	}
	else
	{
	    //show unlike button
	    echo "<li id=\"unLike\">";
		echo "<a href=\"";
	    echo("includes/operations.php?liked=0&videoID="); 
	    echo($_GET['videoID']);
	    echo("\" />");
	    echo('Unlike');
		echo "</a> </li>\n";
	}
	if(!reported($_SESSION['User_ID'],GetVideoID($hash)))
	{
	    //Show report button
	    echo "<li id=\"report\">";
		echo "<a href=\"";
	    echo("includes/operations.php?reported=1&videoID="); 
	    echo($_GET['videoID']);
	    echo("\" />");
	    echo('report');
		echo "</a> </li>\n";
	}
	else
	{
	    //show unreport button
	    echo "<li id=\"unreport\">";
		echo "<a href=\"";
	    echo("includes/operations.php?fav=0&videoID="); 
	    echo($_GET['videoID']);
	    echo("\" />");
	    echo('unreport');
		echo "</a> </li>\n";
	}
}
?>

</ul>
</div>

<div id="CommentArea">

	<?php 
	if(checklogin())
	{
	echo "<form action=\"\" method=\"post\">\n";
	echo "<table>\n";
		echo "<tr>";
		echo "	<h3>";
				if(checklogin())
				{
					echo getUsername($_SESSION[SESSIONUSERID]);
				}
		echo"</h3>";
		echo "<textarea rows=\"8\" cols=\"80\" id=\"Comment\" name=\"PComment\" placeholder=\"Please Comment\"></textarea>";
		echo "</tr>";
		echo "<tr>";
		echo "<input type=\"submit\" name=\"Submit\"  value=\"Add Comment\"/>";
		echo "<input type=\"hidden\" name=\"VideoID\" value=\"{$_GET['videoID']}\"/>";
		echo "</tr>";
		echo "</table>";
	echo "</form>";	
	}
	else {
		echo "Please Login to Comment";
	}
	 ?>
	
	<div id= "AgComments">
	<?php
	$query="Select VideoID,UserID,Comment,DateSubmited from comments where videoID='".GetVideoID($hash)."' order by ID desc";
	$results = ex_query($query);
	while ($row =mysql_fetch_array($results))
	{
		
	echo "<div class=\"PostedComment\">\n";
	echo "<table>\n";
	echo "<tr>\n";
	echo "<td>\n";
	
	echo "<a> "; 
	echo getUsername($row['UserID']); 
	echo " </a> \n";
	
	
	if(checklogin())
		{
			echo "<a href=\"#\" > Report </a>\n";
			echo "<a href=\"#\" > ThumbsUp </a>\n";
			if($_SESSION[SESSIONUSERID]==$row['UserID'])
			{
				echo "<a href=\"#\" > Delete </a>\n";	
			}
			
		}
	echo "</td>\n";
	echo "<td>\n";
	echo "<div id=\"CommentBlock\">{$row['Comment']}</div> \n";
	
	echo "</td>\n";
	echo "</tr>\n";
	echo "</table>\n";	
	echo "</div>\n";
	}

	?>
</div>
</div>
<?php

//add favories function already exists maybe a button or link That runs whitout reloading the page. 
echo("</div>");

if(checklogin())
{
	// i have to add a check to see if this has been seen if so then it should just edit the date 
    //$query ="Insert into History(USERID,VideoID,Date) Values('{$_SESSION['User_ID']}','".$hash."','".to_mysqlDate(time())."')";
    //ex_query($query);
    $vidID =GetVideoID($hash);
	UpdateHistory($_SESSION[SESSIONUSERID],$hash,to_mysqlDate(time()));
	$query= "Update views set Numwatched = Numwatched+1 where video_id='{$vidID}'";
	ex_query($query);
}
}
else{
    echo("<p class=\"grid_6\">Sorry this video doesnt exist</p>\n");
}
?>
<?php
  include_once("includes/foot.php");
?>