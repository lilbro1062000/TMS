<?php
require_once ("connection.php");
require_once ("functions.php");
require_once ("FB.php");
?>

<?php

 if($_SERVER["SERVER_NAME"]!="www.tmsomething.com")
 {
	 //header('Location: http://www.tmsomething.com');

echo "<html><head>
<script type=\"text/JavaScript\">

setTimeout(\"location.href = 'http://www.tmsomething.com';\",1500);

</script>
</head><body>
Redirecting you to wwww.tmsomething.com ......
</body></html>";
 exit;	
 }
//if logged in via Session  Then don't check the Is FB logged in
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
			// Don't forget for user creation
		}
	
	}
	if (!isFBLoggedin() && isSitelogin()) {
		 loggout();
	}
	
//testing login

 if (!isSitelogin()) {
login('704520593', 'Abdoulaye Camara');
}
?>
<!DOCTYPE HTML>
<html lang="en" >
	<head>
		<title>Teach Me Something</title>
		<meta name="google-site-verification" content="dc14ttAF-hCGX-dzG26c15mdK7HlzLG3V7x4wsXv6zo" />
		<!-- Style sheets added by Abdoulaye Camara  -->
		
		<link href="/images/favicon.ico" rel="icon" type="image/x-icon" />
		<link href="/stylesheets/reset.css" rel="stylesheet" type="text/css" />
		<link href="/stylesheets/960.css" rel="stylesheet" type="text/css" />
		<link href="/stylesheets/Style.css" rel="stylesheet" type="text/css" />
		<link href="/stylesheets/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css"/>
		<link href="/stylesheets/video-js.css" rel="stylesheet">
		<script src="/js/video.js"></script>
		<script> 
		"use strict";
		</script>
		<script type="text/javascript">var it=document.createElement("img");var u="http://engine.adzerk.net/e/7597/e.gif";var t=new Date().getTime();var ut=u+"?_="+t;it.src=ut;it.border=0;
			</script>
		<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33378653-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' === document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>
<body class="container_12">
<div id="headmenu">

<script src="/js/jquery.min.js"></script>
<script src="/js/jquery-ui-1.8.23.custom.min.js"></script>
<script src="/js/jquery.cookie.js"></script>
<script src="/js/jquery.tools.min.js"></script>
 <script type="text/javascript">

		var p = "http", d = "static";
		if (document.location.protocol == "https:") {
		    p += "s";
		    d = "engine";
		}
		var z = document.createElement("script");
		z.type = "text/javascript";
		z.async = true;
		z.src = p + "://" + d + ".adzerk.net/ados.js";
		var s = document.getElementsByTagName("script")[0];
		s.parentNode.insertBefore(z,s);
</script>
		
<script type="text/javascript">
var ados = ados || {};
ados.run = ados.run || [];
ados.run.push(function() {
/* load placement for account: lilbro1062000, site: Teach Me Something, size: 728x90 - Leaderboard*/
ados_add_placement(3125, 17733, "azk43115", 4);
ados_load();
});
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
<a href="/index.php" > <img src="/images/website_Layout.png"  title="Teach ME Something" alt="Teach Me Something" class="grid_3"/> </a>
<form class="grid_6" action="search.php" method="get" enctype="multipart/form-data">
	<input type="text" placeholder="Cool" class="grid_4" name="Search"/>
	<input type="submit" value="Search" class="grid_1" />
</form>


<ul  class="grid_3">
	<?php
	$results = ex_query("Select * from header_menu order by ID asc;");
	while ($row = mysql_fetch_array($results)) {
		if ($row[1] == "Login" && isFBLoggedin()) {
			echo("<li class=\"NavMenu\"> <a href=\"/login.php?msg=4\">logout</a></li>\n");
		} 
		else if ($row[1] == "SignUp" && isFBLoggedin()) {
			
		}
		else if ($row[1]== "SignUp" && !isFBLoggedin())
		{
			echo("<li class=\"NavMenu\"> <a href=\"/login.php?msg=3\">SignUp</a></li>\n");
		}
		else {
			echo("<li class=\"NavMenu\"><a href=\"/" . $row[2] . "\">" . $row[1] . "</a></li>\n");
		}

	}
	?>
</ul>
<!-- <img src=\"images/Facebook-32.png\"  width = 15 height = 15 alt=\"Logged in Via Facebook\" /> -->
<?php
// if (isFBLoggedin()) //when ready removed because it takes to long 
if(isSitelogin())  // Testing
 {
	echo("
<div id=\"user_menu\" class=\"grid_12\">\n");
	echo("<ul>\n");
	$results = ex_query("Select * from user_menu order by ID asc;");
	// This is for money Calculations and it will compare to the db 
	// Name of Up loader 
	// Requested amount  This is would be the requested amount so far I would subtract the amount 
	// get # of views * .0008 $ Link to request amount  
	$SelectView = "Select sum(Numwatched) from views where Video_ID in (Select ID from video where UserID ='".$_SESSION[SESSIONUSERID]."')";
	$amount = ex_query1RowAns($SelectView) * .0008;
	//now i would need to subtract the information from the previous requested amounts 
	$prevPayments = ex_query1RowAns("Select sum(requested) from payments where UserID ='".$_SESSION[SESSIONUSERID]."'");
	if(!isset($prevPayments))
	{
		$prevPayments =0;
	}
	$amount = $amount-$prevPayments;
	if($amount<0.001)
	{
		$amount =0;
	}
	echo "\n<li><a href=\"#\" id=\"Amount\">$".$amount."</a></li>\n";
	//i need to make that a link so that when you click on it the screen dims and a pop
	//up shows up and then a button that says request 
	echo("<li> <img src=\"/images/Facebook-32.png\"  width = 20 height = 20 alt=\"Logged in Via Facebook\" />  <a href=\"/profile.php\">" . $_SESSION[SESSIONUSERNAME] . " </a></li>\n");
	while ($row = mysql_fetch_array($results)) {
		echo("<li><a href=\"/" . $row['Path'] . "\">" . $row['Name'] . "</a></li>\n");
	}
	echo("</ul>\n");
	echo("</div>\n");
}
?>

</div>
 <?php
 if(isSitelogin())
 {
 	
 
echo "<div id=\"dialog-confirm\" title=\"Dialog Title\">
<p> you have accumalted $";
echo $amount;
echo " dollars from videos."; 
echo "</p>
<p>
 Altogether you have " .ex_query1RowAns($SelectView)." Views.
</p>
";
if((time()-strtotime($mdate) ) >(60*60*24*30))
{
							echo "<p>
	You can request payments for your views. It will be sent to a paypall email address that is associated with you account.
	You must also verify your paypal email address. 
</p>";
}
else{
	echo "<p>
	You can request payments for your views 30 days after your first video upload.
</p>";
}
echo "<p>
	You must also have more then 0.10  in your account to request money. 
</p>";

echo "</div>

<script>
$(document).ready(function(){
$(\"#dialog-confirm\").hide();	

		$(\"#dialog-confirm\" ).dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						";
						$mdate = ex_query1RowAns("select min(dtuploaded) from video where UserID ='".$_SESSION[SESSIONUSERID]."'");
						if((time()-strtotime($mdate) ) >(60*60*24*30))
						{
							//first i would need to add the information and then send myself an email that the person requested their money 
							// How about verification email 
							// Maybe that should go into the info tab
							//commiting everything 
							if(ex_query1RowAns("select VerifiedEmail from usersinfo where ID=".$_SESSION[SESSIONUSERID]) ==1)
							{
								if ($amount >0.010) {
									
								
							echo "\"Request Payment\": \nfunction(){";	
							echo "\n$(\"#dialog-confirm\").html(' <p>Please wait...<\/p> <iframe height=\"600\" width=\"600\" src =\"http://"; 
			echo $_SERVER["HTTP_HOST"];
			echo "/includes/verify.php?requestpay=";
			echo urlencode($amount);
			echo "&amp;";
			echo "ID=".$_SESSION[SESSIONUSERID];
			echo "\"><\/iframe>');";
			
			echo "\n},";
								}
								else{
									echo "\"Not Enough Money\": \nfunction(){";
									
									echo "\n$(this).dialog(\"close\")},\n";
								}				
							}
							else {
								echo "\"Please Validate Email\": \nfunction() {";
								echo "\n$(this).dialog(\"close\")},\n";
							}
							
								
							
							
						}

						
						echo "\"close\": function() {
							
							$(this).dialog(\"close\");
						}
					}
				});


	$('#Amount').click(function() {
		$(\"#dialog-confirm\").dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
});
</script> 
";
}
?>
	<?php
	if(isSitelogin())
	{
$query ="Select * from notifications where userid=\"".$_SESSION[SESSIONUSERID]."\" and visible=1";
$results = ex_query($query);
$int =0;
while($row = mysql_fetch_array($results))
{
	//this is to create an id for every row 
	// first i should make the script 
	//then i should make the div tag 
	// two variables 1 script 	
	// the other would be html
	$int ++;
	$divid .= $row["type"].$int;
	$html  .= "\n <h3 class=\"".$divid."\"><a href=\"#\">".$row["type"]."</a></h3>\n";
	$html  .="\n<div class=\"".$divid."\"> <a id=\"{$divid}\" href=\"#\">Hide Me</a>.    ".$row["msg"]."  </div>\n";

	$script .="
	$(\"#$divid\").click(function(){

	if($.cookie(\"".$divid."\") == \"$divid\")
	{
		$(\"#$divid\").text(\"Hide Me\");
		$(\".$divid\").animate({
			width: \"100%\"
		},1500);
		$.cookie(\"".$divid."\", null);
}else{
	$(\".$divid\").animate({
			width: \"10%\"
		},1500);
		$(\"#$divid\").text(\"Show Me\");
	$.cookie(\"".$divid."\", \"".$divid."\", { expires: 365 });
}	});
	if($.cookie(\"".$divid."\") == \"$divid\")
	{
		$(\".$divid\").animate({
			width: \"10%\"
		},10);
		$(\"#$divid\").text(\"Show Me\");
	}";
	
	//now i need to get a cookie that would keep the alerts down 
	  }
	  }
	?>
	
<script>
	$(document).ready(function(){
		  $("#accordion").accordion();
		<?php
		echo $script; 
		?> 
	 });
	 
</script>
<div id="accordion">
    <?php
    echo $html;
    ?>
</div>

