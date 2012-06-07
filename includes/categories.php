<ul id="Categories" class="grid_3">

<li>
	CATEGORIES
</li>
<?php

$results = ex_query("Select upper(name) from categories order by ID");

while ($row = mysql_fetch_array($results))
{
    echo ("\n<li><a href=\"browse.php?Category=" . urlencode($row[0]) . "\">" . $row[0] .
        "</a></li> \n");
}
?>    
<li>================</li>

<li>
	<a href="reco.php">RECOMMEND</a>
</li>       
<li>
	<a href="browse.php?Views=">Most Watched</a>
</li>
<li>
	<a href="browse.php?Recent=">Recent</a>
</li>  
</ul>