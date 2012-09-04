<?php
require_once("session.php");
Logged_in();
require_once ("connection.php");
require_once ("functions.php");

if(isset($_GET['fav']))
{
    if($_GET['fav']==1)
    {
        //Insert into db 
        addToFavorites($_SESSION[SESSIONUSERID],$_GET['videoID']);
        redirect_to("../view.php?videoID={$_GET['videoID']}");
    }
    elseif($_GET['fav']==0){removeFromFavorites($_SESSION[SESSIONUSERID],$_GET['videoID']);
        redirect_to("../view.php?videoID={$_GET['videoID']}");
    }
}
elseif(isset($_GET['liked']))
{
    if($_GET['liked']==1)
    {
        //Insert into db 
        LikeVideo($_SESSION[SESSIONUSERID],GetVideoID($_GET['videoID']));
        redirect_to("../view.php?videoID={$_GET['videoID']}");
    }
    elseif($_GET['fav']==0){
        unLikeVideo($_SESSION[SESSIONUSERID],GetVideoID($_GET['videoID']));
        redirect_to("../view.php?videoID={$_GET['videoID']}");
    }
}
elseif(isset($_GET['reported']))
{
    if($_GET['reported']==1)
    {
        //Insert into db 
        reportVideo($_SESSION[SESSIONUSERID],GetVideoID($_GET['videoID']));
        redirect_to("../view.php?videoID={$_GET['videoID']}");
    }
    elseif($_GET['reported']==0){
        unReportVideo($_SESSION[SESSIONUSERID],GetVideoID($_GET['videoID']));
        redirect_to("../view.php?videoID={$_GET['videoID']}");
    }
}
elseif (isset($_GET['delete'])) {
require_once ('aws.php');
	 //THere are alot of stuff to delete from first 
	 //from comments 
	 $hash = $_GET['delete'];
	 $videoID = GetVideoID($hash);
		
	 $query ="delete from comments where VideoID=".$videoID;
	 ex_query($query);
	 echo "deleting from comments \n";
	 //delete from favorites 
	 $query= "delete from favorites where VideoID='{$hash}'";
	 ex_query($query);
	 echo "deleting from history\n";
	 //delete from  history
	 $query ="delete from  history where VideoID='{$hash}'"; 
	 ex_query($query);
	 echo "deleting from keywords\n";
	 //delete from keywords
	 $query ="delete from keywords where VideoID=".$videoID;
	 ex_query($query);
	 echo "deleting from like\n";
	 //delete from liked table 
	 $query="delete from liked where videoid=".$videoID;
	 ex_query($query);
	 echo "deleting from reportedvideo\n";
	 //delete from reportedvideo
	 $query ="delete from reportedvideo where VideoID=".$videoID;
	 ex_query($query);
	 echo "deleting from videoCatinfo\n";
	 //delete from videocatinfo
	 $query = "delete from  videocatinfo where Hash='{$hash}'";
	 ex_query($query);
	 echo "deleting from videodesc\n";
	 //delete from videodesc
	 $query ="delete from videodesc where VidID=".$videoID;
	 ex_query($query);
	 echo "deleting from views\n";
	 //delete from views
	 $query ="delete from views where Video_ID=".$videoID;
	 ex_query($query);
	 echo "deleting from jobs\n";
	 //delete from jobs 
	 $query = "delete from jobs where Progress ='{$hash}'";
	 ex_query($query);
	 echo "deleting from aws\n";
	 $query= "select mp4Path,webMPath,videoImage from video where Hash='{$hash}' and ID=".$videoID;
	 $row = ex_query1Row($query);
	 
	 echo "deleting mp4path\n ";
	 Delete_from_bucket($row[0]);
	 echo "deleting from webMpath\n";
	 Delete_from_bucket($row[1]);
	 echo "deleting from VideoImage\n";
	 Delete_from_bucket($row[2]);
	
	 echo "deleting from video\n";
	 $query= "delete from video where Hash='{$hash}' and ID=".$videoID;
	 ex_query($query);
	 
	 redirect_to("../profile.php");
}
elseif (isset($_GET['changeEmail'])) {
	
}

?>