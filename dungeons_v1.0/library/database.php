<?php

/*
 * Database connections  
 */
function dungeon_connection(){
    $server = 'localhost';
    $database = '';
    $username = '';
    $password = '';
    $dsn = 'mysql:host='.$server.';dbname='.$database;
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try{
        $db = new PDO($dsn, $username, $password, $options);
        return $db;
        //echo 'The Connection succeeded';
    } catch (PDOException $ex) {
        echo 'Connection failed';
    }
}
