<?php

/*
 * This is the Model view controller file
 * and contains connections to the database and the model functions
 * 
 * 
 * TODO 
 * 
 * 
 * Add easy add for collections
 * Card details view for collections
 * Revamp CSS
 * Trade Calculator
 */
require_once('../library/database.php');
require_once('../library/account.php');
require_once('../library/collections.php');
require_once('../library/cards.php');
require_once('../library/password.php');

$lifetime = 60 * 60 * 24 * 365; // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();

$db = magic_connection();
$sets = get_sets();

if (isset($_SESSION['user_id'])) {
    $collections = get_collections($_SESSION['user_id']);
}

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}

switch ($action) {
    case 'Search' :
        $row_count = 0;
        $page = 1;
        $searchtype = filter_input(INPUT_GET, 'searchtype', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
        $searchstring = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);

        $colors = filter_input(INPUT_GET, 'colors', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
        $colortype = filter_input(INPUT_GET, 'colortype', FILTER_VALIDATE_INT);

        $set_id = filter_input(INPUT_GET, 'set_id', FILTER_VALIDATE_INT);
        $searchbyset = filter_input(INPUT_GET, 'searchbyset', FILTER_VALIDATE_INT);

        $search_results = card_search(0, 50, $searchtype, $searchstring, $colors, $colortype, $set_id, $searchbyset);

        if ($searchtype == NULL) {
            $searchtype = array();
        }
        if ($colors == NULL) {
            $colors = array();
        }

        if ($search_results == 'error') {
            $messge = 'An error occurred';
            include 'home.php';
        } else {
            include 'searchResults.php';
        }

        break;

    case 'ChangePage' :
        $searchtype = filter_input(INPUT_GET, 'searchtype', FILTER_SANITIZE_STRING);
        $searchtype = explode(',', $searchtype);
        $searchstring = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
        $colors = filter_input(INPUT_GET, 'colors', FILTER_SANITIZE_STRING);
        $colors = explode(',', $colors);
        $colortype = filter_input(INPUT_GET, 'colortype', FILTER_VALIDATE_INT);
        $set_id = filter_input(INPUT_GET, 'set_id', FILTER_VALIDATE_INT);
        $searchbyset = filter_input(INPUT_GET, 'searchbyset', FILTER_VALIDATE_INT);

        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $row_count = 0;
        if ($page == 1) {
            $start = 0;
            $end = 50;
        } else {
            if ($page > 0) {
                $start = ($page * 50) - 49;
                $end = 50;
            } else {
                $start = 0;
                $end = 50;
            }
        }

        $search_results = card_search($start, $end, $searchtype, $searchstring, $colors, $colortype, $set_id, $searchbyset);

        include 'searchResults.php';
        break;

    case 'details':
        $card_name = filter_input(INPUT_GET, 'cardname');
        $set_id = filter_input(INPUT_GET, 'setid', FILTER_VALIDATE_INT);
        $variation = filter_input(INPUT_GET, 'variation', FILTER_VALIDATE_INT);
        //var_dump($card_name);
        if (!empty($variation)) {
            //echo 'variation not empty';
            $card = get_card_details($card_name, $set_id, $variation);
        } else {
            //echo 'variation empty';
            $card = get_card_details($card_name, $set_id);
        }
        include 'cardDetails.php';
        break;

    case 'signupform':
        include 'signup.php';
        break;

    case 'signup':
        $first_name = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $last_name = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $user_name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING);
        $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);

        if ($first_name == NULL || $last_name == NULL || $email == NULL || $password1 == NULL || $password2 == NULL || $user_name == NULL ||
                $first_name == FALSE || $last_name == FALSE || $email == FALSE || $password1 == FALSE || $password2 == FALSE || $user_name == FALSE) {
            $message = 'No Fields can be blank';
            include 'signup.php';
        } else {
            $message = signup($first_name, $last_name, $email, $password1, $password2, $user_name);
            if ($message == 'password') {
                $message = 'Your passwords did not match';
                include 'signup.php';
            } elseif ($message == 'email') {
                $message = 'That email already exists in the system';
                include 'signup.php';
            } elseif ($message == 'username') {
                $message = 'That username already exists in the system';
                include 'signup.php';
            } elseif ($message == 'error') {
                $message = 'An error occurred with the database';
                include 'signup.php';
            } elseif ($message == 'success') {
                $message = 'Signup successful';
                include 'home.php';
            } else {
                $message = 'This should not be showing';
                include 'signup.php';
            }
        }
        break;

    case 'login':
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if ($email == NULL || $email == FALSE || $password == NULL || $password == FALSE) {
            $message = 'No Fields can be empty';
            include 'home.php';
        } else {
            $result = login($email, $password);
            if ($result == 'email') {
                $message = 'That email does not exist in the system';
            } elseif ($result == 'password') {
                $message = 'Wrong password';
            } elseif ($result == 'error') {
                $message = 'An error occurred';
            } else {
                $user_data = $result;
                $_SESSION['user_id'] = $user_data['user_id'];
                $_SESSION['user_name'] = $user_data['user_name'];
                $_SESSION['user_type'] = $user_data['user_type'];
                $message = 'Welcome back!';
            }
            include 'home.php';
        }
        break;

    case 'logout':
        $_SESSION = array();
        session_destroy();
        include 'home.php';
        break;

    case 'managecollections':
        if (isset($_SESSION['user_name'])) {
            $collections = get_collections($_SESSION['user_id']);
            include 'manageCollections.php';
        } else {
            $message = 'Please sign in to manage collections';
            include 'home.php';
        }
        break;

    case 'manageaccount':
        if (isset($_SESSION['user_name'])) {
            $user = get_user_details($_SESSION['user_id']);
            if ($user == 'error') {
                $message = 'A Database error occurred.';
                include 'home.php';
            } else {
                include 'accountManagement.php';
            }
        } else {
            $message = 'Please sign in to manage your account';
            include 'home.php';
        }
        break;

    case 'editaccount':
        $user_id = $_SESSION['user_id'];
        $first_name = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $last_name = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);


        if ($user_id == NULL || $user_id == FALSE || $first_name == NULL || $first_name == FALSE || $last_name == NULL || $last_name == FALSE || $email == NULL || $email == FALSE) {
            $user = get_user_details($_SESSION['user_id']);
            $message = 'No Fields can be blank';
            include 'accountManagement.php';
        } else {
            $result = update_account($user_id, $first_name, $last_name, $email);
            if ($result == 'error') {
                $user = get_user_details($_SESSION['user_id']);
                $message = 'An error occurred';
                include 'accountManagement.php';
            } elseif ($result == 'email') {
                $user = get_user_details($_SESSION['user_id']);
                $message = 'That email already exists in the system';
                include 'accountManagement.php';
            } else {
                $user = get_user_details($_SESSION['user_id']);
                $message = 'Account updated';
                include 'accountManagement.php';
            }
        }

        break;

    case 'changepassword':
        $user_id = $_SESSION['user_id'];
        $oldpassword = filter_input(INPUT_POST, 'oldpassword', FILTER_SANITIZE_STRING);
        $newpassword = filter_input(INPUT_POST, 'newpassword', FILTER_SANITIZE_STRING);
        $repeatpassword = filter_input(INPUT_POST, 'repeatpassword', FILTER_SANITIZE_STRING);


        if ($user_id == NULL || $user_id == FALSE || $oldpassword == NULL || $oldpassword == FALSE || $newpassword == NULL || $newpassword == FALSE || $repeatpassword == NULL || $repeatpassword == FALSE) {
            $user = get_user_details($_SESSION['user_id']);
            $message = 'No Fields can be blank';
            include 'accountManagement.php';
        } else {
            if ($newpassword != $repeatpassword) {
                $user = get_user_details($_SESSION['user_id']);
                $message = 'The new passwords did not match';
                include 'accountManagement.php';
            } else {
                $result = change_password($user_id, $oldpassword, $newpassword);
                if ($result == 'error') {
                    $user = get_user_details($_SESSION['user_id']);
                    $message = 'An error occurred while attempting to change your password';
                    include 'accountManagement.php';
                } elseif ($result == 'password') {
                    $user = get_user_details($_SESSION['user_id']);
                    $message = 'That Password did not match your current password';
                    include 'accountManagement.php';
                } elseif ($result == 'success') {
                    $user = get_user_details($_SESSION['user_id']);
                    $message = 'Password changed';
                    include 'accountManagement.php';
                }
            }
        }

        break;

    case 'collection':
        $collection_id = filter_input(INPUT_GET, 'collectionid', FILTER_VALIDATE_INT);

        if ($collection_id == NULL || $collection_id == FALSE) {
            $message = 'That Collection doesnt exist';
            include 'home.php';
        } else {
            $collection = get_collection($collection_id);
            $ownerinfo = get_owner($collection_id);
            $editview = filter_input(INPUT_GET, 'editview', FILTER_VALIDATE_BOOLEAN);
            $edit = false;
            $owner = false;
            $public = $collection['is_public'];
            if (isset($_SESSION['user_id'])) {
                if ($collection['user_id'] == $_SESSION['user_id']) {
                    $owner = true;
                }
                if ($editview) {
                    $edit = true;
                }
            }
            if (!$owner && !$public) {
                $message = 'That Collection is private';
                include 'home.php';
            } else {
                $likes = get_likes($collection_id);
                $collection_items = get_collection_items($collection_id);
                include 'collectionView.php';
            }
        }

        break;

    case 'like':
        $collection_id = filter_input(INPUT_POST, 'collectionid', FILTER_VALIDATE_INT);
        $user_id = filter_input(INPUT_POST, 'userid', FILTER_VALIDATE_INT);

        if ($collection_id == NULL || $collection_id == FALSE || $user_id == NULL || $user_id == false) {
            $message = 'Something went wrong with the input';
            include 'home.php';
        } else {
            $collection = get_collection($collection_id);
            $ownerinfo = get_owner($collection_id);
            $editview = filter_input(INPUT_GET, 'editview', FILTER_VALIDATE_BOOLEAN);
            $edit = false;
            $owner = false;
            $public = $collection['is_public'];
            if (isset($_SESSION['user_id'])) {
                if ($collection['user_id'] == $_SESSION['user_id']) {
                    $owner = true;
                }
                if ($editview) {
                    $edit = true;
                }
            }
            if (!$owner && !$public) {
                $message = 'That Collection is private';
                include 'home.php';
            } else {
                $message = like($collection_id, $user_id);
                $likes = get_likes($collection_id);

                $collection_items = get_collection_items($collection_id);
                include 'collectionView.php';
            }
        }

        break;

    case 'createcollection':
        if (isset($_SESSION['user_name'])) {
            $collections = get_collections($_SESSION['user_id']);
            $collection_name = filter_input(INPUT_POST, 'collectionname', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $public = filter_input(INPUT_POST, 'public', FILTER_VALIDATE_INT);
            if ($public == NULL || $public == false) {
                $public = 0;
            }
            $user_id = $_SESSION['user_id'];

            if ($collection_name == NULL || $collection_name == false) {
                $message = 'Collection name cannot be empty';
                include 'manageCollections.php';
            } else {
                if ($description == NULL || $description == false) {
                    $message = add_collection($user_id, $collection_name, $public);
                } else {
                    $message = add_collection($user_id, $collection_name, $public, $description);
                }
                if ($message == 'error') {
                    $message = 'A database error occurred';
                } elseif ($message == 'success') {
                    $message = 'Collection added';
                }
                $collections = get_collections($_SESSION['user_id']);
                include 'manageCollections.php';
            }
        } else {
            $message = 'Please sign in to manage collections';
            include 'home.php';
        }
        break;

    case 'editcollection':
        if (isset($_SESSION['user_name'])) {
            $collections = get_collections($_SESSION['user_id']);
            $collection_id = filter_input(INPUT_POST, 'collection_id', FILTER_VALIDATE_INT);
            $collection_name = filter_input(INPUT_POST, 'collectionname', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $priority = $public = filter_input(INPUT_POST, 'priority', FILTER_VALIDATE_INT);
            $public = filter_input(INPUT_POST, 'public', FILTER_VALIDATE_INT);
            if ($public == NULL || $public == false) {
                $public = 0;
            }
            if ($priority == NULL || $priority == false) {
                $priority = NULL;
            }

            if ($collection_name == NULL || $collection_name == false) {
                $message = 'Collection name cannot be empty';
                include 'manageCollections.php';
            } elseif ($collection_id == NULL || $collection_id == false) {
                $message = 'Something went wrong, try again';
                include 'manageCollections.php';
            } else {

                $message = edit_collection($collection_id, $collection_name, $public, $description, $priority);

                if ($message == 'error') {
                    $message = 'A database error occurred';
                } elseif ($message == 'success') {
                    $message = 'Changes Saved';
                }
                $collections = get_collections($_SESSION['user_id']);
                include 'manageCollections.php';
            }
        } else {
            $message = 'Please sign in to manage collections';
            include 'home.php';
        }
        break;

    case 'deletecollection':
        if (isset($_SESSION['user_name'])) {
            $collections = get_collections($_SESSION['user_id']);
            $collection_id = filter_input(INPUT_POST, 'collection_id', FILTER_VALIDATE_INT);

            if ($collection_id == NULL || $collection_id == false) {
                $message = 'Something went wrong, try again';
                include 'manageCollections.php';
            } else {
                $message = delete_collection($collection_id);

                if ($message == 'error') {
                    $message = 'A database error occurred';
                } elseif ($message == 'success') {
                    $message = 'Collection Deleted';
                }
                $collections = get_collections($_SESSION['user_id']);
                include 'manageCollections.php';
            }
        } else {
            $message = 'Please sign in to manage collections';
            include 'home.php';
        }
        break;

    //this case is for an ajax function - therefore it doesnt include any views
    case 'addcollectionitem':
        if (isset($_SESSION['user_id'])) {
            $collection_id = filter_input(INPUT_GET, 'collection_id', FILTER_VALIDATE_INT);
            $card_id = filter_input(INPUT_GET, 'card_id', FILTER_VALIDATE_INT);
            if ($collection_id == NULL || $collection_id == false || $card_id == NULL || $card_id == false) {
                echo 'Nothing can be empty';
            } else {
                //echo 'Worked';
                $message = add_collection_item($collection_id, $card_id);
                if ($message == 'success') {
                    $message = 'Item Added';
                    echo $message;
                } elseif ($message == 'error') {
                    $message = 'An error occurred';
                    echo $message;
                }
            }
        } else {
            $message = 'Please login to manage collections';
            echo 'Please login to manage collections';
        }
        break;

    case 'updatecollectionitem':
        if (isset($_SESSION['user_name'])) {
            $collection_id = filter_input(INPUT_POST, 'collectionid', FILTER_VALIDATE_INT);

            if ($collection_id == NULL || $collection_id == FALSE) {
                $message = 'That Collection doesnt exist';
                include 'home.php';
            } else {
                $collection = get_collection($collection_id);
                $ownerinfo = get_owner($collection_id);

                $edit = false;
                $owner = true;

                $collection_items = get_collection_items($collection_id);
                $collection_item_ids = array();
                $amounts = array();
                $collection_item_ids = filter_input(INPUT_POST, 'collection_item_id', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);
                $amounts = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

                for ($i = 0; $i < count($collection_item_ids); $i++) {
                    $collection_item_id = $collection_item_ids[$i];
                    $amount = $amounts[$i];

                    if ($collection_item_id == NULL || $collection_item_id == false) {
                        $message = 'ID field cannot be Empty';
                        die;
                    } else {
                        if ($amount <= 0) {
                            $message = delete_collection_item($collection_item_id);
                        } else {
                            //echo $amount;
                            $message = update_collection_item($collection_item_id, $amount);
                        }
                    }
                }
                if ($message == 'success') {
                    $message = 'Collection Updated';
                } elseif ($message == 'error') {
                    $message = 'Something went Wrong';
                }
                $likes = get_likes($collection_id);
                $collection_items = get_collection_items($collection_id);
                include 'collectionView.php';
            }
        } else {
            $message = 'Please sign in to manage collections';
            include 'home.php';
        }
        break;

    case 'changecollection':
        $collection_id = filter_input(INPUT_GET, 'collectionid', FILTER_VALIDATE_INT);
        $collection = change_collection($collection_id);


        echo '<div id="namevalue">' . $collection['collection_name'] . '</div>
              <div id="descvalue">' . $collection['collection_description'] . '</div>
              <div id="publicvalue">' . $collection['is_public'] . '</div>
              <div id="priorityvalue">' . $collection['priority'] . '</div>';
        //echo $collection['collection_name'];
        break;

    case 'collectionsearch':
        $searchtype = filter_input(INPUT_GET, 'searchtype', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
        $searchstring = filter_input(INPUT_GET, 'searchstring', FILTER_SANITIZE_STRING);
        $viewtype = filter_input(INPUT_GET, 'viewtype', FILTER_SANITIZE_STRING);

        if ($viewtype == 'results') {
            $collection_results = collection_search($searchstring, $searchtype);
        }
        include 'collectionSearch.php';
        break;

    case 'getprice':
        $card_name = filter_input(INPUT_GET, 'card_name');
        $set_name = filter_input(INPUT_GET, 'set_name');
        $foil = filter_input(INPUT_GET, 'foil');

        $needs_update = check_price_date($card_name, $set_name);

        if ($needs_update) {
            if ($foil) {
                $price = get_database_price($card_name, $set_name, $foil);
            } else {
                $price = get_database_price($card_name, $set_name);
            }
        } else {
            if ($foil) {
                $price = get_price($card_name, $set_name, $foil);
                update_price($price, $card_name, $set_name, $foil);
            } else {
                $price = get_price($card_name, $set_name);
                update_price($price, $card_name, $set_name);
            }
        }

        if ($price == NULL || $price == 0) {
            echo 'Pricing Data Unavailable';
        } else {
            echo '$' . number_format($price, 2);
        }
        break;
        
    case 'trade':
        include 'tradeCalculator.php';
        break;
    
    case 'ajaxsearch':
        $searchValue = filter_input(INPUT_GET, 'searchvalue',FILTER_SANITIZE_STRING);
        $results = ajaxSearch($searchValue);
        //echo $results;
        $count = 0;
        foreach($results as $result){
            echo '<tr>';
            echo '<td><input class="player1" data-count="'.$count.'" data-id="'.$result['card_id'].'" type="button" value="Add" onclick="addCard(this.getAttribute(\'data-id\'),this.getAttribute(\'data-count\'),this.getAttribute(\'class\'),false)"><input class="player1" data-count="'.$count.'" data-id="'.$result['card_id'].'" type="button" value="Add Foil" onclick="addCard(this.getAttribute(\'data-id\'),this.getAttribute(\'data-count\'),this.getAttribute(\'class\'),true)"></td>';
            echo '<td id="name'.$count.'">'.$result['card_name'].'</td><td id="code'.$count.'">'.$result['official_code'].'</td>';
            echo '<td><input class="player2" data-count="'.$count.'" data-id="'.$result['card_id'].'" type="button" value="Add" onclick="addCard(this.getAttribute(\'data-id\'),this.getAttribute(\'data-count\'),this.getAttribute(\'class\'),false)"><input class="player2" data-count="'.$count.'" data-id="'.$result['card_id'].'" type="button" value="Add Foil" onclick="addCard(this.getAttribute(\'data-id\'),this.getAttribute(\'data-count\'),this.getAttribute(\'class\'),true)"></td>';
            echo '</tr>';
            $count++;
        }
        break;

    default :
        include 'home.php';
        break;
}
    