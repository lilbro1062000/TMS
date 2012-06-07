<?php
include_once ("includes/head.php");
include_once ("includes/categories.php");
?>
<div id="mainPage" class="grid_3"  >
  <?php
    $select="select ID from video limit 0,6";
    $result = ex_query($select);
	while($row =mysql_fetch_row($result))
	{
		GEnerateImageThumb($row[0]);
	} 
  ?>
</div>

<?php
include_once ("includes/foot.php");
?>