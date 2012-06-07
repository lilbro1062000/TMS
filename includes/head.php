<?php
require_once("session.php");
require_once ("connection.php");
require_once ("functions.php");
?>
<!DOCTYPE HTML>
<html lang="en" >
<head>
  <title>Teach Me Something</title>
<!-- Style sheets added by Abdoulaye Camara  --> 
<link href="stylesheets/reset.css" rel="stylesheet" type="text/css" />
<link href="stylesheets/960.css" rel="stylesheet" type="text/css" />
<link href="stylesheets/Style.css" rel="stylesheet" type="text/css" />



<!-- Video stuff  -->
<!--
<link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet" />
<script src="http://vjs.zencdn.net/c/video.js"></script>
-->

<!--To use when not connected to internet--> 
<link href="videojs/video-js.css" rel="stylesheet"/>
<script src="videojs/video.js"></script>


</head>
<body class="container_12">
      <a href="index.php" >
      <img src="images/website_Layout.png"  alt="Teach ME Something" class="grid_3"/>
      </a>
      <form class="grid_6" action="search.php" method="get" enctype="multipart/form-data">
       <input type="text" placeholder="Cool" class="grid_4" name="Search"/>
       <input type="submit" value="Search" class="grid_1" />
       </form>
       <ul id="NavMenu" class="grid_3">
        <?php
$results = ex_query("Select * from header_menu order by ID asc;");
while ($row = mysql_fetch_array($results))
{
    if($row[1]=="Login"&& checklogin())
    {
     echo ("<li id=\"NavMenu\"><a href=\"" . $row[2] . "?logout=1\">logout</a></li>\n");
    }
    else
    {
     echo ("<li id=\"NavMenu\"><a href=\"" . $row[2] . "\">" . $row[1] . "</a></li>\n");
    }
    
}
?> 
</ul>
  

<?php
if(checklogin())
{
echo("<div id=\"user_menu\" class=\"grid_12\">\n");
echo("<ul>\n");
$results = ex_query("Select * from user_menu order by ID asc;");
echo("<li><a href=\"profile.php\">".$_SESSION['User_Name']." </a></li>");
while ($row = mysql_fetch_array($results))
{
    
     echo ("<li><a href=\"" . $row['Path'] . "\">" . $row['Name'] . "</a></li>\n");
    
    
}
echo("</ul>\n");
echo("</div>\n");
} 
?>
     
      
    <div id="AdBar" class="grid_12"> 
   
    </div>