<?php

    $projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
    require $projectRoot.'Sources/BackEnd/controller/relativePathController.php';

        //Create USE DB query
        function ft_useCamagru($db_name) {

            $dbQuery = "USE $db_name";
            return $dbQuery;
        }

        //Create Camagru if it doesn't exist query
        function ft_createDBQuery($db_name) {

            $dbQuery = "CREATE DATABASE IF NOT EXISTS $db_name";
            return $dbQuery;
        }

        //Create users Table query
        function ft_createUsersTableQuery($db_name) {

            $dbQuery = "CREATE TABLE IF NOT EXISTS users (
            email VARCHAR(72) NOT NULL,
            password VARCHAR(66),
            userName VARCHAR(30),
            userID INT(8) NOT NULL AUTO_INCREMENT,
            verificationStatus BOOLEAN,
            PRIMARY KEY (userID),
            UNIQUE (email, userName));";
            return $dbQuery;
        }

        //Create gallery table query
        function ft_createGalleryTableQuery($db_name) {

            $dbQuery = "CREATE TABLE IF NOT EXISTS gallery (
            imageID INT(8) NOT NULL AUTO_INCREMENT	,
            imageTitle VARCHAR(66),
            userID INT(8) NOT NULL,
            imageStatus BOOLEAN,
            creationDate TIMESTAMP,
            PRIMARY KEY (imageID));";
            return $dbQuery;
        }

        //Create Social Network Features table query
        function ft_createSNFTableQuery($db_name) {

            $dbQuery = "CREATE TABLE IF NOT EXISTS socialNetworks (
										uniqueID INT(8) NOT NULL AUTO_INCREMENT,
                    imageID INT(8) NOT NULL,
                    comment_text VARCHAR(500),
                    userID INT(8) NOT NULL,
                    upvoteDate TIMESTAMP ,
                    PRIMARY KEY (uniqueID));";
            return $dbQuery;
        }