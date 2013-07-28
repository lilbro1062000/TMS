<script src="/js/jquery.bxSlider.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function() {
		
		var slider1=$('#slider1').bxSlider({
			displaySlideQty : 3,
			moveSlideQty : 1,
			randomStart : true,
			auto : true,
			autoControls : false,
			controls: false
		}),

		 slider2=$('#slider2').bxSlider({
			displaySlideQty : 3,
			moveSlideQty : 1,
			randomStart : true,
			auto : true,
			autoControls : false,
			controls: false
		}),

		 slider3=$('#slider3').bxSlider({
			displaySlideQty : 3,
			moveSlideQty : 1,
			randomStart : true,
			auto : true,
			autoControls : false,
			controls: false
		});
		
		$('#Recent').hide();
		$('#MostWatched').hide();
		$('#Categories_info').hide();
		// $("#ElasticBar").animate({
			// width : "960px"
		// }, 1000);

		$('#prev').click(function(){
			slider1.goToPreviousSlide();
			slider2.goToPreviousSlide();
			slider3.goToPreviousSlide();
			return false;
			});

  $('#next').click(function(){
    slider1.goToNextSlide();
    slider2.goToNextSlide();
    slider3.goToNextSlide();
    return false;
  });
  
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
			$(this).css("background-color","orange");
			$("#Ct").css("background-color","rgb(2,89,73)");
			$("#MW").css("background-color","rgb(2,89,73)");
			$('#Rce').css("background-color","rgb(2,89,73)");
			reset();
			
			$('#info').animate({
				width : "620px"
			}, 1000,function () {
			$('#Trending_info').show('slow');  
			});
		});
		
		$('#Ct').click(function() {
			$(this).css("background-color","orange");
			$("#Trending").css("background-color","rgb(2,89,73)");
			$("#MW").css("background-color","rgb(2,89,73)");
			$('#Rce').css("background-color","rgb(2,89,73)");
			reset();
			
			$('#info').animate({
				width : "620px"
			}, 1000,
			function () {
			$('#Categories_info').show('slow');  
			});
		});
		
		$('#MW').click(function() {
			$(this).css("background-color","orange");
			$("#Trending").css("background-color","rgb(2,89,73)");
			$("#Ct").css("background-color","rgb(2,89,73)");
			$('#Rce').css("background-color","rgb(2,89,73)");
			reset();
			$('#info').animate({
				width : "620px"
			}, 1000,
			function () {
			$('#MostWatched').show('slow');  
			
			});
		});
		
		$('#Rce').click(function() {
			$(this).css("background-color","orange");
			$("#Trending").css("background-color","rgb(2,89,73)");
			$("#Ct").css("background-color","rgb(2,89,73)");
			$("#MW").css("background-color","rgb(2,89,73)");
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
								<a>Trending Videos</a>
							</li>
						</ul>
					</td>

				</tr>
				<tr>
					<td>
					<ul id="Ct" class="elasticMenuOptions">
						<li>
							<a >Video Categories</a>
						</li>
					</ul></td>
				</tr>
				<tr>
					<td>
					<ul id="MW" class="elasticMenuOptions">
						<li>
							<a> Most Watched Videos </a>
							</li>
					</ul></td>
				</tr>
				<tr>
					<td>
					<ul id="Rce" class="elasticMenuOptions">
						<li>
							<a>	Recent Videos</a>
						</li>
					</ul>
					</td>
				</tr>
				<tr>
					<td>
					<ul class="elasticMenuOptions">
						<li>
							<a href="reco.php">Send Us Recommendations </a>
						</li>
					</ul></td>
				</tr>
			</table>
			
			</td>
			
			<td class="grid_8">
				
			<div id="info" >
				<table>
					<tr>
				<td>	
				<div id="prev">
							<img alt="Prev" id="prev1" src="/images/left.png" />
			</div>
			</td>
			<td>
				<div id="Categories_info">
					
					<?php
					
					$results = ex_query("Select upper(name) from categories where PrevName ='NULL' order by ID");
echo "\n<table>\n";
$count =0;
					while ($row = mysql_fetch_array($results)) {
							// echo "<ul id=\"Categories\" class=\"grid_3\">";
						if($count==0)
						{
							echo "\n<tr>\n";
						}
						
						echo("\n<td id=\"catID".$row[0]."\"> <a href=\"/Category/" . urlencode($row[0]) . "\">" . $row[0] . "</a></td> \n");
						
						$count = $count + 1;
						
						if($count==3)
						{
							echo "\n</tr>";
							$count =0;
						}
			
					}
				echo "\n</table>\n";
					?>
				</div>
				<div id="Trending_info">
				Trending Videos
					<?php
					
					//Add some trending vids here.
					//This Template
					
						$query ="Select Video_ID From views order by Numwatched desc limit  0, 9";
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
						$query ="Select Video_ID From views  order by Numwatched desc limit  0, 9";
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
					<a href="/browse.php?Views=1"> Look at full List</a>
				</div>
				
				<div id="Recent">
					Recent Videos
					<?php
					//Add some recent vids here.
					
					$query ="Select id From video order by ID desc limit 0, 9";
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
										<!-- <a href="\browse.php?Recent="> Look at full List</a> -->
				</div>
				</td>
			<td>
			<div class="ui-icon-seek-next" id="next">
					<img alt="Next" id="next1" src="/images/right.png" />
						
			</div>
			</td>
			</tr>
			</table>
			</div>
			</td>
			
		</tr>
	</table>
</div>

