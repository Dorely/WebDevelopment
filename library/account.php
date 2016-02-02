<?php

function signup($first_name, $last_name, $email, $password1, $password2, $user_name) {
    global $db;

    //echo ' Signup Function Entered ';
    //check if passwords match
    //echo ' checking password ';
    if ($password1 != $password2) {
        //echo 'password';
        return 'password';
    }

    //check if email is in the system already
    //echo ' checking email ';
    $bad_email = check_email($email);
    if ($bad_email) {
        //echo 'email';
        return 'email';
    }

    //check if username already exists
    //echo ' checking username ';
    $bad_username = check_username($user_name);
    if ($bad_username) {
        //echo ' username ';
        return 'username';
    }
    $user_type = 'user';

    //echo ' Starting query ';
    
    //echo ' attempting password hash ';
    $hashed_password = password_hash($password1, PASSWORD_BCRYPT);
    //echo ' password hash successful ';
    $query = 'INSERT INTO users VALUES (NULL, :user_type, :first_name, :last_name, :email, :user_name, :password, NULL)';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_type', $user_type);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':user_name', $user_name);
    $statement->bindValue(':password', $hashed_password);

    //var_dump($statement);
    //echo 'Query Ready';
    try {
        //echo 'Attempting query';
        $statement->execute();
        //echo 'success';
        return 'success';
    } catch (PDOException $ex) {
        //echo 'database error';
        //echo $ex;
        return 'error';
    }
}

function login($email, $password) {
    global $db;
    $query = 'select * from users where email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return 'error';
    }

    $results = $statement->fetch();
    $statement->closeCursor();

    if ($results == false) {
        return 'email';
    } elseif (!password_verify($password, $results['password'])) {
        //var_dump($results);
        return 'password';
    } else {
        return $results;
    }
}

function check_email($email, $user_id = NULL) {
    global $db;

    if($user_id == NULL){
        $query = 'select email from users where email = :email';
    }else{
        $query = 'select email from users where email = :email and user_id != :user_id';
    }
    
    
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    if($user_id != NULL){
        $statement->bindValue(':user_id', $user_id);
    }
    
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return FALSE;
    }

    $results = $statement->fetch();
    $statement->closeCursor();

    //var_dump($results);
    
    if ($results != false) {
        return true;
    } else {
        return false;
    }
}

function check_username($user_name) {
    global $db;

    $query = 'select user_name from users where user_name = :user_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return false;
    }

    $results = $statement->fetch();
    $statement->closeCursor();

    //var_dump($results);
    if ($results != FALSE) {
        return true;
    } else {
        return false;
    }
}

function get_user_details($user_id){
    global $db;
    
    $query = 'SELECT * FROM users WHERE user_id = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return 'error';
    }
    
    $results = $statement->fetch();
    $statement->closeCursor();
    
    return $results;
    
}

function update_account($user_id,$first_name,$last_name,$email){
    global $db;
    
    $check_email = check_email($email, $user_id);
    if($check_email == true){
        return 'email';
    }
    
    
    $query = 'UPDATE users SET '
            . 'first_name = :first_name '
            . ', last_name = :last_name '
            . ', email = :email '
            . 'WHERE user_id = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $statement->bindValue(':email', $email);
    
    try {
        $statement->execute();
        return 'success';
    } catch (PDOException $ex) {
        return 'error';
    }
    
}

function change_password($user_id,$oldpassword,$newpassword){
    global $db;
    
    $check_password = check_password($oldpassword, $user_id);
    if($check_password == false){
        return 'password';
    }
    
    $hashed_password = password_hash($newpassword, PASSWORD_BCRYPT);
    $query = 'UPDATE users SET '
            . 'password = :password '
            . 'WHERE user_id = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':password', $hashed_password);
    
    try {
        $statement->execute();
        return 'success';
    } catch (PDOException $ex) {
        return 'error';
    }
    
}

function check_password($password, $user_id) {
    global $db;

    
    $query = 'select * from users where user_id = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    
    
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        //echo 'Check failed';
        return false;
    }

    $results = $statement->fetch();
    $statement->closeCursor();

    //var_dump($results);
    
    
    if (password_verify($password, $results['password']) ) {
        //echo 'Password check returning true';
        return true;
    } else {
        //echo 'Password check returning false';
        return false;
    }
}