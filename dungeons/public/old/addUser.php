<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/library/database.php';
$dbconn = dungeon_connection();
$first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_STRING);
$last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password");
$confirm_password = filter_input(INPUT_POST, "confirm_password");

if ($password != $confirm_password) {
    echo '<p class="error">Password don\'t match, try again</p>';
    include('signup.php');
} else {
    $query = 'SELECT * FROM users WHERE email = :email';
    $statement1 = $dbconn->prepare($query);
    $statement1->bindValue(':email', $email);
    $statement1->execute();
    $row = $statement1->fetch();
    $statement1->closeCursor();

    if (empty($row)) {
        //echo 'that account can be created';
        $query = 'Insert into users values(NULL,:first_name,:last_name,:email,:password)';
        $statement2 = $dbconn->prepare($query);
        $statement2->bindValue(':first_name', $first_name);
        $statement2->bindValue(':last_name', $last_name);
        $statement2->bindValue(':email', $email);
        $statement2->bindValue(':password', $password);
        $statement2->execute();
        $statement2->closeCursor();
        echo 'Account created';
        include('index.php');
    } else {
        echo '<p class="error">That email is already in use</p>';
        include('signup.php');
    }
}