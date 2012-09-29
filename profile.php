<?php

//i need to add notification check for change email 
//check log in
include_once ("includes/session.php");
 Logged_in();
include_once ("includes/head.php");
include_once ("includes/categories.php");
//Option to edit profile

//
?>



<?php
if(isset($_POST['ChangeEmail']))
{
	// add change Email Post 
	// just query 
	//and update verified information
	$email =$_POST['ChangeEmail']; 
	
	$query = "Update usersinfo set Email=\"$email\",VerifiedEmail =  '0' where ID={$_SESSION[SESSIONUSERID]} ";
	ex_query($query);
	$query = "Insert into notifications(dtmessage,type,userid,msg,visible) Value(";
	$query .="'".to_mysqlDate(time())."'";
	$query .= ",'Verify','".$_SESSION[SESSIONUSERID]."','Hey your email has not been verified looks like we can\'t pay you.!!! So Please <a href=\"profile.php\">Verifiy</a>','1')";
	ex_query($query);
	//some sort of alert to tell you that it has been changed 
	
	echo "<script>
	$(document).ready(function(){
		var $dialog = $('<div></div>')
		.html('Email Added Please Verify the EMail on Profile Page')
		.dialog({
			autoOpen: true,
			title: 'Basic Dialog'
		});
		
	});
</script>";
	
	
}
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
		 echo "<br/>";
		 $email = ex_query1RowAns("Select Email from usersinfo where id ={$_SESSION[SESSIONUSERID]}");
		?>
	</div>
	<script>
	$(document).ready(function(){
	var $dialog = $('<div class ="modal"><\/div>')
		.dialog({
			autoOpen: false,
			title: 'Verify Email',
			width: 600,
			height: 600,
			buttons: {
				"Ok": function() {	
						$(this).dialog("close");
							},
				"Cancel": function() {	
							$(this).dialog("close");
						}
					}
			
		});
			
			
			$("#VerifyEmail").click(function() {
			$dialog.html('Please wait till a message pops up for Validation <iframe height="600" width="600" src ="http://<?php 
			echo $_SERVER["HTTP_HOST"];
			?>/includes/verify.php?email=<?php
			echo $email;
			echo "&";
			echo "hash=".generateHash();
			?>"><\/iframe>')
				 $dialog.dialog('open');
				//so i need to create a verification page 
				
		});
			});
	</script>
	<div>
		Validate Email: 
		<form method="post">
			<?php
			
			echo $email;
			?>
			<p>
				<?php
				$verified = ex_query1RowAns("select VerifiedEmail from usersinfo where id ={$_SESSION[SESSIONUSERID]}");
				if($verified==1)
				{
					echo "<a href=\"#\" id=\"Verified\"> Verified </a>";
				}
				else {
					echo "<a href=\"#\" id=\"VerifyEmail\"> Verify Email</a>";
				}
				
				?>
			
			</p>
			<?php
			//if verified you cant change you email
			// what if you lose access 
			//true point then what 
			// well every email must be verified 
			?>
			<p>
				<input name="ChangeEmail" type="email"  id="ChangeEmail" required="true" placeholder="<?php
			
			echo $email;
			?>" />
			<button type="submit" > Change Email</button>
			
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
	<div class="grid_9">
		PLease note it may take up to 24 hours for your Video to be uploaded. IF it take longer please Email us At Admin@tmsomething.com
		
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