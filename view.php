<?php
include_once("includes/session.php");
include_once("includes/head.php");
include_once ("includes/categories.php")
?>
<link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/c/video.js"></script>
<div id="azk43115"></div>
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
echo("<div class=\"grid_12\"  id=\"VideoContainer\">\n");
echo("<h2> ".$row['VideoName']."</h2> \n");
echo("<video name=\"$hash\" height=\"530\" width=\"940\" id=\"Video\" ");
echo("poster=\"".urlencode("includes/image.php?vid=1&fname=".$row['videoImage'])."\" ");
echo(" class=\"video-js vjs-default-skin\" controls=\"true\"  preload=\"auto\" >\n");

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

<script type="text/javascript"><!--
google_ad_client = "ca-pub-4475426569219871";
/* Video Ads */
google_ad_slot = "4140414938";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<script>
	var myvar = setInterval(function() {
		var myvid = document.getElementById('Video');
		if (myvid.currentTime > 5) {
			checkCookie();
		}
	}, 1000);
	function setCookie(c_name, value, exdays) {
		var exdate = new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
		document.cookie = c_name + "=" + c_value;
		
		clearInterval(myvar);
	}

	// function getCookie(c_name)
	// {
	// var i,x,y,ARRcookies=document.cookie.split(";");
	// for (i=0;i<ARRcookies.length;i++)
	// {
	// x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	// y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	// x=x.replace(/^\s+|\s+$/g,"");
	// if (x==c_name)
	// {
	// return unescape(y);
	// }
	// }
	// }

	function checkCookie() {
		var username = document.getElementById("Video");
		username = username.getAttribute("Name");
		setCookie("VideoCount",username,365);
	}
</script>
<!-- Place this tag where you want the +1 button to render. -->
<div class="g-plusone"></div>

<!-- Place this tag after the last +1 button tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<div id="BottemVideoPanel">
	<ul>
		<li id="viewcount">
			View Count: <?php 
			$query = "select Numwatched from views where Video_ID =".GetVideoID($hash);
			echo ex_query1RowAns($query);
			 ?>
		</li>
		
		<li id="Description">
			<?php
			$descrow = ex_query1RowAns("select txtDesc from videodesc where VidID=" . $row['ID']);
			if(isset($descrow))
			{
			echo($descrow);
			}
			else {
				echo "No Description Added Yet";
			}
			?>
		</li>
		<li id="Uploader">
			<?php 
			$query = "select fblink from users where ID =(select UserID from video where Hash='$hash')";
			echo "<a href='";
			echo ex_query1RowAns($query);
			echo "'> ";
			$query = "select UserName from users where ID =(select UserID from video where Hash='$hash')";
			echo ex_query1RowAns($query);
			echo " </a>";
			 ?>
		</li>
		<?php
		if (!liked($_SESSION['User_ID'], GetVideoID($hash))) {
				//Show liked button
				echo "<li id=\"Like\">";
				echo "<a href=\"";
				echo("includes/operations.php?liked=1&videoID=");
				echo($_GET['videoID']);
				echo("\" />");
				echo('Like');
				echo "</a> </li>\n";
			} else {
				//show unlike button
				echo "<li id=\"unLike\">";
				echo "<a href=\"";
				echo("includes/operations.php?liked=0&videoID=");
				echo($_GET['videoID']);
				echo("\" />");
				echo('Unlike');
				echo "</a> </li>\n";
			}
			if (!reported($_SESSION['User_ID'], GetVideoID($hash))) {
				//Show report button
				echo "<li id=\"report\">";
				echo "<a href=\"";
				echo("includes/operations.php?reported=1&videoID=");
				echo($_GET['videoID']);
				echo("\" />");
				echo('report');
				echo "</a> </li>\n";
			} else {
				//show unreport button
				echo "<li id=\"unreport\">";
				echo "<a href=\"";
				echo("includes/operations.php?reported=0&videoID=");
				echo($_GET['videoID']);
				echo("\" />");
				echo('unreport');
				echo "</a> </li>\n";
			}
		
		
		?>
		
<li>
	<?php 
	echo "<iframe src=\"http://www.facebook.com/plugins/like.php?href={$_SERVER["HTTP_HOST"]}/view.php?videoID=$hash\"\n 
        scrolling=\"no\" frameborder=\"0\"\n
        style=\"border:none; width:450px; height:80px\"></iframe>\n";
	 ?>
	
</li>

	</ul>
</div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="CommentArea">
<div class="fb-comments" data-href="<?php echo $_SERVER["HTTP_HOST"]."/view.php?videoID=$hash\""; ?>" data-num-posts="5" data-width="470" data-colorscheme="light"></div>
</div>
<?php

//add favories function already exists maybe a button or link That runs whitout reloading the page.
echo("</div>");

if (checklogin()) {
	// i have to add a check to see if this has been seen if so then it should just edit the date
	//$query ="Insert into History(USERID,VideoID,Date) Values('{$_SESSION[SESSIONUSERID]}','".$hash."','".to_mysqlDate(time())."')";
	//ex_query($query);
	$vidID = GetVideoID($hash);
	UpdateHistory($_SESSION[SESSIONUSERID], $hash, to_mysqlDate(time()));
	
}
}
else{
echo("<p class=\"grid_6\">Sorry this video doesnt exist</p>\n");
}
?>
<?php
include_once ("includes/foot.php");
?>