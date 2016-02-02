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

switch ($action) {
    case 'login':
        include('loginForm.php');
        break;
    case 'authenticate':
        $login = authenticate();
        if ($login) {
            include('userHome.php');
        } else {
            user_deny();
        }
        break;
    case 'signup':
        include('signupForm.php');
        break;
    case 'adduser':
        $results = add_user();
        if ($results == 'password_mismatch') {
            $first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_STRING);
            $last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $message = '<p class="error">Password don\'t match, try again</p>';
            include('signupForm.php');
            exit;
        } else if ($results == 'email_in_use') {
            $first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_STRING);
            $last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $message = '<p class="error">That email is already in use</p>';
            include('signupForm.php');
            exit;
        } else if ($results == 'account_created') {
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $message = '<p>Account created</p>';
            include('loginForm.php');
            exit;
        }
        break;
    case 'createcharacter':
        include('createCharacterForm.php');
        break;
    case 'addcharacter':
        $message = create_character();
        include('userHome.php');
        break;
    case 'editcharacter':
        include('characterForm.php');
        break;
    case 'loggedon':
        include('userHome.php');
        break;
    case 'logout':
        session_destroy();
        header('location: .');
        break;
    case 'deletecharacter':
        delete_character();
        header('location: .?action=loggedon');
        break;
    case 'savecharacter':
        $character_id = filter_input(INPUT_POST, 'character_id');
        $updated = update_character($character_id);
        include('characterForm.php');
        break;
    case 'manageaccount':
        include('manageAccount.php');
        break;
    case 'updateaccount':
        $message = update_account();
        include('manageAccount.php');
        break;
    case 'changepassword':
        $message = change_password();
        include('manageAccount.php');
        break;
    case 'feedback':
        include('feedbackForm.php');
        break;
    case 'feedbacksubmit':
        $message = store_feedback();
        include('feedbackForm.php');
        break;
    case 'about':
        include('about.php');
        break;
}