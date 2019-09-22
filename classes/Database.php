<?php

class Database extends PDO
{
    public function __construct()
    {
        $ini = parse_ini_file(getcwd().'\config.ini');

        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ); 

        try{
            $pdo = parent::__construct('mysql:host='.$ini['db_host'].';dbname='.$ini['db_name'], $ini['db_user'], $ini['db_password'], $options);
            return $pdo;
        } catch(PDOException $e){
            die('
            <div class="alert alert-danger" role="alert">
                Nepavyksta prisijungti prie duomenų bazės, pašome patikrinti config, failą.
            </div>
            ');
        }
    }
}
