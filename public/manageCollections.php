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
        <h1>Collection Management</h1>
        <h2>Collections</h2>
        <div class="collectionlist">
            <ul>
                <?php
                if ($collections != false) {
                    //var_dump($collections);
                    foreach ($collections as $collection) {
                        $string = '<li><a href=".?action=collection&collectionid=' . $collection['collection_id'] . '">' . $collection['collection_name'] . '</a>  ';

                        if ($collection['is_public'] == 1) {
                            $string .= ' - Public Collection ';
                        } elseif ($collection['is_public'] == 0) {
                            $string .= ' - Private Collection ';
                        }
                        $string .= '</li>';
                        echo $string;
                    }
                }
                ?>
            </ul>
        </div>
        <h2>New Collection</h2>
        <form method="post" action=".">
            <input type="hidden" name="action" value="createcollection">
            <input type="text" name="collectionname" placeholder="Collection Name" required>
            <input type="text" name="description" placeholder="Description">
            <input type="checkbox" name="public" value="1" checked> <label>Public</label>
            <input type="submit" value="Add">
        </form>
        <h2>Edit Collection</h2>
        <div id="valuediv" style="display:none"></div>
        <form method="post" action=".">
            <input type="hidden" name="action" value="editcollection">
            <select name="collection_id" onchange="editCollection(this.value)">
                <?php foreach ($collections as $collection): ?>
                    <option value="<?php echo $collection['collection_id']; ?>"><?php echo $collection['collection_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <input id="name" type="text" name="collectionname" value="<?php
            if (isset($collections[0]['collection_name'])) {
                echo $collections[0]['collection_name'];
            }
            ?>" placeholder="Collection Name" required>
            <input id="desc" type="text" name="description" value="<?php
            if (isset($collections[0]['collection_description'])) {
                echo $collections[0]['collection_description'];
            }
            ?>" placeholder="Description">
            <input id="public" type="checkbox" name="public" value="1" <?php
            if (isset($collections[0]['is_public'])) {
                if ($collections[0]['is_public'] == 1) {
                    echo 'checked';
                }
            }
            ?>> <label>Public</label>
            <input id="priority" class="priority" type="number" value="<?php
                   if (isset($collections[0]['priority'])) {
                       echo $collections[0]['priority'];
                   }
                   ?>" name="priority"> <label>Priority</label>
            <input type="submit" value="Save Changes">
        </form>
        <h2>Delete Collection</h2>
        <form method="post" action=".">
            <input type="hidden" name="action" value="deletecollection">
            <select name="collection_id">
<?php foreach ($collections as $collection): ?>
                    <option value="<?php echo $collection['collection_id']; ?>"><?php echo $collection['collection_name']; ?></option>
<?php endforeach; ?>
            </select>
            <input type="submit" value="Delete">
        </form>
    </div>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>     
