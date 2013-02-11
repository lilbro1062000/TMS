<?php
include_once("includes/session.php");
include_once("includes/head.php");
include_once ("includes/categories.php")
?>

<div id="azk43115"></div>
<?php
	if(isset($_POST['VideoID']))
{
	$query= "Insert into comments(VideoID,UserID,Comment,DateSubmited) Values( ";
	$query.="'".GetVideoID($_POST['VideoID'])."',";
	$query.="'".$_SESSION[SESSIONUSERID]."',";
	$query.="'".mysql_real_escape_string($_POST['PComment'])."',";
	$query.="'" .to_mysqlDate(time())."')";
	
	//ex_query($query);
	 //redirect_to("../view.php?videoID={$_GET['videoID']}");
}
if(isset($_GET['videoID']))
{
$hash =$_GET['videoID'];    
$row = ex_query1Row("select * from video where hash =\"".$hash."\"");
//var_dump($row);
//exit;
if(empty($row))
{
	echo "<div class=\"grid_12\"> ";
	echo "No video Found";
	echo "</div>";
}
if ($row['site']=='local') {
echo("<div class=\"grid_12\"  id=\"VideoContainer\">\n");
echo("<h2> ".$row['VideoName']."</h2> \n");
echo("<video height=\"530\" width=\"940\" id=\"Video\" ");
echo("poster=\"".urlencode("/includes/image.php?vid=1&fname=".$row['videoImage'])."\" ");
echo(" class=\"video-js vjs-default-skin\" controls=\"controls\" autoplay=\"autoplay\" preload=\"auto\" >\n");
echo("  <source src=\"".$row['mp4Path']."\" type='video/mp4; codecs=\"avc1.42E01E, mp4a.40.2\"' />\n");
echo(" <source src=\"".$row['webMPath']."\" type='video/webm; codecs=\"vp8, vorbis\"' />\n");
echo "
Your Browser does not support this video tag
<a href=".urlencode("https://www.google.com/chrome/index.html?hl=en&amp;brand=CHNG&amp;utm_source=en-hpp&amp;utm_medium=hpp&amp;utm_campaign=en")."> Dowload Chrome </a>
for the Best Views";
echo("</video>\n");
echo("<br />\n");
}
if ($row['site']=='Youtube') {
	echo("<div class=\"grid_12\"  id=\"VideoContainer\">\n");
echo("<h2> ".$row['VideoName']."</h2> \n");
$str =str_replace('&','&amp;',$row['mp4Path']);
$str=str_replace('frameborder="0" allowfullscreen','',$str);
$str=str_replace('<iframe width=','<iframe id="youtubeEmbed" width=',$str);
echo $str;

}

?>

<script type="text/javascript">
	<!--
	google_ad_client ="ca-pub-4475426569219871";
	/* Video Ads */
	google_ad_slot = "4140414938";
	google_ad_width = 468;
	google_ad_height = 60;
	//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
<script>
	//This is for IOS products
	//first detect IOS
	IS_IPAD = navigator.userAgent.match(/iPad/i) != null;
	IS_IPHONE = (navigator.userAgent.match(/iPhone/i) != null) || (navigator.userAgent.match(/iPod/i) != null);
	if (IS_IPAD || IS_IPHONE) {
		document.getElementById('youtubeEmbed').src = document.getElementById('youtubeEmbed').src.replace("\v\\", "\\embed\\");
	}
	//  So i am trying to us ajax with this assocronus thing to talk with server
	// I will also try and save the ip address
<?php

// this is for the video update for YOUTUBE videos
// for now if they stay on this page for more than 6 seconds it should count as a view
if ($row['site'] == 'local') {
	echo "var myvid = document.getElementById('Video');
var myvar = setInterval(function() {
if (myvid.currentTime > 5) {
//checkCookie();
AddRequest();
}
}, 1000);";
} elseif ($row['site'] == 'Youtube') {
	echo "$(document).ready(function(){
var myvid = document.getElementById('Video');
var myvar = setInterval(function() {
AddRequest();
}, 9000);

});";
}
?>
	function AddRequest()
{
xmlhttp=new XMLHttpRequest();
xmlhttp.open("GET","/includes/viewcount.php?videoID=<?php echo $hash; ?>
	",true);
	xmlhttp.send();

	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	document.getElementById("viewcount").innerHTML=xmlhttp.responseText;
	clearInterval(myvar);
	}
	}

	}
</script>
<!-- Place this tag where you want the +1 button to render. -->

<?php
if (ex_query1RowAns("select 1 from video where Hash='" . $_GET['videoID'] . "'") == "1") {
	include_once ("includes/BottemVideoPanel.php");
}
?>
<?php

//add favorites function already exists maybe a button or link That runs without reloading the page.
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