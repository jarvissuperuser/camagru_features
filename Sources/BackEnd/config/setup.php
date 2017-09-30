<?php
    //Setup Relative Root
    $projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
    require $projectRoot."Sources/BackEnd/controller/relativePathController.php";

		session_start();
		//ini_set("display_errors", "on");
    //Key Variables
    $db_dsn = $GLOBALS['DB_DSN'];
    $db_user = $GLOBALS['DB_USER'];
    $db_password = $GLOBALS['DB_PASSWORD'];
    $db_name = $GLOBALS['DB_NAME'];
//		
//		ini_set("display_errors",1);
//		error_reporting(E_ALL);

    //Get Connection Function
    function ft_getConnection ($db_dsn, $db_user, $db_password) {

        //Try Catch to ID Possible connection failures
        try {

            $dbConn = new PDO($db_dsn, $db_user, $db_password);
            $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConn;
        } catch (PDOException $e) {

            echo "Connection Failure Due To: ".$e->getMessage().PHP_EOL;
        }
    }