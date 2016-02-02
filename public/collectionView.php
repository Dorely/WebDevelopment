<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/nav.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/sidebar.php'; ?> 

<main role="main">
    <div class="main">
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <h1><?php echo $collection['collection_name'] ?></h1>
        <?php
        echo '<p>By ' . $ownerinfo['user_name'] . '</p>';
        ?>
        <p><?php echo $collection['collection_description']; ?></p>
        <p>
            <?php
            $collection_items = sort_collection($collection_items);
            $collection_count = count_collection($collection_items);
            echo 'Total Cards: ' . $collection_count;
            echo '<br>Total Likes: ' . $likes;
            ?>
        </p>
        <?php
        if ($owner && !$edit) {
            $editform = '<form method="get" action=".">'
                    . '<input type="hidden" name="action" value="collection">'
                    . '<input type="hidden" name="collectionid" value="' . $collection_id . '">'
                    . '<input type="hidden" name="editview" value="true">'
                    . '<input type="submit" value="Edit">'
                    . '</form>';
            echo $editform;
        }elseif(!$owner && isset($_SESSION['user_id'])){
            $already_liked = check_if_liked($collection_id, $_SESSION['user_id']);
            if(!$already_liked){
            $likeform = '<form method="post" action=".">'
                    . '<input type="hidden" name="action" value="like">'
                    . '<input type="hidden" name="collectionid" value="' . $collection_id . '">'
                    . '<input type="hidden" name="userid" value="'.$_SESSION['user_id'].'">'
                    . '<input type="submit" value="Like this collection">'
                    . '</form>';
            echo $likeform;}else{
                echo 'You have already liked this collection';
            }
        }
        ?>
        <table>
            <tr>
                <td class="collectionitemstd">
                    <?php if ($edit): ?>
                        <div class="collectionitemsform">
                            <table>
                                <form method="post" action=".">

                                    <?php $card_type = '' ?>
                                    <?php foreach ($collection_items as $item): ?>
                                        <?php
                                        //
                                        $next_card_type = $item['card_type'];
                                        if (stristr($next_card_type, 'creature')) {
                                            $next_card_type = 'Creatures';
                                        }
                                        if (stristr($next_card_type, 'artifact')) {
                                            $next_card_type = 'Artifacts';
                                        }
                                        if (stristr($next_card_type, 'enchantment')) {
                                            $next_card_type = 'Enchantments';
                                        }
                                        if (stristr($next_card_type, 'planeswalker')) {
                                            $next_card_type = 'Planeswalkers';
                                        }
                                        if (stristr($next_card_type, 'instant')) {
                                            $next_card_type = 'Instants';
                                        }
                                        if (stristr($next_card_type, 'sorcery')) {
                                            $next_card_type = 'Sorceries';
                                        }
                                        if (stristr($next_card_type, 'land')) {
                                            $next_card_type = 'Lands';
                                        }
                                        if (stristr($next_card_type, 'scheme')) {
                                            $next_card_type = 'Schemes';
                                        }
                                        if ($card_type != $next_card_type) {
                                            echo "<tr><td colspan ='2' class='cardtype'>$next_card_type</td></tr>";
                                            $card_type = $next_card_type;
                                        }
                                        ?>
                                        <tr>
                                            <?php $card = get_card($item['card_id']); ?>
                                            <td>

                                                <a data-url="<?php
                                            $set = get_set_by_id($card['set_id']);
                                            $url = '/pictures/' . $set['official_code'] . '/' . $card['card_name'];
                                            if ($card['variation_number'] != NULL) {
                                                $url = $url . $card['variation_number'];
                                            }
                                            $url = $url . '.jpg';
                                            $url = fix_url($url);
                                            echo $url;
                                            ?>" href=".?action=details&amp;cardname=<?php echo urlencode($card['card_name']) ?>&setid=<?php echo $card['set_id'] ?>"><?php echo $card['card_name'] ?></a>
                                            </td>
                                            <td>
                                                <input type="number" name="amount[]" value="<?php echo $item['amount'] ?>">
                                                <input type="hidden" name="collection_item_id[]" value="<?php echo $item['collection_item_id'] ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                    <input type="hidden" name="collectionid" value="<?php echo $collection_id ?>">
                                    <input type="hidden" name="action" value="updatecollectionitem">
                                    <input type="submit" value="Save Changes">
                                </form>
                            </table>
                        </div>
                    <?php else: ?>

                        <div class="collectionitems">
                            <?php $card_type = '' ?>
                            <?php foreach ($collection_items as $item): ?>
                                <?php
                                //
                                $next_card_type = $item['card_type'];
                                if (stristr($next_card_type, 'creature')) {
                                    $next_card_type = 'Creatures';
                                }
                                if (stristr($next_card_type, 'artifact')) {
                                    $next_card_type = 'Artifacts';
                                }
                                if (stristr($next_card_type, 'enchantment')) {
                                    $next_card_type = 'Enchantments';
                                }
                                if (stristr($next_card_type, 'planeswalker')) {
                                    $next_card_type = 'Planeswalkers';
                                }
                                if (stristr($next_card_type, 'instant')) {
                                    $next_card_type = 'Instants';
                                }
                                if (stristr($next_card_type, 'sorcery')) {
                                    $next_card_type = 'Sorceries';
                                }
                                if (stristr($next_card_type, 'land')) {
                                    $next_card_type = 'Lands';
                                }
                                if (stristr($next_card_type, 'scheme')) {
                                    $next_card_type = 'Schemes';
                                }
                                if ($card_type != $next_card_type) {
                                    echo "<div class='cardtype'>$next_card_type</div>";
                                    $card_type = $next_card_type;
                                }
                                ?>
                                <?php $card = get_card($item['card_id']); ?>
                                <a data-url="<?php
                        $set = get_set_by_id($card['set_id']);
                        $url = '/pictures/' . $set['official_code'] . '/' . $card['card_name'];
                        if ($card['variation_number'] != NULL) {
                            $url = $url . $card['variation_number'];
                        }
                        $url = $url . '.jpg';
                        $url = fix_url($url);
                        echo $url;
                                ?>" href=".?action=details&amp;cardname=<?php echo urlencode($card['card_name']) ?>&amp;setid=<?php echo $card['set_id'] ?>"><?php echo $card['card_name'] ?></a>

                                <?php echo 'x' . $item['amount'] . '<br>' ?>

                            <?php endforeach ?>



                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="cardviewarea">
                        <img id="imageChange" src="media/cardback.jpg" alt="The back of a magic card">
                    </div>
                </td>
            </tr>
        </table>
    </div>
</main>
<script>
    $(document).ready(function () {
        $("main a").mouseover(function () {
            $("#imageChange").attr("src", $(this).attr("data-url"));
        });
    });
</script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>     
