<?php

    $projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
    require $projectRoot.'Sources/BackEnd/controller/relativePathController.php';

    session_start();
    //Global Variables
    $dbUsername = $_SESSION['dbUsername'];
    $pageTitle = "Camagru";
    $_SESSION['pageTypeCheck'] = 'mainPage';
		if (!isset($_SESSION['userid'])){
			header("location: ../../../../index.php");
		}
		//debug symbols
//		$_SESSION['userid'] = 2;
//		$_SESSION['dbEmail'] = "t@g.c";
//		$_SESSION['dbUsername'] = "timothy";
//		$_SESSION['confirmLogin'] = 1;

?>

<!--HTML Content-->
<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="UTF-8">
        <title><?php echo $pageTitle?></title>
        <link rel="stylesheet"
                href="../../css/main.css"
                type="text/css"
        />
    </head>
    <body>

        <?php include $headerTemplate?>
        <?php include $sectionMainTemplate?>
        <?php include $sectionAsideTemplate?>
        <?php include $footerTemplate?>
    </body>
</html>