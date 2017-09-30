CREATE DATABASE	IF NOT EXISTS Camagru;
CREATE TABLE IF NOT EXISTS Camagru.`users` (
	`email` varchar(72) NOT NULL AUTO_INCREMENT,
	`password` varchar(66),
	`verificationStatus` CHAR,
	`userID` INT NOT NULL,
	`userName` varchar(30) NOT NULL,
	PRIMARY KEY (`userID`),
	UNIQUE (`email`, `userName`)
);

CREATE TABLE IF NOT EXISTS Camagru.`gallery` (
	`imageID` int NOT NULL AUTO_INCREMENT,
	`imageTitle` varchar(66),
	`userID` int NOT NULL,
	`imageStatus` int(2) NOT Null Default 0,
	`creationDate` datetime,
	PRIMARY KEY (`imageID`)
);

CREATE TABLE IF NOT EXISTS Camagru.`socialNetworks` (
	`imageID` int NOT NULL,
	`uniqueID` int NOT NULL AUTO_INCREMENT,
	`comment_text` VARCHAR(200),
    `type_` varchar(2),
	`userID` int NOT NULL,
	`upvoteDate` TIMESTAMP,
	PRIMARY KEY (`uniqueID`)
);


USE `Camagru`;
DROP function IF EXISTS `likes`;

DELIMITER $$
USE `Camagru`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `likes`(id_ numeric) RETURNS int(11)
BEGIN
	Declare vData Integer Default 0;
	select count(comment_text) into vData FROM Camagru.socialNetworks 
		WHERE imageID = id_ and type_ = 'l'  GROUP BY imageID;
RETURN vData;
END$$

DROP function IF EXISTS `composer`;

DELIMITER $$
USE `Camagru`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `composer`(id_ integer) RETURNS varchar(80) CHARSET latin1
BEGIN
	declare cmp varchar(80) default "mugadzatt01@gmail.com";
    select email into cmp from users where userID=id_;
RETURN cmp;
END$$

CREATE 
     OR REPLACE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `Camagru`.`images` AS
    SELECT 
        `Camagru`.`gallery`.`imageID` AS `imageID`,
        `Camagru`.`gallery`.`imageTitle` AS `imageTitle`,
        `Camagru`.`gallery`.`imageStatus` AS `imageStatus`,
        `Camagru`.`gallery`.`userID` AS `userID`,
        `Camagru`.`gallery`.`creationDate` AS `creationDate`,
        LIKES(`Camagru`.`gallery`.`imageID`) AS `likes`,
        composer(`Camagru`.`gallery`.`userID`) as `composer`
    FROM
        `Camagru`.`gallery`;



