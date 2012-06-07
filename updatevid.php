<?php 
if (isset($_GET['videoID']))
{
    require_once ("includes/connection.php");
    require_once ("includes/functions.php");
    if(!check("video","hash",$_GET['videoID']))//
    {
    include_once ("includes/head.php");
    include_once ("includes/categories.php");   
    }
    else{
 header("location: index.php");
}
} 
else{
 header("location: index.php");
}
?>
<form class="grid_9" id="UpdateVideoForm" action="includes/updatevid.php?id=<?php echo($_GET['videoID']);?>" method="post"
enctype="multipart/form-data">
<label>Video Name:</label>
<input type="text" name="VideoName" required="true" value="
<?php
$row=ex_query1Row("select videoName from video where hash =\"".$_GET['videoID']."\"");
echo($row[0]);
?>" 
disabled="True"/>
<br />
<input type="text" value="<?php echo($_GET['videoID']); ?>" name="hash" disabled="true"/>
<br />
<label> Catagories </label>
<br />
<?php
$results = ex_query("Select upper(Name) from categories order by ID");
while ($row = mysql_fetch_array($results))
{
    echo("<input type=\"checkbox\" name=\"".$row[0]."\"/> \n");
    echo("<label>".$row[0]."</label>\n");
    echo("<br/>\n");
}
?>
 
 <label>Video Description</label>
 <textarea form="UpdateVideoForm" cols="29" rows="4" name="Desc">
 Please Enter Your Description	
 </textarea>
 <br />
 <label>Keywords Comma seperated </label>
 <input type="text" name="Keywords" placeholder="Enter Keywords"/>
 
 <input type="submit" name="submit" value="Submit" />
</form>

 <?php
include_once ("includes/foot.php");
?>