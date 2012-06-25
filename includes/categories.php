
<?php

// $results = ex_query("Select upper(name) from categories order by ID");
// 
// while ($row = mysql_fetch_array($results))
// {
	// echo "<ul id=\"Categories\" class=\"grid_3\">";
    // echo ("\n<li><a href=\"browse.php?Category=" . urlencode($row[0]) . "\">" . $row[0] .
        // "</a></li> \n");
	// echo "</ul>";	
// }
?>    
<!-- <li>================</li> -->

<ul id="Categories" class="grid_4">

<li>
	CATEGORIES
	<a href="reco.php">RECOMMEND</a>
</li>
</ul>
<ul id="Categories" class="grid_4">       
<li>
	<a href="browse.php?Views=">Most Watched</a>
</li>
</ul>
<ul id="Categories" class="grid_4">
<li>
	<a href="browse.php?Recent=">Recent</a>
</li>  
</ul>