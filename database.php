<?php


$con = new Database();

if($con->query('show tables')->fetch())
    return;
    
$con->exec("
    CREATE TABLE IF NOT EXISTS client (
        id_client INT AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(20) NOT NULL,
        lastName VARCHAR(20) NULL
    ) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci	
");
    
$con->exec("
    CREATE TABLE IF NOT EXISTS specialist (
        id_specialist INT AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(20) NOT NULL,
        lastName VARCHAR(20) NULL
    ) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci	
");

$con->exec("
    CREATE TABLE IF NOT EXISTS ticket (
        id_ticket INT AUTO_INCREMENT PRIMARY KEY,
        completed TINYINT(1) NOT NULL DEFAULT '0',
        meetingTime DATETIME NULL,
        meetingEnds DATETIME NULL,
        id_specialist INT NOT NULL,
        id_client INT NOT NULL,
        position INT NULL
    ) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci	
");

    /**
     * DEMO duomenys apie specialistą
     */
$con->exec("
    INSERT INTO specialist 
        (firstName, lastName) 
    VALUES
        ('Tomas', 'Tomaitis')
");
$con->exec("
    INSERT INTO specialist 
        (firstName, lastName) 
    VALUES
        ('Julius', 'Julaitis')
");
$con->exec("
    INSERT INTO specialist 
        (firstName, lastName) 
    VALUES
        ('Gabija', 'Gabaitė')
");