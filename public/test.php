<?php

require_once('../library/database.php');
require_once('../library/cards.php');

$db = magic_connection();

function get_price_date($card_name, $set_name, $variation = NULL) {
    global $db;

    $query = 'SELECT * FROM cards c INNER JOIN sets s using(set_id) WHERE c.card_name = :card_name AND s.set_name = :set_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':card_name', $card_name);
    $statement->bindValue(':set_name', $set_name);
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        echo 'Error 1';
        return FALSE;
    }
    $result = $statement->fetch();
    $statement->closeCursor();

    $query = 'SELECT UTC_DATE() as date';
    $statement = $db->prepare($query);
    try {
        $statement->execute();
    } catch (PDOException $ex) {
        echo 'Error 2';
        return FALSE;
    }
    $date = $statement->fetch();
    $statement->closeCursor();

    if ($result['price_date'] != $date['date']) {
        echo 'Not a match';
        return false;
    } else {
        echo 'Matched';
        return true;
    }
}

$card_name = 'Ring of Ma\'rûf';
$set_name = 'Arabian Nights';

if (get_price_date($card_name, $set_name)) {
    //Price has been updated already today, do nothing
} else {
    $link = 'http://www.mtgprice.com/sets/Arabian_Nights/Ring_of_Ma\'ruf';
    echo $link . '<br>';

    $opts = array(
        'http' => array(
            'user_agent' => 'PHP libxml agent',
        )
    );
    $context = stream_context_create($opts);
    libxml_set_streams_context($context);

    $article = new DOMDocument;
    @$article->loadHTMLFile($link);

    $node = $article->getElementById('card-name');

    $node = $node->nodeValue;
    echo $node . '<br>';

    $start = strpos($node, '$') + 1;
    $end = strpos($node, 'Set:');
    $length = $end - $start;
    $price = substr($node, $start, $length);
    echo floatval($price);
    $price = floatval($price);
}
?>