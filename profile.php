<?php
//check log in
include_once ("includes/session.php");
Logged_in();
include_once ("includes/head.php");
include_once ("includes/categories.php");
//Option to edit profile

//
?>

<?php
	if (isset($_POST['delete'])) {
		//todo add validation that this persson's session is the one able to delete videos
		
		$video = $_POST['delete'];
		if(belongs_to_person($_SESSION[SESSIONUSERID], $video))
		{
			echo "<div class=\"grid_8\" id=\"Deletebox\">\n";
			echo "Are you sure you want to delete this video ?\n";
			echo "<form action=\"includes/operations.php?delete=$video\" method=\"post\">\n";
			echo "<input type=\"submit\" value=\"YES Delete!!!\"/>\n";
			echo "</form>\n";
			echo "<button type=\"button\" onclick=\"window.location.href=window.location.href\"> No Dont </button>\n";
			echo "</div>";	
		}
	}
?>
<div id="userinfo" class="grid_6">
	<div id="Username">
		<?php
		echo getUsername($_SESSION[SESSIONUSERID]);
		?>
	</div>
	<div id="numberofVideos" >
		Number of Videos Uploaded:
		<?php
		echo getnumVideosUploaded($_SESSION[SESSIONUSERID]);
		?>
	</div>
	<div id="NumberOfComments">
		Number of Comments posted:
		<?php
		echo NumberofComments($_SESSION[SESSIONUSERID]);
		?>
	</div>
	<div id="UserDescrpt">
		Status:
		<?php
		echo GetDescofUser($_SESSION[SESSIONUSERID]);
		?>
	</div>

</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script>
	$(document).ready(function() {
		$("#RefreshPage").load("includes/videoloadcontent.php");
		var refreshid = setInterval(function() {
			$("#RefreshPage").load("includes/videoloadcontent.php");

		}, 5000);
	})
</script>
<div id="RefreshPage">

</div>

<?php
include_once ("includes/foot.php");
?>