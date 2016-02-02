<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/nav.php'; ?>

<div class="main">
    <main role="main">
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <h1>Card Search</h1>
        <form action="." method="get">
            <input type="text" name="search" placeholder="Type your search here"><br>
            <input type="submit" name="action" value="Search">
            <ul>
                <li><input type="checkbox" name="searchtype[]" value="name" checked></li>
                <li><label>Name</label></li>
                <li><input type="checkbox" name="searchtype[]" value="text"></li>
                <li><label>Text</label></li>
                <li><input type="checkbox" name="searchtype[]" value="types"></li>
                <li><label>Types</label></li>
                <li><input type="checkbox" name="searchtype[]" value="flavor"></li>
                <li><label>Flavor Text</label></li>
            </ul>
            <input type="checkbox" name="searchtype[]" value="searchexactly">
            <label>Search Exactly?(Dont Split the words)</label>
            <ul>
                <li><input type="checkbox" name="colors[]" value="W"></li>
                <li><label><img src="media/White_Mana.png" alt="White Mana Symbol"></label></li>
                <li><input type="checkbox" name="colors[]" value="U"></li>
                <li><label><img src="media/Blue_Mana.png" alt="Blue Mana Symbol"></label></li>
                <li><input type="checkbox" name="colors[]" value="B"></li>
                <li><label><img src="media/Black_Mana.png" alt="Black Mana Symbol"></label></li>
                <li><input type="checkbox" name="colors[]" value="R"></li>
                <li><label><img src="media/Red_Mana.png" alt="Red Mana Symbol"></label></li>
                <li><input type="checkbox" name="colors[]" value="G"></li>
                <li><label><img src="media/Green_Mana.png" alt="Green Mana Symbol"></label></li>
            </ul>
            <input type="checkbox" name="colortype" value="1">
            <label>Search Colors Exactly</label><br>
            <input type="checkbox" name="searchtype[]" value="excludecolors">
            <label>Exlude Unselected Colors?</label><br>
            <label>Set</label>
            <input type="checkbox" name="searchbyset" value="1">
            <select name="set_id">
                <?php foreach ($sets as $set): ?>
                    <option value="<?php echo $set['set_id']; ?>"><?php echo $set['set_name']; ?></option>
                <?php endforeach; ?>
            </select>

        </form>

    </main>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/sidebar.php'; ?> 
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>     
