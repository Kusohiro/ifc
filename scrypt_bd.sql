create table `carro` (
	`ID` int(11) NOT NULL auto_increment,
    `nome` varchar(45) DEFAULT NULL,
    `valor` double DEFAULT NULL,
    `km` double DEFAULT NULL,
	`fabricação` date DEFAULT NULL,
    PRIMARY KEY (`ID`)
    )