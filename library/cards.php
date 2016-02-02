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

function get_set_by_name($set_name) {
    global $db;

    $query = 'SELECT * FROM sets Where set_name = :set_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':set_name', $set_name);
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        return FALSE;
    }
    $results = $statement->fetch();
    $statement->closeCursor();

    return $results['set_id'];
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

function get_card($card_id) {
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

function get_card_details_by_name_and_flavor($card_name, $flavor_words) {
    global $db;

    if (!empty($flavor_words)) {
        $words = explode(' ', $flavor_words); //this splits the search string into seperate words in an array 
    } else {
        $words = NULL;
    }

    $query = 'SELECT * FROM cards '
            . 'WHERE card_name = :card_name ';

    $bindcount = 0;
    $bindvariables = array();
    $first = true;
    //if there are words
    if (is_array($words)) {
        $filters = ' AND( ';
        //loop through as many times as there are words

        foreach ($words as $word) {
            if ($first) {
                $filters .= ' flavor_text LIKE :' . $bindcount;
                $bindcount++;
                $bindvariables[] = '%' . $word . '%';
                $first = false;
            } else {
                $filters .= ' AND flavor_text LIKE :' . $bindcount;
                $bindcount++;
                $bindvariables[] = '%' . $word . '%';
            }
        }

        //add the closing bracket
        $filters .= ')';
        $query .= $filters;
    } else {
        $filters = NULL;
    }
    $query .= 'ORDER BY set_id DESC';

    $statement = $db->prepare($query);
    $statement->bindValue(':card_name', $card_name);
    $count = 0;
    foreach ($bindvariables as $variable) {
        $statement->bindValue(':' . $count, $variable);
        $count++;
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
        if (in_array('searchexactly', $searchtype)) {
            $words = array($searchstring);
        } else {
            $words = explode(' ', $searchstring); //this splits the search string into seperate words in an array 
        }
    } else {
        $words = NULL;
    }

    //var_dump($words);

    $bindcount = 0;
    $bindvariables = array();


    //setup the basic query without any filters
    $base_query = ' SELECT DISTINCT '
            . ' card_name '
            . ' FROM cards '
            . ' WHERE 1=1';
    $filters = '';
    //WHERE 1=1 is there so I dont have to work a WHERE clause into the following logic, I simply have to add AND and OR clauses
    //add content filtering based on search string and searchtype
    // add Filters for the words
    $first = true;
    $notfirst = false;
    //if there are words
    if (is_array($words)) {
        //var_dump($words);
        //var_dump($searchtype);
        $filters = ' AND( ';
        //if there are types selected
        if (is_array($searchtype)) {
            //if collectionname was selected
            if (in_array('name', $searchtype)) {
                //loop through as many times as there are words
                if ($notfirst) {
                    $filters .= ' OR ';
                }
                foreach ($words as $word) {


                    if ($first) {
                        $filters .= '( card_name LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                        $first = false;
                        $notfirst = true;
                    } else {
                        $filters .= ' AND card_name LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                    }
                    if (preg_match("/ae/i", $word)) {
                        //echo 'Match Found';
                        $new_word = add_accent($word);

                        $filters .= ' OR card_name LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $new_word . '%';
                    }
                    //
                    if (preg_match("/&#39;/", $word)) {
                        //echo 'Match Found';
                        $new_word = str_replace('&#39;', "'", $word);

                        $filters .= ' OR card_name LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $new_word . '%';
                    }
                }
                $filters .= ')';
                $first = true;
            }
            //if collectiondesc was selected
            if (in_array('text', $searchtype)) {
                //loop through as many times as there are words
                if ($notfirst) {
                    $filters .= ' OR ';
                }
                foreach ($words as $word) {
                    if ($first) {
                        $filters .= '( ability_text LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                        $first = false;
                        $notfirst = true;
                    } else {
                        $filters .= ' AND ability_text LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                    }
                    if (preg_match("/ae/i", $word)) {
                        //echo 'Match Found';
                        $new_word = add_accent($word);

                        $filters .= ' OR ability_text LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $new_word . '%';
                    }
                    //
                    if (preg_match("/&#39;/", $word)) {
                        //echo 'Match Found';
                        $new_word = str_replace('&#39;', "'", $word);

                        $filters .= ' OR ability_text LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $new_word . '%';
                    }
                }
                $filters .= ')';
                $first = true;
            }

            //if searchbyusername was selected
            if (in_array('types', $searchtype)) {
                //loop through as many times as there are words
                if ($notfirst) {
                    $filters .= ' OR ';
                }
                foreach ($words as $word) {
                    if ($first) {
                        $filters .= '( card_type LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                        $first = false;
                        $notfirst = true;
                    } else {
                        $filters .= ' AND card_type LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                    }
                    if (preg_match("/ae/i", $word)) {
                        //echo 'Match Found';
                        $new_word = add_accent($word);

                        $filters .= ' OR card_type LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $new_word . '%';
                    }
                    //
                    if (preg_match("/&#39;/", $word)) {
                        //echo 'Match Found';
                        $new_word = str_replace('&#39;', "'", $word);

                        $filters .= ' OR card_type LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $new_word . '%';
                    }
                }
                $filters .= ')';
                $first = true;
            }

            //if searchbycard was selected
            if (in_array('flavor', $searchtype)) {
                //loop through as many times as there are words
                if ($notfirst) {
                    $filters .= ' OR ';
                }
                foreach ($words as $word) {
                    if ($first) {
                        $filters .= '( flavor_text LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                        $first = false;
                        $notfirst = true;
                    } else {
                        $filters .= ' AND flavor_text LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $word . '%';
                    }
                    if (preg_match("/ae/i", $word)) {
                        //echo 'Match Found';
                        $new_word = add_accent($word);

                        $filters .= ' OR flavor_text LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $new_word . '%';
                    }
                    //
                    if (preg_match("/&#39;/", $word)) {
                        //echo 'Match Found';
                        $new_word = str_replace('&#39;', "'", $word);

                        $filters .= ' OR flavor_text LIKE :' . $bindcount;
                        $bindcount++;
                        $bindvariables[] = '%' . $new_word . '%';
                    }
                }
                $filters .= ')';
                $first = true;
            }
        }
        $filters .= ')';
    }
    //add the closing bracket
    //this loop will do much the same as the last, but for colors instead
    $first = TRUE;
    $colorcount = 0;
    if (isset($colors)) {
        foreach ($colors as $color) {

            //Starts the loop by adding AND on front of the added search options only the first time the loop runs
            if ($first) {
                $filters = $filters . ' AND(';
            }
            //if its the first time through , done use OR or AND
            //otherwise check to see if we should use OR or AND and use the correct one
            if ($first) {
                $filters = $filters . ' color LIKE :' . $bindcount;
                $first = FALSE;
            } elseif ($colortype == 1) {
                $filters = $filters . ' AND color LIKE :' . $bindcount;
            } else {
                $filters = $filters . ' OR color LIKE :' . $bindcount;
            }

            //this should close the AND added on the first loop cycle by adding the closing bracket
            if ($colorcount == count($colors) - 1) {
                $filters = $filters . ' )';
            }
            $colorcount += 1;
            $bindcount += 1; //increment the bind value placeholder to place in the query
            array_push($bindvariables, '%' . $color . '%'); //store the value of color and wrap it in %..% to make it work with the bind value placeholders
            //these will have the same index ie :1 in the query will $bindvariables[1]
            //do it this way so prepared statements can be used for security
        }
    }

    //exclude unselected colors
    $first = TRUE;
    $colorcount = 0;
    if (in_array('excludecolors', $searchtype)) {

        $uncolors = array('W', 'U', 'B', 'R', 'G');

        if (isset($colors)) {
            //var_dump($uncolors);
            for ($i = 0; $i < count($uncolors); $i++) {
                foreach ($colors as $color) {
                    if ($uncolors[$i] == $color) {
                        //echo 'match found';
                        $uncolors[$i] = '';
                    }
                }
            }
            $uncolors = array_filter($uncolors);
        }
        //var_dump($uncolors);
        //remove the element in uncolors if they match

        foreach ($uncolors as $uncolor) {

            //Starts the loop by adding AND on front of the added search options only the first time the loop runs
            if ($first) {
                $filters = $filters . ' AND(';
            }
            //if its the first time through , done use OR or AND
            //otherwise check to see if we should use OR or AND and use the correct one
            if ($first) {
                $filters = $filters . ' color NOT LIKE :' . $bindcount;
                $first = FALSE;
            } else {
                $filters = $filters . ' AND color NOT LIKE :' . $bindcount;
            }


            //this should close the AND added on the first loop cycle by adding the closing bracket
            if ($colorcount == count($uncolors) - 1) {
                $filters = $filters . ' )';
            }
            $colorcount += 1;
            $bindcount += 1; //increment the bind value placeholder to place in the query
            array_push($bindvariables, '%' . $uncolor . '%'); //store the value of color and wrap it in %..% to make it work with the bind value placeholders
            //these will have the same index ie :1 in the query will $bindvariables[1]
            //do it this way so prepared statements can be used for security
        }
    }


    //lastly check if they want to search by set, and if so, add that filter
    if (isset($searchbyset)) {
        if ($searchbyset == 1) {
            $filters = $filters . ' AND set_id = :' . $bindcount;
            $bindcount += 1;
            array_push($bindvariables, $set_id);
        }
    }

    //final touches
    if (count($bindvariables) > 0) {
        $query = $base_query . $filters;
    } else {
        $query = $base_query;
    }

    $query .= ' ORDER BY card_name ASC, set_id DESC , variation_number ASC';
    $query .= ' LIMIT :start, 50';

    //run the query and prepare the bind variables;
    $statement = $db->prepare($query);
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
        //var_dump($query);
        //echo $ex;
        return 'error';
    }
    $results = $statement->fetchAll();

    //run a query to get how many total rows there are to populate page numbers, send it back to a global variable
    //$statement2 = $db->prepare('SELECT FOUND_ROWS()');
    //$statement2->execute();
    global $row_count;

    $row_count = get_row_count($filters, $bindvariables);

    //var_dump($bindvariables);
    //echo $query;
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
}

function get_price($card_name, $set_name, $foil = false) {

    if ($foil) {
        $set_name = trim($set_name);
        //echo $set_name.'1<br>';
        $set_name .= ' Foil';
        //echo $set_name.'2<br>';
    }

    $link = fix_url_price(trim($card_name), trim($set_name));

    //echo $link;
    //var_dump($link);

    $opts = array(
        'http' => array(
            'user_agent' => 'PHP libxml agent',
        )
    );
    $context = stream_context_create($opts);
    libxml_set_streams_context($context);

    $article = new DOMDocument;
    @$article->loadHTMLFile($link);

    @$node = $article->getElementById('card-name');
    @$node = $node->nodeValue;
    //echo $node;

    $start = strpos($node, '$') + 1;
    $end = strpos($node, 'Set:');
    $length = $end - $start;
    $price = substr($node, $start, $length);
    //echo $price.'1<br>';
    $price = floatval($price);
    //echo $price.'2<br>';

    return $price;
}

function fix_url_price($card_name, $set_name) {

    //echo $card_name.'<br>';
    //echo $set_name.'<br>';
    $card_name = html_entity_decode($card_name);

    $card_name = str_replace(' ', '_', $card_name);
    $card_name = str_replace(':', '', $card_name);
    $card_name = str_replace('/', '', $card_name);
    $card_name = str_replace('"', '', $card_name);
    $card_name = str_replace('Æ', 'AE', $card_name);
    $card_name = trim($card_name);

    $card_name = fix_url($card_name);
    //echo $card_name.'<br>';
    //$card_name = urlencode($card_name);
    //echo $card_name.'<br>';

    $set_name = str_replace('.', '', $set_name);
    $set_name = str_replace(':', '', $set_name);
    $set_name = str_replace('"', '', $set_name);
    $set_name = str_replace("'", '', $set_name);
    $set_name = str_replace('(', '', $set_name);
    $set_name = str_replace(')', '', $set_name);
    //echo $set_name.'1<br>';
    $set_name = str_replace('Magic The Gathering-', '', $set_name);
    //echo $set_name.'2<br>';
    $set_name = str_replace('Limited', '', $set_name);
    $set_name = str_replace('City of Guilds', '', $set_name);
    $set_name = str_replace('Magic 20', 'M', $set_name);
    //echo $set_name.'3<br>';
    $set_name = str_replace('Magic', '', $set_name);
    //echo $set_name.'4<br>';
    $set_name = str_replace('into', 'Into', $set_name);
    $set_name = str_replace('Origins', 'Magic Origins', $set_name);
    $set_name = str_replace('Core Set', '', $set_name);
    $set_name = str_replace('Edition', '', $set_name);
    $set_name = str_replace('Tenth', '10th Edition', $set_name);
    $set_name = str_replace('Fifth', '5th Edition', $set_name);
    $set_name = str_replace('Seventh', '7th Edition', $set_name);
    $set_name = str_replace('Eighth', '8th Edition', $set_name);
    $set_name = str_replace('Ninth', '9th Edition', $set_name);
    $set_name = str_replace('Classic Sixth', '6th Edition', $set_name);
    $set_name = str_replace('Fourth', '4th Edition', $set_name);
    $set_name = str_replace('Deckmasters', 'Deckmasters Box Set', $set_name);
    //echo $set_name.'5<br>';
    $set_name = trim(preg_replace('/\s+/', ' ', $set_name));
    $set_name = str_replace(' ', '_', $set_name);
    //echo $set_name.'6<br>';
    //echo $card_name.'<br>';
    //echo $set_name.'<br>';

    $link = 'http://www.mtgprice.com/sets/' . $set_name . '/' . $card_name;
    //$link = urlencode($link);
    //echo $link.'<br>';
    //echo fix_url($link).'<br>';

    return $link;
}

//returns false if the price needs to be updated
//returns true if the price does not need to be updated
function check_price_date($card_name, $set_name, $variation = NULL) {
    global $db;

    $query = 'SELECT * FROM cards c INNER JOIN sets s using(set_id) WHERE c.card_name = :card_name AND s.set_name = :set_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':card_name', $card_name);
    $statement->bindValue(':set_name', $set_name);
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        //echo 'Error 1';
        return FALSE;
    }
    $result = $statement->fetch();
    $statement->closeCursor();

    $query = 'SELECT UTC_DATE() as date';
    $statement = $db->prepare($query);
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        //echo 'Error 2';
        return FALSE;
    }
    $date = $statement->fetch();
    $statement->closeCursor();

    if ($result['price_date'] != $date['date']) {
        //var_dump($result['price_date']);
        //var_dump($date['date']);
        //echo 'Not a match';
        return false;
    } else {
        //echo 'Matched';
        return true;
    }
}

function get_database_price($card_name, $set_name, $foil = false) {
    global $db;

    $query = 'SELECT price, price_foil FROM cards c INNER JOIN sets s using(set_id) WHERE c.card_name = :card_name AND s.set_name = :set_name';

    $statement = $db->prepare($query);
    $statement->bindValue(':card_name', $card_name);
    $statement->bindValue(':set_name', $set_name);
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        //echo 'Error 1';
        return FALSE;
    }
    $result = $statement->fetch();
    $statement->closeCursor();

    if ($foil) {
        return $result['price_foil'];
    } else {
        return $result['price'];
    }
}

function update_price($price, $card_name, $set_name, $foil = FALSE){
    global $db;

    $set_id = get_set_by_name($set_name);
    
    if($foil){
        $query = 'UPDATE cards SET price_foil = :price , price_date = UTC_DATE() WHERE card_name = :card_name AND set_id = :set_id';
    }else{
        $query = 'UPDATE cards SET price = :price WHERE card_name = :card_name AND set_id = :set_id';
    }

    $statement = $db->prepare($query);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':card_name', $card_name);
    $statement->bindValue(':set_id', $set_id);
    try {
        $statement->execute();
        //echo 'Price Updated';
        return true;
    } catch (PDOException $ex) {
        //echo $ex;
        //echo 'Price Update Failed';
        return false;
    }

   
}

function ajaxSearch($searchValue){
    global $db;
    
    $query = 'SELECT card_id, official_code, card_name, variation_number, price, price_foil FROM cards INNER JOIN sets USING(set_id) WHERE card_name LIKE :searchValue';

    $statement = $db->prepare($query);
    $statement->bindValue(':searchValue', $searchValue.'%');
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        echo 'Error';
        return FALSE;
    }
    $results = $statement->fetchAll();
    $statement->closeCursor();
    
    return $results;
    
}