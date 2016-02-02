<?php

/*
 * This is the Model view controller file
 * and contains connections to the database, account functions, and character functions
 */
require_once('../library/database.php');
require_once('../library/character.php');
require_once('../library/account.php');
if (session_status() == PHP_SESSION_ACTIVE) {
    session_start();
    $user_id = $_SESSION['user_id'];
}

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'login';
        if (session_status() == PHP_SESSION_ACTIVE) {
            header('location: .?action=loggedon');
        }
    }
}

if ($action == 'login') {
    include('loginForm.php');
} else if ($action == 'authenticate') {
    $login = authenticate();
    if ($login) {
        include('userHome.php');
    } else {
        user_deny();
    }
} else if ($action == 'signup') {
    include('signupForm.php');
} else if ($action == 'adduser') {
    $results = add_user();
    if ($results == 'password_mismatch') {
        echo '<p class="error">Password don\'t match, try again</p>';
        include('signupForm.php');
    } else if ($results == 'email_in_use') {
        echo '<p class="error">That email is already in use</p>';
        include('signupForm.php');
    } else if ($results == 'account_created') {
        echo 'Account created';
        include('loginForm.php');
    }
} else if ($action == 'createcharacter') {
    include('createCharacterForm.php');
} else if ($action == 'addcharacter') {
    create_character();
    include('userHome.php');
} else if ($action == 'loggedon') {
    include('userHome.php');
} else if ($action == 'logout') {
    session_destroy();
    header('location: .');
} else if ($action == 'deletecharacter') {
    delete_character();
    echo 'Character deleted';
    header('location: .?action=loggedon');
} else if ($action == 'editcharacter') {
    include('characterForm.php');
} else if ($action == 'savecharacter') {
    $character_id = filter_input(INPUT_POST, 'character_id');
    $updated = update_character($character_id);
    include('characterForm.php');
}

