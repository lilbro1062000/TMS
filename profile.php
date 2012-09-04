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
		//if(belongs_to_person($_SESSION[SESSIONUSERID], $video))
		//{
			echo "<div class=\"grid_8\" id=\"Deletebox\">\n";
			echo "Are you sure you want to delete this video ?\n";
			echo "<form action=\"includes/operations.php?delete=$video\" method=\"post\">\n";
			echo "<input type=\"submit\" value=\"YES Delete!!!\"/>\n";
			echo "</form>\n";
			echo "<button type=\"button\" onclick=\"window.location.href=window.location.href\"> No Dont </button>\n";
			echo "</div>";	
		//}
	}
?>
<div id="userinfo" class="grid_6">
	<div id="Username">
		<?php
		 echo getUsername(
		   $_SESSION[SESSIONUSERID]
		 );
		 $email = ex_query1RowAns("Select Email from usersinfo where id ={$_SESSION[SESSIONUSERID]}");
		?>
	</div>
	<script>
	$(document).ready(function(){
	var $dialog = $('<div></div>')
		.html('<iframe height="600" width="600" src ="http://<?php 
			echo $_SERVER["HTTP_HOST"];
			?>/TMS
			/includes/verify.php?email=
			<?php
			echo $email;
			echo "&";
			echo "hash=".generateHash();
			?>"></iframe>')
		.dialog({
			autoOpen: false,
			title: 'Verify Email',
			width: 600,
			height: 600
			
		});
			
			
			$("#VerifyEmail").click(function() {
				 $dialog.dialog('open');
				//so i need to create a verification page 
				
		});
			});
	</script>
	<div>
		Validate Email: 
		<form>
			<?php
			
			echo $email;
			?>
			<p>
				<?php
				$verified = ex_query1RowAns("select VerifiedEmail from usersinfo where id ={$_SESSION[SESSIONUSERID]}");
				if($verified==1)
				{
					echo "<button> Verified</button>";
				}
				else {
					//echo "<button> Verify Email</button>";
				}
				
				?>
			<a href="#" id="VerifyEmail"> Verify Email</a>
			</p>
			<?php
			//if verified you cant change you email
			// what if you lose access 
			//true point then what 
			// well every email must be verified 
			?>
			<p>
				<input />
			<button> Change Email</button>
			</p>
		</form>
	</div>
	<div id="numberofVideos" class="grid_6">
		Number of Videos Uploaded:
		<?php
		 echo getnumVideosUploaded(
		  $_SESSION[SESSIONUSERID]
		 );
		?>
	</div>
	
</div>


<script>
	$(document).ready(function() {
		$("#RefreshPage").load("includes/videoloadcontent.php");
		var refreshid = setInterval(function() {
			$("#RefreshPage").load("includes/videoloadcontent.php");
		}, 1000);
	})
</script>
<div id="RefreshPage" class="grid_12">

</div>

<?php
include_once ("includes/foot.php");
?>