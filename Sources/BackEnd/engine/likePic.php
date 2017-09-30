<?php

/*
 * like stats of the picture
 * likedPic
 * askLikes
 */

/*
 * first query if user has liked already
 */

$projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
require_once $projectRoot . 'Sources/BackEnd/controller/relativePathController.php';

$dbc = new DB_Control();
$table = "Camagru.socialNetworks";

try {
if (strlen(filter_input(INPUT_POST, "likedPic")) > 0) {
	
		$Col = ["imageID", "comment_text", "userID","`type_`"];
		$Col_n =  ["imageID","composer"];
		$limiter = "userID = '{$_SESSION['userid']}' "
						. "and imageID = :id and type_ = 'l'";
		$t = $dbc->select($Col, $table, $limiter);
		$rsp = $dbc->prep($t, $dbc->dbCon);
		$rsp->bindParam("id", filter_input(INPUT_POST, "likedPic"));
		if ($rsp->execute()) {
			if ($rsp->rowCount() == 0) {
				$liked = filter_input(INPUT_POST, "likedPic");
				$which = filter_input(INPUT_POST, "ltype");
				$values = ["'$liked'", "'$which'", "'{$_SESSION['userid']}'","'l'"];
				$add = $dbc->insert($table, $Col, $values);
				if ($which == '1'){
					$ps = $dbc->prep($add, $dbc->dbCon);
					$qry = $dbc->select($Col_n, "Camagru.images", "imageID = $liked");
					$g = $dbc->prep($qry, $dbc->dbCon);
					$g->execute();
					$t = $g->fetch();
					$to = $t->composer;
					$msg = "Hi, {$_SESSION['dbEmail']} liked You Photo";
					mail($to,"Camagru Picture Liked",$msg);
				}else{
					$update = $dbc->update("Camagru.gallery", "imageStatus='1'", "imageID=$liked");
					$ps = $dbc->prep($update,$dbc->dbCon);
				}
				$lkr = new User($dbc);
				$id = $lkr->getUser($_SESSION["userid"]);
				if ($ps->execute()) {
					echo "{\"msg\":\"done $limiter\"}";
				} else {
					echo 'failed..' . $ps->queryString;
				}
			} else {
				$liked = filter_input(INPUT_POST, "likedPic");
				$which = filter_input(INPUT_POST, "ltype");
				if ($which ==1){
					$values = ["'$liked'", "'$which'", "'{$_SESSION['userid']}'"];
					$add = $dbc->update($table, "{$Col[1]} = {$which}",
								" userID  = {$_SESSION['userid']}");
					$ps = $dbc->prep($add, $dbc->dbCon);
				}else{
					$update = $dbc->update("Camagru.gallery", "imageStatus='1'", "imageID=$liked");
					$ps = $dbc->prep($update,$dbc->dbCon);
				}
				
				if ($ps->execute()) {
					echo "{\"msg\":\"done $limiter $which \"}";
				} else {
					echo 'failed..' . $ps->queryString;
				}
			}
		} else {
			die(json_encode($rsp->errorInfo()));
		}
	
}
if (strlen(filter_input(INPUT_POST, "askLikes")) > 0) {
	$selection = ["count(imageID) as tot", "sum(comment_text) as likes"];
	$limiter = " imageID = :id GROUP BY imageID ";
	$q = $dbc->select($selection, $table, $limiter);
	$rsp = $dbc->prep($q, $dbc->dbCon);
	$rsp->bindParam("id", filter_input(INPUT_POST, "askLikes"));
	$fin = $rsp->execute();
	if ($fin) {
		echo json_encode($rsp->fetch());
	} else {
		echo json_encode([$rsp->errorInfo()]);
	}
}
} catch (Exception $exc) {
		echo json_encode(["msg"=> $exc->getMessage() . $exc->getTraceAsString(), 'Query'=> $dbc->dbCon->errorInfo(), "limiter:"=> $limiter]);
	}