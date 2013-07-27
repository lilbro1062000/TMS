<?php
    require_once ("connection.php");
    require_once ("functions.php");
	require_once("aws.php");
//Works now i need to add some security file size and type (standard right now is 50mb) mine type
// extension
//use ffmpeg for conversion
 //Move file
//change the encoding to mp4 and webdm
// and save the files to amazon bucket after processes and save the file names in a DB as well
// people have to know who uploaded the video
define("UPLOAD_DIR", "..\\\\amazonaws\\\\Bucket\\\\");

//var_dump($GLOBALS);
//exit;

if (!empty($_POST["html5_uploader_count"]) && $_POST["html5_uploader_count"]==1)
{
   
    if ($_POST["html5_uploader_0_status"]=="done")
    { //ensure a safe filename

        $name = preg_replace("/[^A-Z0-9._-]/i", "_", $_POST["html5_uploader_0_name"]);
		$tmpname =$_POST["html5_uploader_0_tmpname"];       
        		
        $query = "INSERT INTO jobs (Progress ,tempname,name ,VideoName,UserID) VALUES (";
		$query .="'NotStarted','".$tmpname."','".$name."','".mysql_real_escape_string($_POST["VideoName"])."',{$_SESSION[SESSIONUSERID]})";
		
        ex_query($query);

		echo("<!DOCTYPE HTML>\n <html>\n<head> <script>\nfunction delayer()\n{\nwindow.location =\"../profile.php\" ;\n}
		\n</script> </head>\n
		\n<body onload=\"setTimeout(delayer(),5000)\">
		\n");
		    
		echo ("UPload Completed You will be redirected to the Video in 5 seconds (Work in progress) \n");
		         
		echo("</body>\n</html>");       
    } 
    else
    {
        //echo("<!DOCTYPE HTML>\n <html>\n<head> <script>\nfunction delayer()\n{\nwindow.location =\" ../error.php?errorid=1\";\n}\n</script> </head>\n\n<body onload=\"setTimeout(delayer(),50000)\">\n");
         
		//echo("</body>\n</html>");

    }
   
}
else{
 header("location: ../index.php");
 }

?>