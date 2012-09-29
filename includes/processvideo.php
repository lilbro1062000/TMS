<?php
require_once ("connection.php");
require_once ("functions.php");
require_once ("aws.php");
//so this is a cron job so i have to upload and change the status
// first thing is should do it run the cron job before i use this script
define("UPLOAD_DIR", "/tmp/uploads/process");

//var_dump($GLOBALS);
//exit;

//ensure a safe filename
// i have to generate a log for every video uploaded so that i could figure out what's happening. 
// what should i do
//get $post Variable and store it in a variable

$query = "Select ID,Progress,tempname,name,VideoName,UserID,Percentage from jobs where Progress ='NotStarted' Limit 0,1";
$row = ex_query1Row($query);

if (isset($row['ID'])) {
	
	function updatePercent($note, $percent, $rowID) {
		$query = "update jobs set Progress='{$note}' ,";
		$query .= "Percentage = {$percent} where ";
		$query .= "ID=" . $rowID;
		ex_query($query);
		echo $note . " " . $percent." ";
	}
	
	function ConvertToWebm($filepath)
{
	$ffmpeg="ffmpeg";
	$endPath = $filepath.".wbm";
	$command =$ffmpeg." -i ".$filepath." -b 1500k -vcodec libvpx -acodec libvorbis -ab 160000 -crf 22 -f webm -g 30 -s ".VideoHeighxWidth." ".$endPath;
	exec($command, $output);
	if(is_file($endPath))
	{
		echo $output;
		return $endPath;
	}
	else {
		echo "Convert To webm Faild";
		echo "<br />";
		echo $command;
		exit;
	}
	
}
function ConvertToMP4($filepath)
{
	$ffmpeg="ffmpeg";
	$endPath = $filepath.".MP4";
	$command =$ffmpeg." -i ".$filepath." -threads 0 -strict experimental -f mp4 -vcodec libx264 -vpre ipod640 -b 1200k -acodec aac -ab 160000 -ac 2 -s ".VideoHeighxWidth." ".$endPath; 
	exec($command, $output);
	if(is_file($endPath))
	{
		echo $output;
		return $endPath;
	}
	else {
		echo "Convert To MP4 Faild";
		echo "<br />";
		echo $command;
		exit;
	}
}

	//Change to Started status and change percentage to 1
	updatePercent("Started", 1, $row['ID']);
	$name = preg_replace("/[^A-Z0-9._-]/i", "_", $row['name']);
	$tmpname = $row['tempname'];

	//don't overwrite an existing file
	$i = 0;
	$parts = pathinfo($name);
	while (isInBucket($name . ".mp4")) {
		$i++;
		$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
		if (file_exists(UPLOAD_DIR . $name)) {
			$i++;
		}
		$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
	}
	updatePercent("Changing Name", 10, $row['ID']);
	//preserve file from temporary directory
	$path = UPLOAD_DIR . $name;
	$uniqeHash = genUhash();
	$success = copy('/tmp/uploads/' . $tmpname, $path);
	if (!$success) {
		echo "<p> Unable to save File.</p>";
		exit ;
	}
	//removes tmp file from folder
	unlink('/tmp/uploads/' . $tmpname);
	updatePercent("removing weird things in the video", 15, $row['ID']);

	chmod(UPLOAD_DIR . $name, 0644);
	//Mp4 Generation
	$mp4_filepath = ConvertToMP4($path);
	//webm generation
	updatePercent("adding  multiplayer support", 30, $row['ID']);
	$webM_filepath = ConvertToWebm($path);
	//image Genreation
	updatePercent("removing multiplayer support", 40, $row['ID']);

	$imgpath = $path . "_Thumbnail.jpeg";
	generateImage($path, $imgpath);
	updatePercent("Generating SplashImage", 60, $row['ID']);

	$mp4URI = Insert_into_bucket($mp4_filepath, $name . ".mp4");
	updatePercent("adding Aliens", 69, $row['ID']);
	$webmURI = Insert_into_bucket($webM_filepath, $name . ".webm", 'video/webm');
	updatePercent("Converting to First Person", 70, $row['ID']);

	$imageURI = Insert_into_bucket($imgpath, $name . ".jpg", 'image/jpeg');
	updatePercent("ok Second Person", 80, $row['ID']);
	$query = "update jobs set Progress='ok Second Person' , Percentage = 80 where ID=" . $row['ID'];
	ex_query($query);
	// Remove everything from aws bucket folder
	unlink($mp4_filepath);
	unlink($webM_filepath);
	unlink($imgpath);
	unlink($path);
	updatePercent("fine you can have your video back", 90, $row['ID']);

	//WHich is UNlink Im going to watch the video
	//Store in DB and Get ID Store mp4 Store webm

	//change DB to push both
	$query = "INSERT INTO video (VideoName ,mp4Path,webMPath ,Hash,videoImage,UserID,dtuploaded) VALUES (";
	$query .= "'" . check_input($row['VideoName']) . "', '" . $mp4URI . "','" . $webmURI . "','" . $uniqeHash . "','" . $imageURI . "',{$row['UserID']}".",'".to_mysqlDate(time())."')";

	ex_query($query);
	$vidID = ex_query1RowAns("Select id from video where hash='{$uniqeHash}'");
	ex_query("insert into views(video_ID, Numwatched) Values({$vidID},0)");
	updatePercent("Done", 100, $row['ID']);
	updatePercent($uniqeHash, 100, $row['ID']);
} else {
	echo "No FIles to change";
}
?>