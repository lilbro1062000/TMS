<?php
include_once ("includes/head.php");
include_once ("includes/categories.php");
?>

<div id="messageToList" class="grid_4">
<?php 
$query="Select * from messages where to =".$_SESSION[SESSIONUSERID];
	
//show all messages to this person 
?>
</div>

<div id="messageToList" class="grid_4">
<?php
$query="Select * from messages where from =".$_SESSION[SESSIONUSERID];
//SHow all sent messages seperate 

?>
</div>

<div id="Messageoutput" class="grid_5">
<?php
//Show message contents

?>
<?php 
if(isset($_POST['Textarea']))
{
	
require_once("phpmailer/phpmailer.inc.php");
$mail = new phpmailer();
$mail->FromName ="TeachmeSomething";
$mail->From="lilbro1062000@gmail.com";
$mail->AddAddress("lilbro1062000@aol.com");
$mail->Subject ="New recommandation";
$mail->Body =$_POST['Textarea'];
$result = $mail->Send();
$msg = "Thanks for your recomendation";
}
 ?>
</div>

<div class="grid_9" id="recom">
	
	<form method="post" action="reco.php">
		<label> Recommendations for site  </label>
		<? if(isset($msg))
		{echo $msg;}  ?>
		<textarea name="Textarea" cols="84" rows="18"></textarea>
		<input  type="submit" /> 	
	</form>
	
</div>
<?php
include_once ("includes/foot.php");
?>