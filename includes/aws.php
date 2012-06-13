<?php
require_once ('AWSSDK-1.5.4/sdk.class.php');
//header("Content-type: text/plain; charset=utf-8");
$s3 = new AmazonS3();
$bucket = "tmsbucketdev";


Function isInBucket($fname) {
	global $s3, $bucket;
	$array = $s3 -> get_object_list($bucket);

	foreach ($array as $key) {

		if ($key == $fname) {
			return true;
		}
	}

	return false;
}

Function Insert_into_bucket($path,$name,$type='video/mp4')
{
	global $s3, $bucket;
	$awsPublicPath;

	$response =$s3->create_object($bucket, $name,array(
		'fileUpload'=>	$path,
		'contentType'=>$type,
		'acl'=>$s3::ACL_PUBLIC
		
	));
	
	if($response->status!=200)
	{
		echo "Failed Uploading \n";
		echo $response;
		echo $path;
		echo $name;
	}
	else {
	$awsPublicPath=	$s3->get_object_url($bucket, $name);
			return $awsPublicPath;	
	}
	
	
}
function Delete_from_bucket($filename)
{
	 global $s3, $bucket;
	 $response = $s3 ->delete_object($bucket, $filename);
	 if($response->status!=200)
	{
		echo "Failed Deleteing file\n";
		echo $response;
		echo $filename;
	}
}

//echo isInBucket("orangeSoda.php");
?>