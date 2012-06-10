<?php
include_once ("includes/session.php");
Logged_in();

if (isset($_POST['Keywords'])) {
	include_once ("includes/session.php");
	Logged_in();
	require_once ("includes/connection.php");
	require_once ("includes/functions.php");
		$vidID= GetVideoID($_GET['id']);
		//delete all the categories 
		$query="delete from videocatinfo where hash ='{$_GET['id']}'";
		ex_query($query);
		
	//Insert Catagory
	$results = ex_query("Select upper(Name) from categories order by ID");

	while ($row = mysql_fetch_array($results)) {
		
		//reinsert
		if (isset($_POST[$row[0]])) {
			if ($_POST[$row[0]] == "on") {
				//check to see if the category exists already
				$checkQuery = "Select 1 from videocatinfo where hash ='{$_GET['id']}' and Category ='{$row[0]}'";

				if (ex_query1RowAns($checkQuery) != 1) {
					// inset the category into the Database
					$query = "Insert into videocatinfo(hash,Category) Values('" . $_GET['id'] . "','" . $row[0] . "')";
					ex_query($query);
				}
			} 
		}
		//Insert Description
		$desc = check_input($_POST['Desc']);
		$desc = preg_replace("/[^A-Z0-9._-]/i", " ", $desc);

		$query = "delete from videodesc where VidID =" . $vidID;
		ex_query($query);
		
		$query = "Insert into videodesc(VidID,txtDesc) Values(" . $vidID . ",'" . $desc . "')";
		ex_query($query);
		

		//Insert Keywords
		$array = check_input($_POST['Keywords']);
		$array = explode(",", $array);
		//remove all keywords for video and re insert new ones
		// Delete
		$query = "delete from keywords where VideoID=" . $vidID;
		ex_query($query);

		for ($numCount = 0; $numCount < count($array); $numCount++) {

			$query = "Insert into keywords(VideoID,Keyword) Values('" . $vidID. "','" . $array[$numCount] . "')";
			ex_query($query);

		}
		//redirect_to("view.php?videoID=" . $_GET['id']);
		redirect_to("updatevid.php?videoID=" . $_GET['id']);
	}
}
elseif (isset($_GET['videoID'])) {
	require_once ("includes/connection.php");
	require_once ("includes/functions.php");
	if (!check("video", "hash", $_GET['videoID']))//
	{
		include_once ("includes/head.php");
		include_once ("includes/categories.php");
		// Populate the table based on informatioon in the table
		// So they should be able to update the information
	} else {
		header("location: index.php");
	}
	} 

else {
	var_dump($_POST);
	exit;
}
?>
<form class="grid_9" id="UpdateVideoForm" action="updatevid.php?id=<?php echo $_GET['videoID']; ?>" method="post">
	<label>Video Name:</label>
	<input type="text" name="VideoName" required="true" value="<?php
	$row = ex_query1Row("select videoName from video where hash =\"" . $_GET['videoID'] . "\"");
	echo($row[0]);
	?>" 
	disabled="True"/>
	<br />
	<input type="text" value="<?php echo($_GET['videoID']); ?>" name="hash" disabled="true"/><br />
<label> Catagories </label>
<br />
<?php
$results = ex_query("Select upper(Name) from categories order by ID");
while ($row = mysql_fetch_array($results)) {
	echo("
<input type=\"checkbox\" name=\"" . $row[0] . "\"");
	if (ex_query1RowAns('Select 1 from videocatinfo where Category=\'' . $row[0] . '\' and Hash=\'' . $_GET['videoID'] . '\'') == 1) {
		echo " checked=\"true\" ";
	}
	echo "/> \n";
	echo("<label>" . $row[0] . "</label>\n");
	echo("<br/>\n");
}
?>

<label>Video Description</label>
<textarea form="UpdateVideoForm" cols="29" rows="4" name="Desc" placeholder="PLease Enter Information" required="true"><?php
	$query = 'Select txtDesc from videodesc where VidID=' . GetVideoID($_GET['videoID']);
	$tmpdesc = ex_query1RowAns($query);
	if (isset($tmpdesc)) {
		echo $tmpdesc;
	}
?></textarea>
<br />
<label>Keywords Comma seperated </label>
<input type="text" name="Keywords" placeholder="Enter Keywords"
<?php
$query = 'Select 1 from keywords where VideoID=' . GetVideoID($_GET['videoID']);
if (ex_query1RowAns($query) == 1) {
	$query = 'Select Keyword from keywords where VideoID =' . GetVideoID($_GET['videoID']);

	$results = ex_query($query);
	$string = "";
	while ($row = mysql_fetch_array($results)) {
		$string .= "," . $row[0];
	}
	echo " value=\"";
	echo substr($string, 1, 1000) . "\" ";
}
?>
/>

<input type="submit" name="submit" value="Submit" required="true" />
</form>

<?php
include_once ("includes/foot.php");
?>