<?php
function remoteFilesize ($URL){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URL);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $info = curl_exec($ch);
    curl_close($ch);
    $info = explode(‘Content-Length’, $info);
    $info = explode(“Connection”,$info[1]);
    return $info[0];
    }

$filename =urldecode($_GET['fname']);

if(isset($_GET['vid']))
{
	//640x360
	$toWidth=640;
	$toHeight=310;	
}
else {
	$toWidth=160;
	$toHeight=160;
}

 // list($width, $height) = getimagesize($filename);
    list($width, $height) = remoteFilesize($filename);
 
    $xscale=$width/$toWidth;
    $yscale=$height/$toHeight;

    if ($yscale>$xscale){
        $new_width = round($width * (1/$yscale));
        $new_height = round($height * (1/$yscale));
    }
    else {
        $new_width = round($width * (1/$xscale));
        $new_height = round($height * (1/$xscale));
    }
   
   header("Content-type: image/jpeg");
    $imageResized = imagecreatetruecolor($new_width, $new_height);
    $imageTmp     = imagecreatefromjpeg ($filename);
    imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

     imagejpeg($imageResized,null,100);
   

    

?>