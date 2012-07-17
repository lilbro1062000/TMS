<?php
include_once ("includes/session.php");
Logged_in();
include_once ("includes/head.php");
include_once ("includes/categories.php");

?>

<!-- Load Queue widget CSS and jQuery -->
<style type="text/css">@import url(js/jquery.plupload.queue/css/jquery.plupload.queue.css);</style>


<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
<script type="text/javascript" src="js/plupload.full.js"></script>
<script type="text/javascript" src="js/jquery.plupload.queue/jquery.plupload.queue.js"></script>

<script type="text/javascript">
// Convert divs to queue widgets when the DOM is ready
$(function() {

	// Setup html5 version
	$("#html5_uploader").pluploadQueue({
		// General settings
		runtimes : 'html5',
		url : 'plupload.php',
		max_file_size : '100mb',
		chunk_size : '250kb',
		unique_names : true,


		// Specify what files to browse for
		filters : [
			{title : "Videos", extensions : "mov,mpeg,mp4,wmv"}

		]
	});
	// Client side form validation
    $('#Upload_Box').submit(function(e) {
	        var uploader = $('#html5_uploader').pluploadQueue();
	 
	        // Files in queue upload them first
	        if (uploader.files.length ==1) {
	            // When all files are uploaded submit form
	            uploader.bind('StateChanged', function() {
	                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
	                    $('#Upload_Box')[0].submit();
	                }
	            });
	                 
	            uploader.start();
	        } else {
	            alert('You must queue only one file.');
	        }
	 
	        return false;
	    });
	    
	  
	    

	
});
</script>


<!-- only add functions not running functions-->



<form id="Upload_Box" class="grid_12" action="includes/upload_file.php" method="post"
enctype="multipart/form-data">
    <input type="hidden"  name="MAX_FILE_SIZE" value="<?php  
     echo getUploadSize($_SESSION[SESSIONUSERID]);
     ?>" />
    
    <label for="VideoName">Video Name</label> 
    
<input type="text" name="VideoName" required="true"/>
    <br />
    
    
    <!--
    <input id="uploadedfile" type="file" name="uploadedfile" onchange=" fileSelected();" />
-->
<div id="html5_uploader" class="grid_12" >
	You browser doesn't support native upload. Google Chrome
	</div>
    <br />
    <input type="submit" name="submit" value="Upload" />
</form>
<div id="FileInfo">
</div>

<div id="Rules" class="grid_12">
<p>
	<h1>RULES</h1> 
	<ul>
		<table>
			<tr>
		<li> <h2> By uploading you agree to theses Terms and Rules </h2></li>
			</tr>
			
<tr><td><li><h5> Site follows the youtube rules.</h5></li></td></tr>
		<tr><td><li>Do not upload content that may be copyrighted where you have not obtained the explicity permission to use it in that video.</li></td></tr>
		<tr><td><li>Do not upload content with sexually explicit or strongly sexually suggestive material.</li></td></tr>
		<tr><td><li>Do not upload content with nudity or partial nudity.</li></td></tr>
		<tr><td><li>Do not upload content with hate or abusive speech against any individual or group.</li></td></tr>
		<tr><td><li>Do not upload content with excessive profanity.</li></td></tr>
		<tr><td><li>Do not upload content with graphic violence.</li></td></tr>
		<tr><td><li>Do not upload content with drugs or drug use.</li></td></tr>
		<tr><td><li>Do not upload content depicting cruelty to animals.</li></td></tr>
		<tr><td><li>Do not upload content that may put that minors at risk or exploits them in a negative or harmful manner.</li></td></tr>
		<tr><td><li>Do not upload content that promotes and encourages an illegal or dangerous activity.</li></td></tr>
		<tr><td><li>Do not upload content promoting eating disorders.</li></td></tr>
		<tr><td><li>Do not upload content with misleading or inaccurate metadata including video thumbs, titles, tags, and category. This abuse leads to a bad user experience on the site.</li></td></tr>
		</table>
	</ul>

</p>
</div>
  <?php

include_once ("includes/foot.php");

?>