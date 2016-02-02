<?php

function authenticate() {
    $db = dungeon_connection();
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password");
    
    if($email == NULL || $email == false || $password == NULL || $password == false){
        return false;
    }
    
    $salt = '$6$!@#$%^&*()_+_)(*';
    $hashed_password = crypt($password,$salt);

    $query = 'SELECT * FROM users WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row = $statement->fetch();

    $db_password = $row['password'];
    $db_hashed_password = $row['hashed_password'];
    $first_name = $row['first_name'];
    $user_id = $row['user_id'];
    $statement->closeCursor();

    if($password == $db_password){
        $db_hashed_password = change_to_encrypted_password($user_id,$password);
    }
    
    if ($hashed_password == $db_hashed_password) {
        update_logins($user_id);
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $first_name;
        return true;
    } else {
        return false;
    }
}

function update_logins($user_id){
    $db = dungeon_connection();
    $query = 'UPDATE users SET
                number_of_logins = (number_of_logins + 1)
              WHERE user_id = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
}

function change_to_encrypted_password($user_id,$password){
    $db = dungeon_connection();
    $salt = '$6$!@#$%^&*()_+_)(*';
    $hashed_password = crypt($password,$salt);
    $query = 'UPDATE users SET
                password = NULL
               ,hashed_password = :hashed_password
              WHERE user_id = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':hashed_password', $hashed_password);
    $statement->execute();
    return $hashed_password;
}

function add_user() {
    $dbconn = dungeon_connection();
    $first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password");
    $confirm_password = filter_input(INPUT_POST, "confirm_password");

    if ($password != $confirm_password) {

        return "password_mismatch";
    } else {
        $query = 'SELECT * FROM users WHERE email = :email';
        $statement1 = $dbconn->prepare($query);
        $statement1->bindValue(':email', $email);
        $statement1->execute();
        $row = $statement1->fetch();
        $statement1->closeCursor();

        if (empty($row)) {
            //echo 'that account can be created';
            $query = 'Insert into users values(NULL,:first_name,:last_name,:email,:password,0,\'USER\')';
            $statement2 = $dbconn->prepare($query);
            $statement2->bindValue(':first_name', $first_name);
            $statement2->bindValue(':last_name', $last_name);
            $statement2->bindValue(':email', $email);
            $statement2->bindValue(':password', $password);
            $statement2->execute();
            $statement2->closeCursor();

            return 'account_created';
        } else {

            return 'email_in_use';
        }
    }
}

function sign_in() {
    
}

function user_deny() {
    $message = '<p class="error">Login Failed</p>';
    include('loginForm.php');
}

function get_user_data($user_id) {
    $dbconn = dungeon_connection();

    $query = 'SELECT * FROM users WHERE user_id = :user_id';
    $statement = $dbconn->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    $user_row = $statement->fetch();
    $statement->closeCursor();

    return $user_row;
}

function update_account() {
    $dbconn = dungeon_connection();

    $user_id = filter_input(INPUT_POST, 'user_id');
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($user_id == FALSE || $user_id == NULL || $first_name == FALSE || $first_name == NULL || $last_name == FALSE || $last_name == NULL || $email == FALSE || $email == NULL) {
        return '<p class="error">Something went wrong, try again</p>';
    } else {
        $query = 'UPDATE users SET
                  first_name = :first_name
                 ,last_name =  :last_name
                 ,email =      :email
                 WHERE user_id = :user_id';
        $statement = $dbconn->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->bindValue(':email', $email);
        try {
            $statement->execute();
            session_start();
            $_SESSION['name'] = $first_name;
            return '<p>Account Updated</p>';
        } catch (PDOException $ex) {
            return '<p class="error">Email already taken</p>';
        }
    }
}

function change_password() {
    $dbconn = dungeon_connection();
    
    $salt = '$6$!@#$%^&*()_+_)(*';
    

    $user_id = filter_input(INPUT_POST, 'user_id');
    $old_password = filter_input(INPUT_POST, 'old_password');
    $new_password = filter_input(INPUT_POST, 'new_password');
    $confirm_password = filter_input(INPUT_POST, 'confirm_password');

    if ($user_id == FALSE || $user_id == NULL || $old_password == FALSE || $old_password == NULL || $new_password == FALSE || $new_password == NULL || $confirm_password == FALSE || $confirm_password == NULL) {
        return '<p class="error">Something went wrong, try again</p>';
    } else {
        $query = 'SELECT * FROM users WHERE user_id = :user_id';
        $statement = $dbconn->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $user_data = $statement->fetch();

        $db_password = $user_data['hashed_password'];

        if ($db_password == crypt($old_password,$salt)) {
            if ($new_password == $confirm_password) {
                $query = 'UPDATE users SET
                  hashed_password = :password
                 WHERE user_id = :user_id';
                $statement = $dbconn->prepare($query);
                $statement->bindValue(':user_id', $user_id);
                $statement->bindValue(':password', crypt($new_password,$salt));
                try {
                    $statement->execute();
                    return '<p>Password Changed</p>';
                } catch (PDOException $ex) {
                    return '<p class="error">A database error occurred, try again</p>';
                }
            } else {
                return '<p class="error">You mistyped your new password in one of the fields</p>';
            }
        } else {
            return '<p class="error">Your old password does not match what is on record</p>';
        }
    }
}

function store_feedback() {
    $dbconn = dungeon_connection();

    $user_id = filter_input(INPUT_POST, 'user_id');
    $feedback = filter_input(INPUT_POST, 'feedback');

    if ($user_id == NULL || $user_id == FALSE || $feedback == NULL || $feedback == FALSE) {
        return '<p class="error">Cannot submit nothing</p>';
    } else {
        $query = 'INSERT INTO feedback VALUES
              (NULL
              ,:user_id
              ,:feedback
              ,\'1\')';
        $statement = $dbconn->prepare($query);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':feedback', $feedback);
        try {
            $statement->execute();
            return '<p>Feedback submitted</p>';
        } catch (PDOException $ex) {
            return '<p class="error">A database error occurred, try again</p>';
        }
    }
}
