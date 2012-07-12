<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="javascripts/jquery.bxSlider.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#slider1').bxSlider({
			displaySlideQty : 3,
			moveSlideQty : 1,
			auto : true,
			autoControls : false,
		});

		$('#slider2').bxSlider({
			displaySlideQty : 3,
			moveSlideQty : 1,
			auto : true,
			autoControls : false,
		});

		$('#slider3').bxSlider({
			displaySlideQty : 3,
			moveSlideQty : 1,
			auto : true,
			autoControls : false,
		});
		
		$('#Recent').hide();
		$('#MostWatched').hide();
		$('#Categories_info').hide();
		// $("#ElasticBar").animate({
			// width : "960px"
		// }, 1000);

		function reset() {
			$('#info').animate({
				width : "0px"
			}, 900,function () {
			
		$('#Recent').hide();
		$('#MostWatched').hide();
		$('#Categories_info').hide();
		$('#Trending_info').hide();  
			});
			
		}


		$('#Trending').click(function() {
			reset();
			
			$('#info').animate({
				width : "620px"
			}, 1000,function () {
			$('#Trending_info').show('slow');  
			});
		});
		
		$('#Ct').click(function() {
			reset();
			
			$('#info').animate({
				width : "620px"
			}, 1000,
			function () {
			$('#Categories_info').show('slow');  
			});
		});
		
		$('#MW').click(function() {
			reset();
			$('#info').animate({
				width : "620px"
			}, 1000,
			function () {
			$('#MostWatched').show('slow');  
			});
		});
		
		$('#Rce').click(function() {
			reset();
			$('#info').animate({
				width : "620px"
			}, 1000,
			function () {
			$('#Recent').show('slow');  
			});
		});
		
	}); 
</script>
<div id="ElasticBar">
	<table>
		<tr>
			<td class="grid_4">
			<table >
				<tr>
					<td>
					<ul id="Trending" class="elasticMenuOptions">
						<li>
							<a>Trending</a>
						</li>
					</ul></td>

				</tr>
				<tr>
					<td>
					<ul id="Ct" class="elasticMenuOptions">
						<li>
							<a >Categories</a>
						</li>
					</ul></td>
				</tr>
				<tr>
					<td>
					<ul id="MW" class="elasticMenuOptions">
						<li>
							<a> Most Watched</a>
						</li>
					</ul></td>
				</tr>
				<tr>
					<td>
					<ul id="Rce" class="elasticMenuOptions">
						<li>
							<a>	Recent</a>
						</li>
					</ul></td>
				</tr>
				<tr>
					<td>
					<ul class="elasticMenuOptions">
						<li>
							<a href="reco.php">Recommend</a>
						</li>
					</ul></td>
				</tr>
			</table></td>
			<td class="grid_8">
			<div id="info" >
				<div id="Categories_info">
					<?php
					$results = ex_query("Select upper(name) from categories order by ID");

					while ($row = mysql_fetch_array($results)) {
							// echo "<ul id=\"Categories\" class=\"grid_3\">";
						echo "<ul>";
						echo("\n<li><a href=\"browse.php?Category=" . urlencode($row[0]) . "\">" . $row[0] . "</a></li> \n");
							echo "</ul>";
					}
					?>
				</div>
				<div id="Trending_info">
				Trending
					<?php
					
					//Add some trending vids here.
					//This Template
					
						$query ="Select Video_ID From views order by Numwatched desc limit  0, 7";
						 $results= ex_query($query);
					echo "<ul id=\"slider1\">";	 
						 while($row = mysql_fetch_array($results))
					    {
					    	echo "<li>";
					             GEnerateImageThumbHeader($row[0]);
							echo "</li>";    
					    }
					
					
					echo "</ul>";
					?>
					
					
				</div>
				<div id="MostWatched">
					<?php
					//Add some MostWatched vids here.
						$query ="Select Video_ID From views  order by Numwatched desc limit  0, 7";
						 $results= ex_query($query);
					echo "<ul id=\"slider2\">";	 
						 while($row = mysql_fetch_array($results))
					    {
					    	echo "<li>";
					             GEnerateImageThumbHeader($row[0]);
							echo "</li>";    
					    }
					
					
					echo "</ul>";
					?>
					<a href="browse.php?Views="> Look at full List</a>
				</div>
				<div id="Recent">
					Recent
					<?php
					//Add some recent vids here.
					
					$query ="Select id From video order by ID desc limit 0, 7";
					 $results= ex_query($query);
					echo "<ul id=\"slider3\">";	 
						 while($row = mysql_fetch_array($results))
					    {
					    	echo "<li>";
					             GEnerateImageThumbHeader($row[0]);
							echo "</li>";    
					    }
					
					
					echo "</ul>";
					?>
										<a href="browse.php?Recent="> Look at full List</a>
				</div>
			</div></td>
		</tr>
	</table>
</div>
