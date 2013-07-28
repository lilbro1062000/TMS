<?php
    require_once ("includes/connection.php");
    require_once ("includes/functions.php");

if (isset($_POST['Keywords'])) {

	$vidID = GetVideoID($_GET['id']);
	//delete all the categories
	$query = "delete from videocatinfo where hash ='{$_GET['id']}'";
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
					// insert the category into the Database
					// select the number from the categories
					$row[0] = ex_query1RowAns("SELECT FROM  `categories` ");
					// also ill have to create the
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

			$query = "Insert into keywords(VideoID,Keyword) Values('" . $vidID . "','" . $array[$numCount] . "')";
			ex_query($query);

		}
		//redirect_to("view.php?videoID=" . $_GET['id']);
		javascriptRedirect("updatevid.php?fb=1&videoID=" . $_GET['id']);
	}
} elseif (isset($_GET['videoID'])) {
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
} else {
	//var_dump($_POST); //for errors checking
	exit ;
}
?>
<form class="grid_9" id="UpdateVideoForm" action="/updatevid.php?id=<?php echo $_GET['videoID']; ?>" method="post">
	<label>Video Name:</label>
	<input type="text" name="VideoName" required="true" value="<?php
	$row = ex_query1Row("select videoName from video where hash =\"" . $_GET['videoID'] . "\"");
	echo($row[0]);
	?>
	"
	disabled="True"/>
	<br />
	<input type="text" value="<?php echo($_GET['videoID']); ?>" name="hash" disabled="true"/>
	<br />
	<h3>Select Categories</h3>
	<label> Catagories </label>
		<?php
		// has to be changed so that it returns a web of materials so that when somebody click on something they can click all that apply
		// or auto click
		// first find out how the html would work.
		// I would get all of them and output those's by a list of check marks in a horizontal fashion
		// I want to make them Ordered by wether or not its nested


		function getCategories($categoryID) {
			// first display category
			$query = "Select ID, Name from categories where PrevName='$categoryID'";
			$results = ex_query($query);
			$tog = 0;
			 while ($myrow = mysql_fetch_array($results)) {
					$tog = 1;
				if ($tog == 1) {
					echo "<ul>";
					$tog = 3;
				}
				 echo "<li><input type=\"checkbox\" name=\"" . $myrow['Name'] . "\"";
				 if (ex_query1RowAns('Select 1 from videocatinfo where upper(Category)=Upper(\'' . $myrow['ID'] . '\') and Upper(Hash=\'' . $_GET['videoID'] . '\')') == 1) {
					 echo " checked=\"true\" ";
				 }
				 echo "/><label> " . $myrow['Name'] . "</label></li>\n";
				 If (ex_query1Row("Select 1 from categories where PrevName='" . $myrow['ID'] . "'") ==1) {
					 getCategories($myrow['ID']);
				 }

			 }
			if ($tog == 3) {
				echo "</ul>";
			}
			// Then
		}


		$results = ex_query("Select * from categories where PrevName = 'NULL' ");
		echo("<ul>");
		while ($row = mysql_fetch_array($results)) {
			echo("
		<li>\n<div class=\"form\"> <input type=\"checkbox\" name=\"" . $row['Name'] . "\"");
			if (ex_query1RowAns('Select 1 from videocatinfo where Category=\'' . $row['ID'] . '\' and Hash=\'' . $_GET['videoID'] . '\'') == 1) {
				echo " checked=\"true\" ";
			}
			echo "/> \n";
			echo("<label>" . $row['Name'] . "</label>\n");
			echo("<br/>");
			getCategories($row['ID']);
			echo "</div>\n</li>\n";
		}
		echo("</ul>");
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
	<input type="text" name="Keywords" placeholder="Enter Keywords" required="true"
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
	<?php
	if (isset($_GET['fb'])) {
		echo "\nVideo Updated!!<br />\n";
		echo "<a href='view.php?videoID=" . $_GET['videoID'] . "'>watch video</a> or ...\n";
	} else {
		echo "<input type=\"submit\" name=\"submit\" value=\"Submit\" required=\"true\" />\n";
	}
	?>
</form>
<div class="grid_9">
	<?php
	if (isset($_GET['fb'])) {
		echo("<div id='fb-root'></div>\n
<script src='http://connect.facebook.net/en_US/all.js'></script>\n
<p><a href='' onclick='postToFeed(); return false;'>Post video to Feed</a><img src=\"/images/Facebook-32.png\"  width = 20 height = 20 alt=\"Logged in Via Facebook\" /> </p>\n
<p id='msg'></p>\n
<script> \n
FB.init({appId: " . FB_APP_ID . ", status: true, cookie: true});\n
\n
function postToFeed() {\n
var obj = {\n
method: 'feed',\n
link: '" . $_SERVER["HTTP_HOST"] . "/view.php?videoID=" . $_GET['videoID'] . "',\n
picture: '" . ex_query1RowAns("Select videoImage from video where Hash='" . $_GET['videoID'] . "'") . " ',\n
name: '" . ex_query1RowAns("select videoName from video where hash =\"" . $_GET['videoID'] . "\"") . "',\n
caption: 'Watch This Video',\n
description: '" . ex_query1RowAns('Select txtDesc from videodesc where VidID=' . GetVideoID($_GET['videoID'])) . "'\n
};\n
\n
function callback(response) {\n
document.getElementById('msg').innerHTML = \" Video Posted\";\n
}\n
\n
FB.ui(obj, callback);\n
}\n
\n
</script>\n");

	}
	?>
</div>
<?php
include_once ("includes/foot.php");
?>