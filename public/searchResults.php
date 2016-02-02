<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/nav.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/sidebar.php'; ?> 
<main role="main" class="main">
    <h1>Results</h1>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/pageNumbers.php'; ?>
    <table>
        <?php 
        //var_dump($search_results);
        foreach ($search_results as $card_name): ?>
            <?php
            if ($searchbyset == 1) {
                $card = get_card_details_by_name($card_name['card_name'], $set_id);
            }elseif(in_array('flavor', $searchtype)){
                $card = get_card_details_by_name_and_flavor($card_name['card_name'],$searchstring);
                if($card == false){
                    $card = get_card_details_by_name($card_name['card_name']);
                }
            }else {
                $card = get_card_details_by_name($card_name['card_name']);
            }
            ?>
            <tr>
                <td class="leftcolumn">
                    <a href=".?action=details&amp;cardname=<?php echo urlencode($card['card_name']) ?>&amp;setid=<?php echo $card['set_id'] ?>"><img src="<?php
                        $set = get_set_by_id($card['set_id']);
                        $url = '/pictures/' . $set['official_code'] . '/' . $card['card_name'];
                        if ($card['variation_number'] != NULL) {
                            $url = $url . $card['variation_number'];
                        }
                        $url = $url . '.jpg';

                        $url = fix_url($url);
                        echo $url;
                        ?>" alt="Card Image Goes Here"></a>
                </td>
                <td class="middlecolumn">
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <select name="collection_id" id="collection<?php echo $card['card_id']; ?>">
                            <?php foreach ($collections as $collection): ?>
                                <option value="<?php echo $collection['collection_id']; ?>"><?php echo $collection['collection_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input id="<?php echo $card['card_id']; ?>" type="submit" value="Add" onclick="insertItem(this.id)">
                        <a href=".?action=managecollections">Manage Collections</a>
                        <div id="response<?php echo $card['card_id']; ?>"></div>
                        
                    <?php else: ?>
                        <a href=".">Sign in to manage collections</a><br>
                    <?php endif; ?>
                        <br>
                    <?php echo '<a href=".?action=details&amp;cardname=' . urlencode($card['card_name']) . '&amp;setid=' . $card['set_id'] . '">' . $card['card_name'] . '</a> ' . $card['mana_cost'] . ' (' . $card['converted_mana_cost'] . ')<br>'; ?>
                    <?php
                    echo $card['card_type'];
                    if ($card['power'] != NULL) {
                        echo ' (' . $card['power'] . '/' . $card['toughness'] . ')' . '<br>';
                    } elseif ($card['loyalty'] != NULL) {
                        echo ' (' . $card['loyalty'] . ')<br>';
                    } else {
                        echo '<br>';
                    }
                    ?>
                    <?php echo $card['ability_text']; ?>
                </td>
                <td class="rightcolumn">
                    Printing<br>
                    <?php echo $set['official_code'] . '<br>'; ?>
                    Other Printings<br>
                    <?php
                    //code to add duplicate card sets
                    $other_sets = get_sets_by_card_name($card['card_name'], $set['set_id']);
                    foreach ($other_sets as $other_set) {
                        echo ' / ' . $other_set['official_code'];
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/pageNumbers.php'; ?>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>     
