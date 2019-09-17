<?php


$con = new Database();

if($con->query('show tables')->fetch())
    return;
    
$con->exec("
    CREATE TABLE IF NOT EXISTS client (
        id_client INT AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(20) NOT NULL,
        lastName VARCHAR(20) NULL,
        completed TINYINT(1) NOT NULL DEFAULT '0',
        meetingTime DATETIME NOT NULL
    )
");
