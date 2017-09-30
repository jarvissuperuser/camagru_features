<?php

$projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
require $projectRoot . "Sources/BackEnd/controller/relativePathController.php";

//Validator function to check for injections
function ft_validator($userInputSample) {

	$userInputSample = trim($userInputSample);
	$userInputSample = stripslashes($userInputSample);
	$userInputSample = htmlspecialchars($userInputSample);
	return $userInputSample;
}

//Retrieve Username Function
function ft_username($email, $dbConn) {

	//Query DB for username
	$dbQuery = "SELECT userName, email FROM Camagru.users WHERE email like :email or userName like :email";
	$preparedStatement = $dbConn->prepare($dbQuery);
	$preparedStatement->bindParam(':email', $email);
	$preparedStatement->execute();
	$queryResult = $preparedStatement->fetchObject();
	$_SESSION['dbEmail'] = $queryResult->email;
	return $queryResult->userName;
}

//Login Functionality and Validation
function ft_userLogin($email, $password, $dbConn) {

	//Query DB for email and password
//	$dbQuery = "SELECT email FROM users WHERE email=:email AND password=:password";
//	$preparedStatement = $dbConn->prepare($dbQuery);
//	$preparedStatement->bindParam(':email', $email);
//	$preparedStatement->bindParam(':password', $password);
//	$preparedStatement->execute();
//	$queryResult = $preparedStatement->fetch();

	//$dbEmail = $queryResult[0];
	
	try {
		$dbUsername = ft_username($email, $dbConn);
		$email = $_SESSION['dbEmail'];
		$_SESSION['dbUsername'] = $dbUsername;
		$db = new DB_Control();
		$user = new User($db);
		$user->password = $password;
		$user->hashed = 1;
		$user->email = $email;
		$_SESSION['userid'] = $user->verify();
		//Validate DB and Login Email
		if ($_SESSION['userid']>0) {

			$_SESSION['confirmLogin'] = 1;
		} else {

			$_SESSION['confirmLogin'] = 0;
		}
	} catch (Exception $exc) {
		echo json_encode(["msg"=>$exc->getTraceAsString()]);
	}
}

//Registration Functionality and Validation
function ft_userRegister($username, $email, $password, $dbConn) {

	//Function Variables
	
	$veriStatBool = true;
	try{

	//Query for Username insert to DB
	$dbQuery = "INSERT INTO Camagru.users (email, password, userName, verificationStatus)
                VALUES (:email, :password, :userName, :verificationStatus)";
	$preparedStatement = $dbConn->prepare($dbQuery);
	$preparedStatement->bindParam(':email', $email);
	$preparedStatement->bindParam(':password', $password);
	$preparedStatement->bindParam(':userName', $username);
	$preparedStatement->bindParam(':verificationStatus', $veriStatBool);
	$preparedStatement->execute();
	}catch(Exception $ex){
		echo json_encode(["msg"=>$ex->getMessage()]);
	}

//        header("Location: ../FrontEnd/html/html_layout/main_layout.php");
}
