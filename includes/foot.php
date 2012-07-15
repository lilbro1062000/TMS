
<footer id="Footer" class="grid_12">

<script type="text/javascript">

	$(document).ready(function() {
		
		
		$('#AboutUSi').hide();
		$('#ContactUSi').hide();
		
		function footreset()
		{
			$('#footinfo').animate({
					width : "0px"
				}, 1000,function () {
				
			$('#TMSi').hide();
			$('#AboutUSi').hide();
			$('#ContactUSi').hide();
			});
				
		}
		
 		
		$('#TMSc').click(function(){
		footreset();
		$('#footinfo').animate(
			{
				width : "620px"
			},1000,function (){
				$('#TMSi').show('slow');		
				}
			);
		});
		
		$('#AboutUSc').click(function(){
			footreset();
			
			
			$('#footinfo').animate(
				{
					width : "620px"
				},1000 ,
				function (){
				$('#AboutUSi').show('slow');
				}
			);
		});
		$('#ContactUSc').click(function(){
			footreset();
			$('#footinfo').animate(
				{
					width : "620px"
				},1000 ,
				function (){
				$('#ContactUSi').show('slow');
				}
			);
		});
	});
</script>


<table>
	<tr>
	 <td>
			<table >
				<tr>
					 <div id="TMSc">
						<a >TMS</a>
							<br />			
				</div>		
				</tr>
				<tr>
					<div  id="AboutUSc">
					<a>About US</a>
					<br />
					</div>
				</tr>
				<tr>
					<div  id="ContactUSc">
					<a>Contact US</a>
					<br />
					</div>
				</tr>
				<tr>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

					
				</tr>
			</table>
	 	
	 </td>
	 <td>
	 	<div id="footinfo">
			<table>
				<tr>
					<div  id="TMSi">
						
					
					<h1>TMS</h1>
					<p>
						Teach Me Something
					</p>
					<p>
						Come Learn Something
					</p>
					</div>					
				</tr>
				<tr>
				<div  id="AboutUSi">
					
				<h1>About US:</h1>
					<br/>
					TMSomething is a video Website that pays people to aquire unique Views on videos. 
					<br />
					Using Advertisements, So please watch, click and read them.
					<br />
					 
					<br />
					Thats our goal plain and simple
					
					</div>	
				</tr>
				<tr>
					<div id="ContactUSi">
					<h1>Contact US</h1>
					
					<br />
					Sure Email Us and we will respond as quickly as possible:
					<br />
					<br />
					admin at TMSOMething.com 
					<br />
					 Abdul at TMSomething.com 
					 <br />
					  lilbro1062000 at gmail.com
					  </div>
				</tr>
			</div>
				
	 </td>
	</tr>
	
</table>
</footer>
<div class="grid_12">
	<br />
(c) Copyright 2012 TMSomething. All Rights Reserved.
</div> 
<!-- Java script added on footer -->
<!-- <script type="text/javascript" src="javascripts/jwplayer.js"></script> -->
<!--
<script src="javascripts/960.gridder.js" type="text/javascript"></script>
-->
</body>
<?php
mysql_close($connection);
?>
</html>