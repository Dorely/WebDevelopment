<?php

function get_collections($user_id) {
    global $db;

    $query = 'select * from collections where user_id = :user_id order by priority DESC';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id);

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        //echo 'False being returned';
        return false;
    }

    $results = $statement->fetchAll();
    $statement->closeCursor();

    return $results;
}

function get_owner($collection_id) {
    global $db;

    $query = 'select * from collections inner join users using(user_id)
              where collection_id = :collection_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':collection_id', $collection_id);

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return false;
    }

    $results = $statement->fetch();
    $statement->closeCursor();

    return $results;
}

function get_collection($collection_id) {
    global $db;

    $query = 'select * from collections where collection_id = :collection_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':collection_id', $collection_id);

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return false;
    }

    $results = $statement->fetch();
    $statement->closeCursor();

    return $results;
}

function get_collection_items($collection_id) {
    global $db;

    $query = 'select * from collection_items inner join cards using(card_id) where collection_id = :collection_id order by card_type,card_name,amount';
    $statement = $db->prepare($query);
    $statement->bindValue(':collection_id', $collection_id);

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return false;
    }

    $results = $statement->fetchAll();
    $statement->closeCursor();

    //var_dump($results);
    return $results;
}

function add_collection($user_id, $collection_name, $public, $description = NULL) {
    global $db;

    $query = 'INSERT INTO collections VALUES (NULL, :user_id, :collection_name, :description, :public,NULL)';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':collection_name', $collection_name);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':public', $public);

    try {
        $statement->execute();
        return 'success';
    } catch (PDOException $ex) {
        return 'error';
    }
}

function edit_collection($collection_id, $collection_name, $public, $description, $priority) {
    global $db;

    $query = 'UPDATE collections SET '
            . ' collection_name = :collection_name '
            . ',collection_description = :description '
            . ',is_public = :public '
            . ',priority = :priority '
            . 'WHERE '
            . 'collection_id = :collection_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':collection_name', $collection_name);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':public', $public);
    $statement->bindValue(':priority', $priority);
    $statement->bindValue(':collection_id', $collection_id);

    try {
        $statement->execute();
        return 'success';
    } catch (PDOException $ex) {
        //echo $ex;
        return 'error';
    }
}

function delete_collection($collection_id) {
    global $db;

    $query = 'DELETE FROM collection_items WHERE collection_id = :collection_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':collection_id', $collection_id);

    try {
        $statement->execute();
        $result = true;
    } catch (PDOException $ex) {
        //echo $ex;
        $result = false;
    }

    if (!$result) {
        return 'error';
    } else {
        $query = 'DELETE FROM collections WHERE collection_id = :collection_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':collection_id', $collection_id);

        try {
            $statement->execute();
            return 'success';
        } catch (PDOException $ex) {
            //echo $ex;
            return 'error';
        }
    }
}

function add_collection_item($collection_id, $card_id) {
    global $db;

    //echo 'Entering add function';
    //first check if that item already exists in the collection
    $exists = check_collection_item($collection_id, $card_id);
    if ($exists === 'error') {
        //echo 'exists error occurred';
        return 'error';
    }


    if ($exists) {
        $query = 'INSERT INTO collection_items VALUES (NULL, :collection_id, :card_id, 1)';
        $statement = $db->prepare($query);
        $statement->bindValue(':collection_id', $collection_id);
        $statement->bindValue(':card_id', $card_id);

        try {
            $statement->execute();
            return 'success';
        } catch (PDOException $ex) {
            echo $ex;
            return 'error';
        }
    } else {
        $query = 'UPDATE collection_items SET'
                . ' amount = amount+1'
                . ' WHERE collection_id = :collection_id'
                . ' AND card_id = :card_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':collection_id', $collection_id);
        $statement->bindValue(':card_id', $card_id);

        try {
            $statement->execute();
            return 'success';
        } catch (PDOException $ex) {
            echo $ex;
            return 'error';
        }
    }
    //insert the collections
}

function check_collection_item($collection_id, $card_id) {
    global $db;

    //echo 'Entering check function';
    $query = 'SELECT * FROM collection_items WHERE collection_id = :collection_id AND card_id = :card_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':collection_id', $collection_id);
    $statement->bindValue(':card_id', $card_id);

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        //echo $ex;
        return 'error';
    }

    $results = $statement->fetchAll();
    $statement->closeCursor();

    if ($results == false) {
        //echo 'returning true on check';
        return true;
    } else {
        //echo 'returning false on check';
        return false;
    }
}

function delete_collection_item($collection_item_id) {
    global $db;

    $query = 'DELETE FROM collection_items WHERE collection_item_id = :collection_item_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':collection_item_id', $collection_item_id);

    try {
        $statement->execute();
        return 'success';
    } catch (PDOException $ex) {
        echo $ex;
        return 'error';
    }
}

function update_collection_item($collection_item_id, $amount) {
    global $db;

    $query = 'UPDATE collection_items SET
                amount = :amount
              WHERE collection_item_id = :collection_item_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':collection_item_id', $collection_item_id);
    $statement->bindValue(':amount', $amount);

    try {
        $statement->execute();
        return 'success';
    } catch (PDOException $ex) {
        echo $ex;
        return 'error';
    }
}

//this will count the ammount of cards in the collection
function count_collection($collection_items) {
    $sum = 0;

    foreach ($collection_items as $item) {
        $sum += $item['amount'];
    }

    return $sum;
}

function sort_collection($collection_items) {

    /*
     * creatures
     * artifact
     * enchantment
     * planeswalker
     * instant
     * sorcery
     * land
     * 
     */
    $temp_collection = array();

    //find creatures add them to array, 
    for ($i = 0; $i < count($collection_items); $i++) {
        if (stristr($collection_items[$i]['card_type'], 'creature')) {
            $temp_collection[] = $collection_items[$i];
        }
    }
    //find artifacts add them to array, 
    for ($i = 0; $i < count($collection_items); $i++) {
        if (stristr($collection_items[$i]['card_type'], 'artifact')) {
            $temp_collection[] = $collection_items[$i];
        }
    }
    //find enchantment add them to array, 
    for ($i = 0; $i < count($collection_items); $i++) {
        if (stristr($collection_items[$i]['card_type'], 'enchantment')) {
            $temp_collection[] = $collection_items[$i];
        }
    }
    //find planeswalker add them to array, 
    for ($i = 0; $i < count($collection_items); $i++) {
        if (stristr($collection_items[$i]['card_type'], 'planeswalker')) {
            $temp_collection[] = $collection_items[$i];
        }
    }
    //find instant add them to array, 
    for ($i = 0; $i < count($collection_items); $i++) {
        if (stristr($collection_items[$i]['card_type'], 'instant')) {
            $temp_collection[] = $collection_items[$i];
        }
    }
    //find sorcery add them to array, 
    for ($i = 0; $i < count($collection_items); $i++) {
        if (stristr($collection_items[$i]['card_type'], 'sorcery')) {
            $temp_collection[] = $collection_items[$i];
        }
    }
    //find land add them to array, 
    for ($i = 0; $i < count($collection_items); $i++) {
        if (stristr($collection_items[$i]['card_type'], 'land')) {
            $temp_collection[] = $collection_items[$i];
        }
    }
    //find schemes add them to array, 
    for ($i = 0; $i < count($collection_items); $i++) {
        if (stristr($collection_items[$i]['card_type'], 'scheme')) {
            $temp_collection[] = $collection_items[$i];
        }
    }

    return $temp_collection;
    //var_dump($temp_collection);
}

function change_collection($collection_id) {
    global $db;

    $query = 'SELECT * FROM collections WHERE collection_id = :collection_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':collection_id', $collection_id);

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        //echo $ex;
        return 'error';
    }

    $results = $statement->fetch();
    $statement->closeCursor();

    return $results;
}

function like($collection_id, $user_id) {
    global $db;

    $exists = check_if_liked($collection_id, $user_id);

    if (!$exists) {
        $query = 'INSERT INTO collection_likes VALUES (NULL, :collection_id , :user_id)';
        $statement = $db->prepare($query);
        $statement->bindValue(':collection_id', $collection_id);
        $statement->bindValue(':user_id', $user_id);


        try {
            $statement->execute();
            return 'success';
        } catch (PDOException $ex) {
            return 'error';
        }
    } else {
        return 'error';
    }
}

function get_likes($collection_id) {
    global $db;

    $query = 'SELECT count(*) from collection_likes WHERE collection_id = :collection_id ';
    $statement = $db->prepare($query);
    $statement->bindValue(':collection_id', $collection_id);

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return 'error';
    }
    $results = $statement->fetch();
    $statement->closeCursor();

    //var_dump($results);
    return $results[0];
}

function check_if_liked($collection_id, $user_id) {
    global $db;

    $query = 'SELECT * from collection_likes WHERE collection_id = :collection_id AND user_id = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':collection_id', $collection_id);
    $statement->bindValue(':user_id', $user_id);

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return 'error';
    }

    $results = $statement->fetchAll();
    $statement->closeCursor();

    if ($results == false) {
        //echo 'returning true on check';
        return false;
    } else {
        //echo 'returning false on check';
        return true;
    }
}

function get_top_collections() {
    global $db;

    $query = 'select collection_id , count(*) as likes from collection_likes group by collection_id order by 2 DESC ,1 ASC limit 10';
    $statement = $db->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    //var_dump($statement);
    //var_dump($results);
    return $results;
}

function collection_search($text, $types) {
    global $db;

    if (!empty($text)) {
        $words = explode(' ', $text);
    } else {
        $words = NULL;
    }

    //var_dump($text);
    //var_dump($words);
    
    $bindcount = 0;
    $bindvariables = array();

    //Select the unique collections that can be filtered by the the desired criteria
    $base_query = 'SELECT DISTINCT
                    c.collection_id
                    FROM
                    users u INNER JOIN collections c on u.user_id = c.user_id
                            INNER JOIN collection_items ci on ci.collection_id = c.collection_id
                            INNER JOIN cards ca on ci.card_id = ca.card_id 
                    WHERE c.is_public = 1';
    $filters = ' AND(';

    // add Filters for the words
    $first = true;
    $notfirst = false;
    //if there are words
    if (is_array($words)) {

        //if there are types selected
        if (is_array($types)) {
            //if collectionname was selected
            if (in_array('collectionname', $types)) {
                //loop through as many times as there are words
                if ($notfirst) {
                    $filters .= ' OR ';
                }
                foreach ($words as $word) {
                    if ($first) {
                        $filters .= '( c.collection_name LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                        $first = false;
                        $notfirst = true;
                    } else {
                        $filters .= ' AND c.collection_name LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                    }
                }
                $filters .= ')';
                $first = true;
            }
            //if collectiondesc was selected
            if (in_array('collectiondesc', $types)) {
                //loop through as many times as there are words
                if ($notfirst) {
                    $filters .= ' OR ';
                }
                foreach ($words as $word) {
                    if ($first) {
                        $filters .= '( c.collection_description LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                        $first = false;
                        $notfirst = true;
                    } else {
                        $filters .= ' AND c.collection_description LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                    }
                }
                $filters .= ')';
                $first = true;
            }

            //if searchbyusername was selected
            if (in_array('searchbyusername', $types)) {
                //loop through as many times as there are words
                if ($notfirst) {
                    $filters .= ' OR ';
                }
                foreach ($words as $word) {
                    if ($first) {
                        $filters .= '( u.user_name LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                        $first = false;
                        $notfirst = true;
                    } else {
                        $filters .= ' AND u.user_name LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                    }
                }
                $filters .= ')';
                $first = true;
            }

            //if searchbycard was selected
            if (in_array('searchbycard', $types)) {
                //loop through as many times as there are words
                if ($notfirst) {
                    $filters .= ' OR ';
                }
                foreach ($words as $word) {
                    if ($first) {
                        $filters .= '( ca.card_name LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                        $first = false;
                        $notfirst = true;
                    } else {
                        $filters .= ' AND ca.card_name LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                    }
                    if (preg_match("/ae/i", $word)) {
                        //echo 'Match Found';
                        $new_word = add_accent($word);

                        $filters .= ' OR ca.card_name LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $new_word . '%';
                    }
                    //
                    if (preg_match("/&#39;/", $word)) {
                        //echo 'Match Found';
                        $new_word = str_replace('&#39;', "'", $word);

                        $filters .= ' OR ca.card_name LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $new_word . '%';
                    }
                }
                $filters .= ')';
                $first = true;
            }
        }
    }
    //add the closing bracket
    $filters .= ')';

    
    
    if(count($bindvariables) > 0){
        $query = $base_query . $filters;
    }else{
        $query = $base_query;
    }
    
    $query .= ' ORDER BY c.collection_id ';
    
    $statement = $db->prepare($query);
    $count = 0;
    foreach ($bindvariables as $variable) {
        $statement->bindValue(':' . $count, $variable);
        $count++;
    }
    
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        //var_dump($query);
        //echo $ex;
        return $ex;
    }
    
    $results = $statement->fetchAll();
    return $results;
    
}
