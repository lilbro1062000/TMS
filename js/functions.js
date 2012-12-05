
function fileSelected() 
{
	 var file = document.getElementById('uploadedfile').files[0];
	  if (file) {
	    var fileSize = 0;
	    if (file.size > 1024 * 1024)  
	      {fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';}
	    else
	      fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
	     //match file type
	     //Types video/mp4 video            
	    file.type;       
	    var fileinfo = Document.getElementById('FileInfo');
	    fileinfo.text= file.type;
	                 return false;                                   
	  }
	  else {
	    return false;
	  }
}