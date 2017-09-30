<?php
$projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
require $projectRoot.'Sources/BackEnd/controller/relativePathController.php';

$pathto = "$projectRoot/Resources/";
if (strlen(filter_input(INPUT_POST, "filename"))>0)
{
	try{
	$imgorg = imagecreatefrompng($pathto.filter_input(INPUT_POST, "filename"));
	$imglayer = imagecreatefrompng($pathto.filter_input(INPUT_POST,"resource"));
	if (imagecopymerge($imgorg, $imglayer, 0, 0, 0, 0,640, 640, 50)){
		imagepng($imgorg,$pathto.filter_input(INPUT_POST, "filename"));
		echo 'done';
	}
	}  catch (Exception $xc){
		echo $xc->getTraceAsString();
	}
	
}
