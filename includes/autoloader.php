<?php

spl_autoload_register("myAutoloader");

/**
 * Autoloader for Classes
 *
 * @param String $className
 */
function myAutoloader(String $className)
{
    $path = "classes/";
    $ext = ".php";
    $fullPath = $path . $className . $ext;

    if(!file_exists($fullPath)){
        return false;
    }

    include_once($fullPath);
}