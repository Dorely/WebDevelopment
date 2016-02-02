<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/nav.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/sidebar.php'; ?> 
<div class="main">
    <main role="main">
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <?php if (isset($collection_results)): ?>
            <div class="collectionresults">
                <a href="?action=collectionsearch">Search again</a>
                <h1>Results</h1>
                <ul>
                    <?php foreach ($collection_results as $collection_result): ?>
                        <?php
                        //var_dump($collection_result);
                        $collection = get_collection($collection_result['collection_id']);
                        $collection_owner = get_owner($collection_result['collection_id']);
                        ?>
                        <li><a href="<?php
                            echo '.?action=collection&amp;collectionid=' .
                            $collection['collection_id']
                            ;
                            ?>"><?php echo $collection['collection_name'] . ' by ' . $collection_owner['user_name']; ?></a></li>

                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
        <h1>Collection Search</h1>
        <form action="." method="get">
            <input type="text" name="searchstring" placeholder="Type your search here"><br>
            <input type="hidden" name="action" value="collectionsearch">
            <input type="hidden" name="viewtype" value="results">
            <input type="submit" value="Search"><br>
            <input type="checkbox" value="collectionname" name="searchtype[]" checked><label>Search by Collection name</label><br>
            <input type="checkbox" value="collectiondesc" name="searchtype[]" checked><label>Search by Collection Description</label><br>
            <input type="checkbox" value="searchbyusername" name="searchtype[]" checked><label>Search by User Name</label><br>
            <input type="checkbox" value="searchbycard" name="searchtype[]" checked><label>Search by Card Names</label><br>
        </form>
        <?php endif; ?>



    </main>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>     
