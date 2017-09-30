CREATE DATABASE	IF NOT EXISTS Camagru;
CREATE TABLE IF NOT EXISTS Camagru.`users` (
	`email` varchar(72) NOT NULL ,
	`password` varchar(66),
	`verificationStatus` CHAR,
	`userID` INT NOT NULL AUTO_INCREMENT,
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
DROP function IF EXISTS `Camagru`.`likes`;
CREATE FUNCTION `Camagru`.`likes`(id_ numeric) RETURNS int(11)
BEGIN
Declare vData Integer Default 0;
select count(comment_text) into vData FROM Camagru.socialNetworks 
WHERE imageID = id_ and type_ = 'l'  GROUP BY imageID;
RETURN vData;
END;


DROP function IF EXISTS `Camagru`.`composer`;
CREATE FUNCTION `Camagru`.`composer`(id_ integer) RETURNS varchar(80) CHARSET latin1
BEGIN
declare cmp varchar(80) default "mugadzatt01@gmail.com";
select email into cmp from users where userID=id_;
RETURN cmp;
END; 

CREATE OR REPLACE VIEW `Camagru`.`images` AS
SELECT 
`Camagru`.`gallery`.`imageID` AS `imageID`,
`Camagru`.`gallery`.`imageTitle` AS `imageTitle`,
`Camagru`.`gallery`.`imageStatus` AS `imageStatus`,
`Camagru`.`gallery`.`userID` AS `userID`,
`Camagru`.`gallery`.`creationDate` AS `creationDate`,
`Camagru`.LIKES(`Camagru`.`gallery`.`imageID`) AS `likes`,
`Camagru`.composer(`Camagru`.`gallery`.`userID`) as `composer`
FROM
`Camagru`.`gallery`;