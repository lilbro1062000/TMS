<?php
include_once ("includes/session.php");
Logged_in();
include_once ("includes/head.php");
include_once ("includes/categories.php");

?>

<!-- Load Queue widget CSS and jQuery -->
<style type="text/css">@import url(js/jquery.plupload.queue/css/jquery.plupload.queue.css);</style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>


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



<form id="Upload_Box" class="grid_9" action="includes/upload_file.php" method="post"
enctype="multipart/form-data">
    <input type="hidden"  name="MAX_FILE_SIZE" value="<?php  echo getUploadSize($_SESSION[SESSIONUSERID]); ?>" />
    
    <label for="VideoName">Video Name</label> 
    
<input type="text" name="VideoName" required="true"/>
    <br />
    
    
    <!--
    <input id="uploadedfile" type="file" name="uploadedfile" onchange=" fileSelected();" />
-->
<div id="html5_uploader" class="grid_9" >
	You browser doesn't support native upload. Google Chrome
	</div>
    <br />
    <input type="submit" name="submit" value="Upload" />
</form>


<div id="FileInfo">
</div>




  <?php

include_once ("includes/foot.php");

?>