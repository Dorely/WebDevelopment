<?php
require_once  $_SERVER['DOCUMENT_ROOT'].'/library/database.php';
$dbconn = dungeon_connection();
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST,"password");

//debugging output
echo 'Your login is '.$email.'<br>';
echo 'Your password is '.$password.'<br>';
echo 'Checking login<br>';
if (!isset($_SESSION)){
    echo 'No sessions started<br>';
}

$query = 'SELECT * FROM users WHERE email = :email and password = :password';
$statement = $dbconn->prepare($query);
$statement->bindValue(':email', $email);
$statement->bindValue(':password', $password);
$statement->execute();
$row = $statement->fetch();
$db_email = $row['email'];
$db_password = $row['password'];
$first_name = $row['first_name'];
$user_id = $row['user_id'];
$statement->closeCursor();

if($email == $db_email and $password == $db_password){
    echo 'Your Credentials match!';
    session_start();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['name'] = $first_name;
    header('location: userHome.php');
}else{
    echo 'Your Credentials didnt match';
    header('location: userDeny.php');
}