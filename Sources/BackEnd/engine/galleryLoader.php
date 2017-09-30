<?php
//ini_set("display_errors", 'on');
$projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
require $projectRoot.'Sources/BackEnd/controller/relativePathController.php';
session_start();
$offset = 5;
$start = (int) filter_input(INPUT_POST, "start");
if (strlen(filter_input(INPUT_POST,"offset")))
				$offset = filter_input(INPUT_POST,"offset");


$dbc =  new DB_Control();
$selection = ["imageTitle","imageID","creationDate"];
$table = "Camagru.images";
if (isset($_SESSION['userid'] )&& strlen(filter_input(INPUT_GET, "Show"))==0){
	$limiter = "userID = {$_SESSION['userid']} and imageStatus=0 ORDER BY imageID DESC LIMIT $start,$offset";
}
else{
	$limiter = "imageStatus=0 ORDER BY imageID DESC LIMIT $start,$offset";
}
		
$gallery_query = $dbc->select($selection, $table, $limiter);
$gallery_state = $dbc->prep($gallery_query, $dbc->dbCon);
if ($gallery_state->execute()){
	echo json_encode($gallery_state->fetchAll());
}
else{
	echo '{"msg":"error","problem":"' . 
					$gallery_state->errorInfo()[2]
				. '"}';
}