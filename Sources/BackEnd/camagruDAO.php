<?php
ini_set('display_errors', 1);
    $projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
    require $projectRoot."Sources/BackEnd/controller/relativePathController.php";

    session_start();

    //Global Variables Scope
    $postSubmitField = $_SESSION['submitButton'];

    //Check connection to sever
    $dbConn = ft_getConnection($db_dsn, $db_user, $db_password);

    //Create Camagru DB if it doesn't exist.
    $dbQuery = ft_createDBQuery($db_name);
    $preparedStatement = $dbConn->prepare($dbQuery);
    $preparedStatement->execute();

    //Use DB
    $dbQuery = ft_useCamagru($db_name);
    $preparedStatement = $dbConn->prepare($dbQuery);
    $preparedStatement->execute();

    //Create Camagru tables

    //Create Users Table
    $dbQuery = ft_createUsersTableQuery($db_name);
    $preparedStatement = $dbConn->prepare($dbQuery);
    $preparedStatement->execute();

    //Create Gallery Table
    $dbQuery = ft_createGalleryTableQuery($db_name);
    $preparedStatement = $dbConn->prepare($dbQuery);
    $preparedStatement->execute();

    //Create Social Network Features Table
    $dbQuery = ft_createSNFTableQuery($db_name);
    $preparedStatement = $dbConn->prepare($dbQuery);
    $preparedStatement->execute();

        //Decisioning For Login and Registration
        //Decisioning For Login and Registration
        if ($postSubmitField == 'loginButtonParse') {

            //Gloabal Variables for Login
            $email = $_SESSION['email'];
            $password = $_SESSION['password'];

            //Parse Values to validationDTO
            ft_userLogin($email, $password, $dbConn);
            if ($_SESSION['confirmLogin'] == 1) {

                header("Location: ../FrontEnd/html/html_layout/main_layout.php");
            } else {

                header("Location: ../../index.php");
            }
        } elseif ($postSubmitField == 'registrationButtonParse') {

            //Global Variables for Registration
            $username = $_SESSION['username'];
            $email = $_SESSION['email'];
            $password = $_SESSION['password'];
            $rePassword = $_SESSION['re_password'];

            //Parse Values to validationDTO
            if ($password == $rePassword) {

                ft_userRegister($username, $email, $password, $dbConn);
                ft_userLogin($email, $password, $dbConn);
                if ($_SESSION['confirmLogin'] == 1) {

                    header("Location: ../FrontEnd/html/html_layout/main_layout.php");
                } else {

                    header("Location: ../../index.php");
                }
            } else {

                header("Location: ../../index.php");
            }
        }

//    session_destroy();