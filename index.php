<?php
include_once ("includes/head.php");
include_once ("includes/categories.php");
?>
<div id="fb-root"></div>
<!--
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=453077271378502";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
-->
<div id="mainPage" class="grid_3" style="left: 0; position: relative;" >
<!--
	<table>
		<tr>
			<td>
<div class="fb-live-stream" data-event-app-id="453077271378502" data-width="300" data-height="500" data-always-post-to-friends="true"></div>				
			</td>
			<td>
	<div>
  	
  </div>					
			</td>
			
		</tr>
		
	</table>
  -->
  <?php
    $select="select ID from video limit 0,6";
    $result = ex_query($select);
	GenMultipleThumb($result); 
  ?>
  
</div>

<?php
include_once ("includes/foot.php");
?>