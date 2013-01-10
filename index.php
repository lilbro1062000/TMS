<?php
include_once ("includes/head.php");
include_once ("includes/categories.php");
?>
<!-- <div id="fb-root"></div>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=453077271378502";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script> -->
<!-- <div id="mainPage" class="grid_12"> -->
	<!-- <img src="/images/Mark-Fletcher-Haleakala-960x900.jpg" width="940"/> -->
	
	<?php 
	// show a random video 
	// first list all videos you have in an array 
	
	$query = "Select id from video";
	$results= ex_query($query);
	$count =0;
	$arrayName =array(0=>0);
	 while($row = mysql_fetch_array($results))
			    {
					$arrayName[$count] =$row[0];	
					$count++;				    
			    }
	
	$vid = rand(0, $count);
	while (empty($arrayName[$vid])) {
		$vid = rand(0, $count);
		
	}
	$query ='select Hash from video where id='.$arrayName[$vid];

	
	$hash =ex_query1RowAns($query);    
$row = ex_query1Row("select * from video where hash =\"".$hash."\"");


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
$str=str_replace('<frame width=','<frame id="youtubeEmbed" width=',$str);
echo $str;
}

?>
<!-- </div> -->
<script>

IS_IPAD = navigator.userAgent.match(/iPad/i) != null;
IS_IPHONE = (navigator.userAgent.match(/iPhone/i) != null) || (navigator.userAgent.match(/iPod/i) != null);
if (IS_IPAD || IS_IPHONE) {
  document.getElementById('youtubeEmbed').src = document.getElementById('youtubeEmbed').src.replace("\v\\","\\embed\\") ;
} 
<?php
// this is for the video update for YOUTUBE videos 
// for now if they stay on this page for more than 6 seconds it should count as a view 
if ($row['site']=='local') {
	echo "var myvid = document.getElementById('Video');
	var myvar = setInterval(function() {		
		if (myvid.currentTime > 5) {
			//checkCookie();
			AddRequest();
		}
	}, 1000);";
} elseif ($row['site']=='Youtube') {
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
		xmlhttp.open("GET","/includes/viewcount.php?videoID=<?php echo $hash; ?>",true);
		xmlhttp.send();
		
		xmlhttp.onreadystatechange=function()
  			{
  				if (xmlhttp.readyState==4 && xmlhttp.status==200)
    				{
    					//document.getElementById("viewcount").innerHTML=xmlhttp.responseText;
    					clearInterval(myvar);
 				  }
  }

	}
</script>
<div  class="grid_5">
	<div id= "side1" class="fb-activity" data-site="www.tmsomething.com" data-app-id="<?php echo FB_APP_ID; ?>" data-width="440" data-height="390" data-header="true" data-recommendations="false"></div>
</div>
<div id= "side2" class="grid_5">
	 <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'search',
  search: '#TMSomething OR @TMSomething',
  interval: 10000,
  title: 'TMSomething',
  subject: 'Teach Me Something ',
  width: 440,
  height: 300,
  theme: {
    shell: {
      background: 'Orange',
      color: '#ffffff'
    },
    tweets: {
      background: '#ffffff',
      color: '#444444',
      links: '#1985b5'
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: true,
    behavior: 'default'
  }
}).render().start();
</script>
	 
</div>
<?php
echo "</div>";
include_once ("includes/foot.php");
?>