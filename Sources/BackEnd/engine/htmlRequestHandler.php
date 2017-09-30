<?php

    $projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
    require $projectRoot."Sources/BackEnd/controller/relativePathController.php";

    //Initialize Session
    session_start();

    //Global Variables
    $indexButtonCheck = $_POST['submitFormButton'];
    $_SESSION['submitButton'] = $_POST['submitFormButton'];

        //Check Post value for loginButton name
        if ($indexButtonCheck == "loginButtonParse") {

            //Gather Required Session Variables
            $_SESSION['email'] = ft_validator($_POST['email']);
            $_SESSION['password'] = hash("sha256", ft_validator($_POST['passwordName']));

            //If Login redirect to DAO
            header("Location: ../camagruDAO.php");
        } elseif ($indexButtonCheck == "registrationButtonParse") {

            //Gather Required Session Variables
            $_SESSION['username'] = ft_validator($_POST['userName']);
            $_SESSION['email'] = ft_validator($_POST['email']);
            $_SESSION['password'] = hash("sha256", ft_validator($_POST['passwordName']));
            $_SESSION['re_password'] = hash("sha256", ft_validator($_POST['repeatPasswordName']));

            //If Registration redirect to DAO
            header("Location: ../camagruDAO.php");
        }

