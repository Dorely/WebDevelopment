<?php
session_start();
$user_id = $_SESSION['user_id'];

require_once $_SERVER['DOCUMENT_ROOT'] . '/library/database.php';
$dbconn = dungeon_connection();
$character_name = filter_input(INPUT_POST,'character_name');
$character_class = filter_input(INPUT_POST,'character_class');
$character_race = filter_input(INPUT_POST,'character_race');


if($character_name == null || $character_name == false ||
   $character_class == null || $character_class == false || 
   $character_race == null || $character_race == false){
    echo 'Invalid Data, try again';
    include('createCharacterForm.php');
}else{
    $insert = 'INSERT INTO characters 
              (character_id
              ,user_id
              ,character_name
              ,class
              ,level
              ,race)
              VALUES
              (NULL
              ,:user_id
              ,:character_name
              ,:character_class
              ,\'1\'
              ,:character_race)';
    $statement1 = $dbconn->prepare($insert);
    $statement1->bindValue(':user_id', $user_id);
    $statement1->bindValue(':character_name', $character_name);
    $statement1->bindValue(':character_class', $character_class);
    $statement1->bindValue(':character_race', $character_race);
    $statement1->execute();
    
    echo 'Character Created';
    include('userHome.php');
}