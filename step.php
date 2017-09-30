<?php

$projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
require $projectRoot.'Sources/BackEnd/controller/relativePathController.php';

$enter = filter_input(INPUT_POST,"reset");
$query = "SELECT userID,userName FROM Camagru.users where email like :que";
$dbConn ;

try{
	$dbConn = new DB_Control();
	$res = $dbConn->prep($query, $dbConn->dbCon);
	$res->bindParam('que', $enter);
	$res->execute();
	if ($res->rowCount() ==1){
		$det = $res->fetchObject();
		$update = "UPDATE Camagru.users set verificationStatus = 3 where userID = {$det->userID}";
		$new = $dbConn->prep($update, $dbConn->dbCon);
		$auth1 = str_rot13(base64_encode(json_encode($det)));
		$auth = htmlspecialchars($auth1);
		$new->execute();
		$link = "http://localhost/camagru/?path=$auth";
		echo $link;
		$message = "Hi {$det->userName},".PHP_EOL .
						"Please Follow Link to reset Password:" . PHP_EOL .
						"$link" . PHP_EOL .
						"Kind Regards ". PHP_EOL .
						"Camagru Team";
		echo mail($enter, "Recovery Request", $message);
		
		//echo $auth1 . ":"  . $auth2 . '::' . $update;
	}
	header("Location: ./index.php?msg=es");
}catch(Exception $e){
	echo json_encode($e);
}
