<?php
/*
 *This is the controller for my JSON endpoint for card data stored in the database.
 * 
 * A person should be able to send a request to this endpoint in the following formats
 * 
 * domainaddress/json?action=carddata&cardname=cardnamehere&setname=setnamehere
 *  this will return json data for a single card
 * domainaddress/json?action=carddata&cardname=cardnamehere
 *  this will return json data for a list of cards with the same name
 * domainaddress/json?action=carddata&setname=setnamehere
 *  this will return json data for a list of cards from the same set
 * domainaddress/json?action=getsets
 *  this will return json data for all sets
 * 
 * 
 * 
 */
require_once('../../library/database.php');
require_once('../../library/cards.php');

$db = magic_connection();

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);


switch ($action) {
    
    case 'getsets':    
        $sets = get_sets();
        $jsonSets = json_encode($sets);
        
        echo $jsonSets;
        
        break;
    
    case 'carddata':
        $cardname = filter_input(INPUT_GET,'cardname',FILTER_SANITIZE_STRING);
        $setname = filter_input(INPUT_GET,'setname',FILTER_SANITIZE_STRING);
        
        if($cardname == null && $setname == null){
            //error
            echo 'Invalid Card Data';
            
        }elseif($cardname == null && $setname != null){
            //domainaddress/json?action=carddata&setname=setnamehere
            $set_id = get_set_by_name($setname);
            $cards = get_cards_by_set_id($set_id);
            $jsonCards = json_encode($cards,JSON_UNESCAPED_UNICODE);
            echo $jsonCards;
            
        }elseif($cardname != null && $setname == null){
            //domainaddress/json?action=carddata&cardname=cardnamehere
            $cards = get_cards_by_name($cardname);
            $jsonCards = json_encode($cards,JSON_UNESCAPED_UNICODE);
            echo $jsonCards;
            
        }elseif($cardname != null && $setname != null){
            //domainaddress/json?action=carddata&cardname=cardnamehere&setname=setnamehere
            $set_id = get_set_by_name($setname);
            $card = get_card_details($cardname,$set_id);
            $jsonCard = json_encode($card,JSON_UNESCAPED_UNICODE);
            echo $jsonCard;
            
        }else{
            //error
            echo 'Invalid Card Data';
        }
        
        break;
    
    default:
       $output = '<p>'
        .'This is the  JSON endpoint for card data stored in the database.<br>'
        .'A person should be able to send a request to this endpoint in the following formats<br>'
        .'domainaddress/json/?action=carddata&amp;cardname=cardnamehere&amp;setname=setnamehere<br>'
        .'this will return json data for a single card<br>'
        .'domainaddress/json/?action=carddata&amp;cardname=cardnamehere<br>'
        .'this will return json data for a list of cards with the same name<br>'
        .'domainaddress/json/?action=carddata&amp;setname=setnamehere<br>'
        .'this will return json data for a list of cards from the same set<br>'
        .'domainaddress/json/?action=getsets<br>'
        .'this will return json data for all sets'
        .'</p>';
        
        echo $output;
        
        break;
}