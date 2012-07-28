<?php
require_once ("connection.php");
require_once ("functions.php");
require_once ("FB.php");

if($_SERVER['HTTP_HOST']!="www.tmsomething.com")
{
	header("location: http://www.tmsomething.com");
}

// if($_SERVER['HTTP_HOST']!="127.0.1.1")
// {
	// header("location: http://127.0.1.1/TMS/");
// }
?>
<?php
// this is to check the video
if (isset($_COOKIE['VideoCount'])) {
	$vidID = $_COOKIE['VideoCount'];

	// Updated Video view count
	if (videoExists($vidID)) {

		$query = "Update views set Numwatched = Numwatched+1 where video_id=" . GetVideoID($vidID);
		ex_query($query);
	}

	//remove cookie'
	setcookie("VideoCount", "", time() - 3600);
	unset($_COOKIE['VideoCount']);
}
//if logged in via Session  Then dont check the Is FB logged in

if (!isSitelogin()) {

	if (isFBLoggedin()) {
		// if logged in then check db for user info
		if (!isSitelogin()) {

			if (!fbUserExists()) {
				createFBUser();
			}
			//start session with that user
			login(GetFBUserID(), GetFBUserName());
		}
		//if non exists then create one
		//That id will be use for video Uploads as well for video count
		// dont forget for user creation
	}

}
if (!isFBLoggedin() && isSitelogin()) {
	loggout();
}
?>
<!DOCTYPE HTML>
<html lang="en" >
	<head>
		<title>Teach Me Something</title>
		<meta name="google-site-verification" content="dc14ttAF-hCGX-dzG26c15mdK7HlzLG3V7x4wsXv6zo" />
		<!-- Style sheets added by Abdoulaye Camara  -->
		<link href="stylesheets/reset.css" rel="stylesheet" type="text/css" />
		<link href="stylesheets/960.css" rel="stylesheet" type="text/css" />
		<link href="stylesheets/Style.css" rel="stylesheet" type="text/css" />
		
	</head>
	<body class="container_12">
<div id="headmenu">
	
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33378653-1']);
  _gaq.push(['_setDomainName', 'tmsomething.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
			<!--Facebook Stuff-->
		<div id="fb-root"></div>
		<script>
						window.fbAsyncInit = function() {
FB.init({
appId      : '<?php echo FB_APP_ID; ?>
	'
	, // App ID
	channelUrl : '<?php echo($_SERVER["HTTP_HOST"])?>/infomatica.html', // Channel File
status     : true, // check login status
cookie     : true, // enable cookies to allow the server to access the session
xfbml      : true  // parse XFBML
});

// Additional initialization code here
};

// Load the SDK Asynchronously
(function(d){
var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
if (d.getElementById(id)) {return;}
js = d.createElement('script'); js.id = id; js.async = true;
js.src = "//connect.facebook.net/en_US/all.js";
ref.parentNode.insertBefore(js, ref);
}(document));
		</script>
<!--End Facebook Stuff-->
<a href="index.php" > <img src="images/website_Layout.png"  alt="Teach ME Something" class="grid_3"/> </a>
<form class="grid_6" action="search.php" method="get" enctype="multipart/form-data">
	<input type="text" placeholder="Cool" class="grid_4" name="Search"/>
	<input type="submit" value="Search" class="grid_1" />
</form>

<ul  class="grid_3">
	<?php
	$results = ex_query("Select * from header_menu order by ID asc;");
	while ($row = mysql_fetch_array($results)) {
		if ($row[1] == "Login" && isFBLoggedin()) {
			echo("<li class=\"NavMenu\"> <a href=\"login.php?msg=4\">logout</a></li>\n");
		} 
		else if ($row[1] == "SignUp" && isFBLoggedin()) {
			
		}
		else if ($row[1]== "SignUp" && !isFBLoggedin())
		{
			echo("<li class=\"NavMenu\"> <a href=\"login.php?msg=3\">SignUp</a></li>\n");
		}
		else {
			echo("<li class=\"NavMenu\"><a href=\"" . $row[2] . "\">" . $row[1] . "</a></li>\n");
		}

	}
	?>
</ul>
<!-- <img src=\"images/Facebook-32.png\"  width = 15 height = 15 alt=\"Logged in Via Facebook\" /> -->
<?php
if (isFBLoggedin()) {
	echo("
<div id=\"user_menu\" class=\"grid_12\">\n");
	echo("<ul>\n");
	$results = ex_query("Select * from user_menu order by ID asc;");
	echo("<li> <img src=\"images/Facebook-32.png\"  width = 20 height = 20 alt=\"Logged in Via Facebook\" />  <a href=\"profile.php\">" . $_SESSION[SESSIONUSERNAME] . " </a></li>\n");
	while ($row = mysql_fetch_array($results)) {

		echo("<li><a href=\"" . $row['Path'] . "\">" . $row['Name'] . "</a></li>\n");

	}
	echo("</ul>\n");
	echo("</div>\n");
}
?>

</div>
