<?php

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
 //  list($width, $height) = remoteFilesize($filename);
    
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $filename); //Actually full URL in code
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); 
$data = curl_exec($ch);

curl_close($ch);

$image = imagecreatefromstring($data);

$width = imagesx($image);
$height = imagesy($image);

 
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
    
    imagecopyresampled($imageResized, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

     imagejpeg($imageResized,null,100);
   

    

?>