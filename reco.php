<?php
include_once ("includes/head.php");
include_once ("includes/categories.php");
?>

<div id="messageToList" class="grid_4">
	<?php
	//$query="Select * from messages where to =".$_SESSION[SESSIONUSERID];

	//show all messages to this person
	?>
</div>

<div id="Messageoutput" class="grid_5">
	<?php
	//Show message contents
	?>
	<?php
	if (isset($_POST['Textarea'])) 
	{
		require_once ("phpmailer/class.phpmailer.php");
		$mail = new phpmailer();
		$mail->IsSendmail();
		$mail -> SetFrom("TMS@TMSomething.com",'Teach Me Something','');
		$mail -> AddAddress("lilbro1062000@gmail.com","Abdoulaye Camara");
		$mail -> Subject = "New recommandation";
		$mail -> Body = $_POST['Textarea'];
		if (!$mail -> Send()) 
		{
			// $msg = "Mailer Error: " . $mail -> ErrorInfo;
			$msg = "Sorry Seems it didnt go through. Please try again or send an EMail";
		}
		 else 
		{
			$msg = " *** Thanks for your recomendation";
		}
	}
	?>
</div>

<div class="grid_12" id="recom" style="height: 400px">

	<form method="post" action="/reco.php">
		<strong class="grid_12"> Recommendations for site </Strong>
		<?
			if (isset($msg)) {echo $msg . "\n";
			}
		?>
		<textarea name="Textarea" cols="114" rows="16"></textarea>
		<input type="submit" value="Submit" />
	</form>

</div>
<?php
include_once ("includes/foot.php");
?>