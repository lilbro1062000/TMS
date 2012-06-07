<?php
$filename =urldecode($_GET['fname']);

$toWidth=160;
$toHeight=160;

 list($width, $height) = getimagesize($filename);
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