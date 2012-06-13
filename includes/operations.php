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
        addToFavorites($_SESSION['User_ID'],$_GET['videoID']);
        redirect_to("../view.php?videoID={$_GET['videoID']}");
    }
    elseif($_GET['fav']==0){removeFromFavorites($_SESSION['User_ID'],$_GET['videoID']);
        redirect_to("../view.php?videoID={$_GET['videoID']}");
    }
}
elseif(isset($_GET['liked']))
{
    if($_GET['liked']==1)
    {
        //Insert into db 
        LikeVideo($_SESSION['User_ID'],GetVideoID($_GET['videoID']));
        redirect_to("../view.php?videoID={$_GET['videoID']}");
    }
    elseif($_GET['fav']==0){
        unLikeVideo($_SESSION['User_ID'],GetVideoID($_GET['videoID']));
        redirect_to("../view.php?videoID={$_GET['videoID']}");
    }
}
elseif(isset($_GET['reported']))
{
    if($_GET['reported']==1)
    {
        //Insert into db 
        reportVideo($_SESSION['User_ID'],GetVideoID($_GET['videoID']));
        redirect_to("../view.php?videoID={$_GET['videoID']}");
    }
    elseif($_GET['fav']==0){
        unReportVideo($_SESSION['User_ID'],GetVideoID($_GET['videoID']));
        redirect_to("../view.php?videoID={$_GET['videoID']}");
    }
}
elseif (isset($_GET['delete'])) {
	echo" Oh man is this sooo deleted";
}

?>