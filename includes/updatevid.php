<?php
include_once ("session.php");
Logged_in();
    require_once ("connection.php");
    require_once ("functions.php");
    
  
//Insert Catagory
	    $results = ex_query("Select upper(Name) from categories order by ID");
        
        while ($row = mysql_fetch_array($results))
        {
            if(isset($_POST[$row[0]]))
            {
                if($_POST[$row[0]]=="on")
                {
                	//check to see if the category exists already
                	$checkQuery = "Select 1 from videocatinfo where hash ='{$_GET['id']}' and Category ='{$row[0]}'";
					
					if(ex_query1RowAns($checkQuery)!=1)
					{
                	// inset the category into the Database 
                    $query ="Insert into videocatinfo(hash,Category) Values('".$_GET['id']."','".$row[0]."')";
                    ex_query($query);	
					}
                } 
				else{
					//check to see if the category exists already
                	$checkQuery = "Select 1 from videocatinfo where hash ='{$_GET['id']}' and Category ='{$row[0]}'";
					
					if(ex_query1RowAns($checkQuery)==1)
					{
                	// inset the category into the Database 
                    $query ="delete from videocatinfo where hash ='{$_GET['id']}' and Category ='{$row[0]}'";
                    ex_query($query);
				} 
            }
        }
//Insert Description 
         $desc =check_input($_POST['Desc']);
         $desc = preg_replace("/[^A-Z0-9._-]/i", " ", $desc);
         $query ="Select ID from video where hash ='".$_GET['id']."'";
         $vidID =ex_query1Row($query);
         $query1 ="Insert into videodesc(VidID,txtDesc) Values(".$vidID[0].",'".$desc."')";
         ex_query($query1);
//Insert Keywords 
   $array =check_input($_POST['Keywords']);
   $array =explode(",",$array);
   
   for($numCount =0;$numCount<count($array);$numCount++)
   {
    $query = "Insert into keywords(VideoID,Keyword) Values('".$vidID[0]."','".$array[$numCount]."')";
    ex_query($query);
   }
redirect_to("../view.php?videoID=".$_GET['id']);

?>