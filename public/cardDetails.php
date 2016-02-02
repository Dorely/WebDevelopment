
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/nav.php'; ?>

<main role="main">
    <h1>Card Details</h1>
    <table>
        <tr>
            <td class="leftcolumn">
                <img src="<?php
                $set = get_set_by_id($card['set_id']);
                $url = '/pictures/' . $set['official_code'] . '/' . $card['card_name'];
                if ($card['variation_number'] != NULL) {
                    $url = $url . $card['variation_number'];
                }
                $url = $url . '.jpg';

                $url = fix_url($url);
                echo $url;
                ?>" alt="Card Image Goes Here"><br>
                Fair Trade Price:<br>
                <div id="price_area">...Loading...<script>
                    $(document).ready(function () {
                        get_price()
                    });
                    </script></div>
                <div id="price_area_foil">...Loading...<script>

                    </script></div>
                Variations<br>
                <?php
                $variations = get_variations($card['card_name'], $set['set_id']);
                //var_dump($variations);
                foreach ($variations as $variation) {
                    if ($variation['variation_number'] == $card['variation_number']) {
                        echo ' ' . $variation['variation_number'] . ' ';
                    } else {
                        echo '<a href=".?action=details&amp;cardname=' . $card['card_name'] . '&amp;setid=' . $card['set_id'] . '&amp;variation=' . $variation['variation_number'] . '">' . $variation['variation_number'] . '</a> ';
                    }
                }
                ?>
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
                <a href="?action=collectionsearch&amp;searchstring=<?php echo urlencode($card['card_name']) ?>&amp;searchtype[]=searchbycard&amp;viewtype=results">Find collections that contain this card</a>
                <br>

                <?php echo '<span id="card_name">' . $card['card_name'] . '</span> ' . $card['mana_cost'] . ' (' . $card['converted_mana_cost'] . ')<br>'; ?>
                <?php
                echo $card['card_type'];
                if ($card['power'] != NULL) {
                    echo ' (' . $card['power'] . '/' . $card['toughness'] . ')' . '<br>';
                } elseif ($card['loyalty'] != NULL) {
                    echo ' (' . $card['loyalty'] . ')<br>';
                } else {
                    echo '<br>';
                }
                ?><br>
                <?php echo $card['ability_text']; ?><br><br>
                <?php echo $card['flavor_text']; ?>
            </td>
            <td class="rightcolumn">
                Printing<br>
                <?php
                echo '<span id="set_name">' . $set['set_name'] . '</span> (' . $set['official_code'] . ')<br>';
                echo $card['rarity'];
                ?>
                <br>Other Printings<br>
                <?php
                //code to add duplicate card sets
                $other_sets = get_sets_by_card_name($card['card_name'], $set['set_id']);
                foreach ($other_sets as $other_set) {
                    echo ' | <a href=".?action=details&cardname=' . $card['card_name'] . '&amp;setid=' . $other_set['set_id'] . '">' . $other_set['official_code'] . '</a>';
                }
                echo ' | ';
                ?>
            </td>
        </tr>
    </table>
    <h2>Rulings</h2>
    <div class="rulings">
        <?php echo $card['ruling_text'] ?>
    </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>     

