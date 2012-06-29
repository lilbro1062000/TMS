<script src="javascripts/jquery.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

		$("#ElasticBar").animate({
			width : "960px"
		}, 100);
	});

</script>
<div id="ElasticBar" class="grid_12">
	<table>
		<tr>
			<td>
				<table>
					<tr>
						<ul id="Categories" class="grid_4">
							<!-- <li>================</li> -->
							<li>
								<a href="reco.php">RECOMMEND</a>
							</li>
						</ul>
					</tr>
					<tr>
						<ul id="Categories" class="grid_4">
							<li>
								<a href="browse.php?Views=">Most Watched</a>
							</li>
						</ul>
					</tr>
					<tr>
						<ul id="Categories" class="grid_4">
							<li>
								<a href="browse.php?Recent=">Recent</a>
							</li>
						</ul>
					</tr>
				</table>
			</td>
			<td>
				<div id="info">
					<?php
						$results = ex_query("Select upper(name) from categories order by ID");
		
						while ($row = mysql_fetch_array($results)) {
							//	echo "<ul id=\"Categories\" class=\"grid_3\">";
							echo("\n<li><a href=\"browse.php?Category=" . urlencode($row[0]) . "\">" . $row[0] . "</a></li> \n");
							//	echo "</ul>";
							}
					?>
				</div>
			</td>
		</tr>
	</table>
</div>
