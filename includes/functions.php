<?php
date_default_timezone_set('America/New_York');
require_once 'constants.php';
function GetuserIDfromEmail($email)
{
	$query =" Select ID from usersinfo where Email=\"".$email."\"";
	return ex_query1RowAns($query);
}
function login($User_ID,$Username)
{
	session_start();
	$_SESSION[SESSIONUSERID]=$User_ID;
    $_SESSION[SESSIONUSERNAME]=$Username;
}
function loggout()
{
    //removing all instance of session once logged out. 
    session_start();
    
    $_SESSION = array(); //empty session
    
    if(isset($_COOKIE[session_name()]))
    {
        setcookie(session_name(),'',time()-450000,'/');
    }
    
    session_destroy();
    
    redirect_to('login.php?logout=2');
}

function isSitelogin()
{
	if(isset($_SESSION[SESSIONUSERID]) && isset($_SESSION[SESSIONUSERNAME]))
	{
		return true;
	}
	else {
		return false;
	}
}
function videoExists($vidHash)
{
	$query = "select 1 from video where hash='$vidHash'";
	if(ex_query1RowAns($query)==1)
	{
		return true;
	}
	else {
		return false;
	}
}
function belongs_to_person($userID,$videoID)
{
	$query ="Select 1 from video where hash='{$videoID}' and UserID=".$userID;
	if(ex_query1RowAns($query)==1)
	{
		return true;
	}
	else {
		return false;
	}
}
function Cat_Pages($query,$phpFile,$Category)
{
				 $arrayName = array();
			  	$count =0;
			   	$results= ex_query($query);
			    while($row = mysql_fetch_array($results))
			    {
				    //var_dump($row);
					$arrayName[$count] = $row[0];	
					$count++;				    
			    }
				// Show pages links
			    $divider =7;
			    $NumPages =ceil((count($arrayName)/$divider));
				echo "<div class=\"grid_12\">\n";
				for ($i=0; $i < $NumPages; $i++) 
				{
					//create the links 
					// I am changing it to one string and echo'ing the string 
					// has the have the page for the limit  
					$VidsPerPage ="VidNum=".$divider;
					$string .="<a href=\"";
					$string .=$phpFile."?";
					$string .= "Category=".$Category;
					$string .='&Page=';
					$string .= ($i+1);
					$string .=("&".$VidsPerPage."\">");
					$string .= ($i+1 ."</a>\n");
					echo $string;
				}
				echo "</div>\n";
}
function GenMultipleThumb($results)
{
	$count=1;	
	//echo"<div id=\"mainPage\" class=\"grid_3\"  >";
	   while($row = mysql_fetch_array($results))
			    {
			    	if($count<7)
					{
					 GEnerateImageThumb($row[0]);	
					}
					$count++;
				}
	//echo ("</div>");
	return $count;
}
function LikeVideo($UserID, $videoID)
{
	$query = "insert into liked(videoID,UserID,Liked) values( '{$videoID}', '{$UserID}', 1)";
	ex_query($query);
	echo "$query";
}
function unLikeVideo($UserID, $videoID)
{
	$query = "delete from liked where UserID='{$UserID}' and videoID='{$videoID}',1)";
	ex_query($query);
}
function reportVideo($UserID, $videoID)
{
	$query = "insert into reportedvideo(UserID,VideoID,Reported) Values('{$UserID}','{$videoID}',1)";
	ex_query($query);
}
function unReportVideo($UserID, $videoID)
{
	$query = "delete from reportedvideo where UserID='{$UserID}' and videoID='{$videoID}',1)";
	ex_query($query);	
}
function liked($UserID , $Videoid)
{
	$query  = "Select 1 from liked where UserID ='{$UserID}' and videoid='{$Videoid}'";	
	if(ex_query1RowAns($query) == 1)
	{
		return true;
	}	
	else 
	{
		return false;
	}
}
function  reported($UserID , $Videoid)
{
	$query  = "Select 1 from reportedvideo where UserID ='{$UserID}' and videoid='{$Videoid}'";	
	if(ex_query1RowAns($query) == 1)
	{
		return true;
		
	}	
	else 
	{
		return false;
	}
}


function UpdateHistory($UserID,$hash,$DateString)
{
	//check to see if exists if it does then upodate the date otherwise insert
	// i have to add a check to see if this has been seen if so then it should just edit the date 
	$query ="Select 1 from history where USERID=".$UserID." and VideoID='".$hash."'";
	if(ex_query1RowAns($query)==1)
	{
		//Then Update the date 
		$query ="Update history set Date ='{$DateString}' where USERID=".$UserID." and VideoID='".$hash."'";
		ex_query($query);
	}
	else {
	$query ="Insert into history(USERID,VideoID,Date) Values('{$UserID}','".$hash."','".to_mysqlDate(time())."')";
    ex_query($query);	
	}
    
}
function showPages($Page,$VidNum,$query)
{
	    //i want to show the next list of videos but i also want to make sure that there if there is another page then that one is highlighted so they 
		// wouldnt clik it again 
		//first i want to show every video based on the page 
		//if page was equal to 3 then i would show videos from 15 -22
		//if page was equal to 1 then i would show 0-6 
		//if page was equal to 2 then i would show 7-13
		//if page was equal to 3 then i would show 14-20
		// Query for the pages 
		//Limit is Starting point and for how long to keep going 
		$limit = (($Page* $VidNum)-1);
		$selectQuery =$query." LIMIT ".($limit - ($VidNum -1)) .",". ($VidNum -1)  ;
		$result =ex_query($selectQuery);
		
		GenMultipleThumb($result);
		//
		//Now to show the number of pages again 
		
}
function Pages_search($query,$phpFile,$search)
{
				 $arrayName = array();
			  	$count =0;
			   	$results= ex_query($query);
			    while($row = mysql_fetch_array($results))
			    {
				    //var_dump($row);
					$arrayName[$count] = $row[0];	
					$count++;				    
			    }
				// Show pages links
			    $divider =7;
			    $NumPages =ceil((count($arrayName)/$divider));
				echo "<div class=\"grid_12\">\n";
				for ($i=0; $i < $NumPages; $i++) 
				{
					//create the links 
					// has the have the page for the limit  
					$VidsPerPage ="VidNum=".$divider;
					$string .= ("<a href=\"");
					$string .= ($phpFile."?");
					$string .=('Page=');
					$string .= ($i+1);
					$string .= "&Search=".$search;
					$string .=("&".$VidsPerPage."\">");
					$string .= ($i+1 ."</a>\n");
					
					echo ($string);
				}
				echo "</div>\n";
}
function Pages($query,$phpFile)
{
				 $arrayName = array();
			  	$count =0;
			   	$results= ex_query($query);
			    while($row = mysql_fetch_array($results))
			    {
				    //var_dump($row);
					$arrayName[$count] = $row[0];	
					$count++;				    
			    }
				// Show pages links
			    $divider =7;
			    $NumPages =ceil((count($arrayName)/$divider));
				echo "<div class=\"grid_12\">\n";
				for ($i=0; $i < $NumPages; $i++) 
				{
					//create the links 
					// has the have the page for the limit  
					$VidsPerPage ="VidNum=".$divider;
					$string .= ("<a href=\"");
					$string .= ($phpFile."?");
					$string .=('Page=');
					$string .= ($i+1);
					$string .=("&".$VidsPerPage."\">");
					$string .= ($i+1 ."</a>\n");
					
					echo ($string);
					
					
				}
				echo "</div>\n";
}
function GetDescofUser($userid)
{
	return ex_query1RowAns("Select info from usersinfo where ID=".$userid);
}
function to_mysqlDate($time)
{
    //Format from my sql is y-m-d h:m:s
    // format 2012-05-21 18:54:49
    $mysqldate =strftime("%Y-%m-%d %H:%M:%S",$time);
   
    return $mysqldate;
    
}
function addToFavorites($User_ID,$VideoID)
{
    $query ="Insert into favorites(USERID,VideoID) Values('{$User_ID}','{$VideoID}')";
    ex_query($query);
}
function getUsername($user_ID)
{
    return ex_query1RowAns("Select UserName from users where id=".check_input($user_ID));
    
}
function removeFromFavorites($User_ID,$VideoID)
{
    $query= "Delete from favorites where UserID ='{$User_ID}' and VideoID= '{$VideoID}'";
    ex_query($query);
	echo "$query";
}
function GEnerateImageThumb($vidID)
{
    $results=ex_query("Select * from video where id ='".$vidID."'");
    $row = mysql_fetch_array($results);
	if(!empty($row[0]))
	{
    echo("<div class=\"grid_3 VideoThumb\" >\n");
    echo("<a href=\"view.php?videoID=".$row['Hash']."\">\n");
   echo("<h1>".substr($row['VideoName'], 0,12)."...</h1>\n");
	 echo("<br />\n");
	 
    
    echo("<img alt=\"".substr($row['VideoName'], 0,12)."\" src=\"".Image2Thumb($row['videoImage'])."\"/>\n"); 
    //echo("<img src=\"".Image2Thumb($row[4])."\" />");
    echo("<br />\n");
    $desc = ex_query1RowAns("Select txtdesc from videodesc where vidid =".$row['ID']);
    echo("<p>".substr($desc, 0,90)."...</p>\n");
    echo("</a>\n"); 
    echo("</div>\n");		

	}    
	else {
		// echo "not in Video Library";
	}
}
function GEnerateImageThumbHeader($vidID)
{
    $results=ex_query("Select * from video where id ='".$vidID."'");
    $row = mysql_fetch_array($results);
	if(!empty($row[0]))
	{
    echo("<div class=\"grid_2 VideoThumbHeader\"> \n");
    echo("<a href=\"view.php?videoID=".$row['Hash']."\">\n");
    echo("<h1>".substr($row['VideoName'], 0,12)."...</h1>\n");
    echo("<img title=\"".$row['VideoName']."\"  src=\"".Image2Thumb($row['videoImage'])."\"/>\n"); 
    //echo("<img src=\"".Image2Thumb($row[4])."\" />");
    $desc = ex_query1RowAns("Select txtdesc from videodesc where vidid =".$row['ID']);
    // echo("<p>".substr($desc, 0,10)."...</p>\n");
    echo("</a>\n"); 
    echo("</div>\n");		

	}    
	else {
		// echo "not in Video Library";
	
	}
}
function redirect_to($location =NULL)
{
    if($location!=NULL)
    {
         header("location:{$location}");
    }
    else{
     header("location: index.php");   
    }
     
}
function generateImage($filepath,$thumbnailPath)
{
	$ffmpeg="ffmpeg";
	$command =$ffmpeg." -i ".$filepath." -vcodec mjpeg -vframes 10 -an ".$thumbnailPath;
exec($command);
}
function NumberofComments($userid)
{
	return ex_query1RowAns("Select count(*) from comments where userid='{$userid}'");
}
function Image2Thumb($filename)
{
   return "includes/image.php?fname=".urlencode($filename);
}
function check_input($fname)
{
    
    if(get_magic_quotes_gpc())
    {
        $fname = stripcslashes($fname);
    }
    if(is_numeric($fname))
    {
        $fname = "'".mysql_real_escape_string($fname)."'";
    }
    return $fname;
}
function ex_query($query)
{
    $results = mysql_query($query);
    if (!$results)
    {
        die($query."<br/>Database has failed :" . mysql_error());
    }
    return $results;
}
function ex_query1Row($query)
{
    
    $results = mysql_query($query);
    if (!$results)
    {
        die($query."<br/>Database has failed :" . mysql_error());
    }
    $row = mysql_fetch_array($results);
    return $row;
}
function ex_query1RowAns($query)
{
    
    $results = mysql_query($query);
    if (!$results)
    {
        die($query."<br/>Database has failed :" . mysql_error());
    }
    $row = mysql_fetch_array($results);
    return $row[0];
}
function generateHash()
{
    $arhash = str_split("ABCDEFGHIKJLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz");
    shuffle($arhash);
    $arhash = array_slice($arhash, 0, rand(6, 15));
    $hash = implode("", $arhash);
    return $hash;
}
function genFBState()
{
	$arhash = str_split("ABCDEFGHIKJLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz");
    shuffle($arhash);
    $arhash = array_slice($arhash, 0, rand(10, 25));
    $hash = implode("", $arhash);
    return $hash;
}
function genUhash()
{
    $hash="";
    $toggle="run";
    while($toggle == "run")
    {
        $hash = bol();
        if ($hash != "false")
        {
            $toggle = "false";
        }
     }
     
     return $hash;
}
function bol()
{
    $genhash = generateHash();  
    if (check("video","Hash","".$genhash.""))
    {
        return $genhash;    
    }
    else{
        return "false";
        }
}
function check($table,$col,$colVaue)
{
    $fname = "SELECT 1 FROM ".$table." where ".$col." = \"" . $colVaue."\""; 
    $results = ex_query($fname);
    $row = mysql_fetch_array($results);
    if ($row[0] == "1")
    {
        return false;
    } else
    {
        return true;
    }
    
}
Function Favorited($userid,$videoID)
{
	$query = "select 1 from favorites where userid={$userid} and VideoID='{$videoID}'";
	$fav = ex_query1RowAns($query);
	if($fav==1)
	{
		return true;
	}
	else{return false;}
}

function GetVideoID($hash)
{
	$q="Select ID from video where Hash='{$hash}'";
	return ex_query1RowAns($q);
}

function getnumVideosUploaded($userID)
{
	  return ex_query1RowAns("Select count(*) from video where userid=".check_input($userID));
}
function getnumVideosWatched($userID)
{
	  return ex_query1RowAns("Select count(*) from history where userid=".check_input($userID));
}
function getUploadSize($userid)
{
	$query ="Select UploadLimit from usersinfo where id ={$userid}";
	return ex_query1RowAns($query);
}

/**
Validate an email address.
Provide email address (raw input)
Returns true if the email address has the email 
address format and the domain exists.
*/
function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || 
 ↪checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}
?>