CREATE TABLE `TICKET` (
`ticketID` INT NOT NULL AUTO_INCREMENT ,
`applicationName` VARCHAR( 30 ) NOT NULL ,
`login` VARCHAR( 30 ) NOT NULL ,
`priority` TINYINT NOT NULL ,
`type` VARCHAR( 20 ) NOT NULL ,
`creationDate` VARCHAR( 20 )  NOT NULL ,
`oneLiner` VARCHAR( 80 ) NOT NULL ,
`detailedDescription` VARCHAR( 200 ) NOT NULL ,
`attachmentName` VARCHAR( 50 ) DEFAULT NULL ,
PRIMARY KEY ( `ticketID` ) ,
INDEX ( `applicationName` )
);
