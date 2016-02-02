<?php

//This function will return data for all sets in the sets table to be used by the main search page
function get_sets() {
    global $db;

    $query = 'SELECT * FROM sets ORDER BY set_name';
    $statement = $db->prepare($query);
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return FALSE;
    }
    $results = $statement->fetchAll();
    $statement->closeCursor();

    return $results;
}

function get_set_by_id($set_id) {
    global $db;

    $query = 'SELECT * FROM sets Where set_id = :set_id ORDER BY set_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':set_id', $set_id);
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return FALSE;
    }
    $results = $statement->fetch();
    $statement->closeCursor();

    return $results;
}

function get_variations($card_name, $set_id) {
    global $db;

    $query = 'SELECT variation_number FROM cards '
            . 'Where card_name = :card_name AND set_id = :set_id '
            . 'ORDER BY variation_number';
    $statement = $db->prepare($query);
    $statement->bindValue(':card_name', $card_name);
    $statement->bindValue(':set_id', $set_id);
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return FALSE;
    }
    $results = $statement->fetchAll();
    $statement->closeCursor();

    return $results;
}

function get_sets_by_card_name($card_name, $set_id) {
    global $db;

    $query = 'SELECT DISTINCT s.set_id, s.official_code FROM sets s INNER JOIN cards c '
            . 'using(set_id) '
            . 'Where c.card_name = :card_name AND s.set_id != :set_id '
            . 'ORDER BY s.set_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':card_name', $card_name);
    $statement->bindValue(':set_id', $set_id);
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return FALSE;
    }
    $results = $statement->fetchAll();
    $statement->closeCursor();

    return $results;
}

function get_card($card_id){
    global $db;
    
    $query = 'SELECT * FROM cards WHERE card_id = :card_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':card_id', $card_id);
    
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return false;
    }
    $results = $statement->fetch();
    $statement->closeCursor();

    return $results;
}

function get_card_details($card_name, $set_id, $variation = NULL) {
    global $db;

    //var_dump($card_name);
    //var_dump($set_id);
    //var_dump($variation);

    if ($variation != NULL) {
        $query = 'SELECT * FROM cards '
                . 'WHERE card_name = :card_name '
                . 'AND set_id = :set_id '
                . 'AND variation_number = :variation';
        $statement = $db->prepare($query);
        $statement->bindValue(':card_name', $card_name);
        $statement->bindValue(':set_id', $set_id);
        $statement->bindValue(':variation', $variation);
    } else {
        $query = 'SELECT * FROM cards '
                . 'WHERE card_name = :card_name '
                . 'AND set_id = :set_id '
                . 'ORDER BY variation_number';
        $statement = $db->prepare($query);
        $statement->bindValue(':card_name', $card_name);
        $statement->bindValue(':set_id', $set_id);
    }

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return FALSE;
    }
    $results = $statement->fetch();
    $statement->closeCursor();

    return $results;
}

function get_card_details_by_name($card_name, $set_id = NULL) {
    global $db;

    if ($set_id == NULL) {
        $query = 'SELECT * FROM cards '
                . 'WHERE card_name = :card_name '
                . 'ORDER BY set_id DESC';
        $statement = $db->prepare($query);
        $statement->bindValue(':card_name', $card_name);
    } else {
        //var_dump($card_name);
        //var_dump($set_id);
        $query = 'SELECT * FROM cards '
                . 'WHERE card_name = :card_name '
                . 'AND set_id = :set_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':card_name', $card_name);
        $statement->bindValue(':set_id', $set_id);
    }

    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return FALSE;
    }
    $results = $statement->fetch();
    $statement->closeCursor();

    return $results;
}

function add_accent($str) {
    $a = array('Æ', 'æ');
    $b = array('AE', 'ae');
    return str_replace($b, $a, $str);
}

function fix_url($url) {
    
    $url = str_replace('ö', "o", $url);
    $url = str_replace('é', "e", $url);
    $url = str_replace('û', "u", $url);
    $url = str_replace('ú', "u", $url);
    $url = str_replace('â', "a", $url);
    $url = str_replace('í', "i", $url);
    $url = str_replace('á', "a", $url);
    $url = str_replace('"', "", $url);
    $url = str_replace(':', "", $url);
    $url = str_replace(' // ', "", $url);
    $url = iconv('utf-8', 'ascii//TRANSLIT', $url);

    return $url;
}

//This function takes data from the search form and builds a SQL statement to find matching cards in the database
//change_page($start, $end, $searchtype, $searchstring, $colors, $colortype, $set_id, $searchbyset)
function card_search($start, $end, $searchtype, $searchstring, $colors, $colortype, $set_id, $searchbyset) {
    global $db;

    if (!empty($searchstring)) {
        if (in_array('searchexactly', $searchtype)){
            $words = array($searchstring);
        }else{
           $words = explode(' ', $searchstring); //this splits the search string into seperate words in an array 
        }
    } else {
        $words = NULL;
    }

    if (is_array($words)) {
        foreach ($words as $word) {
            if (preg_match("/ae/i", $word)) {
                $new_word = add_accent($word);
                array_push($words, $new_word);
            }
        }
    }

    $bindcount = 0;
    $bindvariables = array();
    $query = '';

    //setup the basic query without any filters
    $query1 = ' SELECT DISTINCT '
            . ' card_name '
            . ' FROM cards '
            . ' WHERE 1=1';
    //WHERE 1=1 is there so I dont have to work a WHERE clause into the following logic, I simply have to add AND and OR clauses
    //add content filtering based on search string and searchtype

    $first = TRUE;
    if (is_array($words) && is_array($searchtype)) {
        if (in_array('searchexactly', $searchtype)) {
            $logic = 'OR';
        } else {
            $logic = 'OR';
        }
        foreach ($words as $word) {
            //echo 'inside Foreach loop';
            //Starts the loop by adding AND on front of the added search options only the first time the loop runs
            if ($first) {
                $query = $query . ' AND(';
            }

            if (in_array('name', $searchtype)) {
                //echo 'inside name if';
                if ($first) {
                    $query = $query . ' card_name LIKE :' . $bindcount;
                    $first = FALSE;
                } else {
                    $query = $query . ' ' . $logic . ' card_name LIKE :' . $bindcount;
                }
            }
            if (in_array('text', $searchtype)) {
                if ($first) {
                    $query = $query . ' ability_text LIKE :' . $bindcount;
                    $first = FALSE;
                } else {
                    $query = $query . ' ' . $logic . ' ability_text LIKE :' . $bindcount;
                }
            }
            if (in_array('flavor', $searchtype)) {
                if ($first) {
                    $query = $query . ' flavor_text LIKE :' . $bindcount;
                    $first = FALSE;
                } else {
                    $query = $query . ' ' . $logic . ' flavor_text LIKE :' . $bindcount;
                }
            }
            if (in_array('types', $searchtype)) {
                if ($first) {
                    $query = $query . ' card_type LIKE :' . $bindcount;
                    $first = FALSE;
                } else {
                    $query = $query . ' ' . $logic . ' card_type LIKE :' . $bindcount;
                }
            }
            //this should close the AND added on the first loop cycle by adding the closing bracket
            if ($bindcount == count($words) - 1) {
                $query = $query . ' )';
            }

            $bindcount += 1; //increment the bind value placeholder to place in the query
            array_push($bindvariables, '%' . $word . '%'); //store the value of word and wrap it in %..% to make it work with the bind value placeholders
            //these will have the same index ie :1 in the query will $bindvariables[1]
            //do it this way so prepared statements can be used for security
        }
    }

    //this loop will do much the same as the last, but for colors instead
    $first = TRUE;
    $colorcount = 0;
    if (isset($colors)) {
        foreach ($colors as $color) {

            //Starts the loop by adding AND on front of the added search options only the first time the loop runs
            if ($first) {
                $query = $query . ' AND(';
            }
            //if its the first time through , done use OR or AND
            //otherwise check to see if we should use OR or AND and use the correct one
            if ($first) {
                $query = $query . ' color LIKE :' . $bindcount;
                $first = FALSE;
            } elseif ($colortype == 1) {
                $query = $query . ' AND color LIKE :' . $bindcount;
            } else {
                $query = $query . ' OR color LIKE :' . $bindcount;
            }

            //this should close the AND added on the first loop cycle by adding the closing bracket
            if ($colorcount == count($colors) - 1) {
                $query = $query . ' )';
            }
            $colorcount += 1;
            $bindcount += 1; //increment the bind value placeholder to place in the query
            array_push($bindvariables, '%' . $color . '%'); //store the value of color and wrap it in %..% to make it work with the bind value placeholders
            //these will have the same index ie :1 in the query will $bindvariables[1]
            //do it this way so prepared statements can be used for security
        }
    }
    //lastly check if they want to search by set, and if so, add that filter
    if (isset($searchbyset)) {
        if ($searchbyset == 1) {
            $query = $query . ' AND set_id = :' . $bindcount;
            $bindcount += 1;
            array_push($bindvariables, $set_id);
        }
    }

    //final touches
    $query1 .= $query . ' ORDER BY card_name ASC, set_id DESC , variation_number ASC';
    $query1 .= ' LIMIT :start, 50';

    //run the query and prepare the bind variables;
    $statement = $db->prepare($query1);
    $count = 0;
    foreach ($bindvariables as $variable) {
        $statement->bindValue(':' . $count, $variable);
        $count++;
    }
    $statement->bindValue(':start', $start, PDO::PARAM_INT);
    //$statement->bindValue(':end', $end, PDO::PARAM_INT);
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        //var_dump($query1);
        //echo $ex;
        return $ex;
    }


    //run a query to get how many total rows there are to populate page numbers, send it back to a global variable
    //$statement2 = $db->prepare('SELECT FOUND_ROWS()');
    //$statement2->execute();
    global $row_count;
    //var_dump($query1);
    $row_count = get_row_count($query, $bindvariables);
    //var_dump($row_count);
    //$statement2->closeCursor();

    $results = $statement->fetchAll();

    //var_dump($bindvariables);
    //var_dump($query);
    //var_dump($results);
    //var_dump($row_count);
    
    return $results;
}

function get_row_count($query, $bindvariables) {
    //var_dump($query);
    global $db;

    $query1 = 'SELECT count(DISTINCT card_name) FROM cards WHERE 1=1' . $query;
    $statement = $db->prepare($query1);
    $count = 0;
    foreach ($bindvariables as $variable) {
        $statement->bindValue(':' . $count, $variable);
        $count++;
    }
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        //echo $ex;
        //var_dump($query1);
        //var_dump($bindvariables);
        //var_dump($statement);
        return FALSE;
    }
    $results = $statement->fetch();
    $statement->closeCursor();

    //var_dump($results[0]);
    return intval($results[0]);
    //var_dump($query1);
}
