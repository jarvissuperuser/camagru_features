<?php
$projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
require $projectRoot.'Sources/BackEnd/controller/relativePathController.php';
session_start();
try{
$dbc = new DB_Control();
$gallery_query = $dbc->insert("Camagru.gallery", 
			["imageTitle","userID","creationDate","imageStatus"],
			[":imgT",":uID","now()",'0']);
$st = $dbc->dbCon->prepare($gallery_query);
}  catch (Exception $exc){
	die(json_encode($exc->getTrace()));
}
if (strlen(filter_input(INPUT_POST, "filename"))>0)
{
	try{
		$st->bindParam("imgT",explode(".",filter_input(INPUT_POST, "filename"))[0]);
		$st->bindParam("uID", $_SESSION["userid"]);
		$st->execute();
		echo json_encode( $st->errorInfo());
	}  catch (Exception $xc){
		die(json_encode($xc->getTrace()));
	}
}
