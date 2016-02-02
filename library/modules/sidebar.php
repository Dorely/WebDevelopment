<div class="collectionsdiv">
    <h2>Collections</h2>
    <?php if (isset($_SESSION['user_name'])): ?>
    Welcome <?php echo $_SESSION['user_name'] ?><br>
        <a href=".?action=managecollections">Manage Collections</a><br>
        <a href=".?action=manageaccount">Manage Account</a><br>
        <form method="post" action="."><input type="submit" value="Logout"><input type="hidden" name="action" value="logout"></form>
        
    <?php else: ?>
        <div class="login" id="loginDiv">
        
        <form method="post" action=".">
            <input type="hidden" name="action" value="login">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <a href=".?action=signupform">Signup</a>
    </div>
    <?php endif; ?>
        <h3>Top 10 Collections</h3>
        <ul class="top10list">
        <?php
        $collections_10 = get_top_collections();
        
        //var_dump($collections_10);
        foreach($collections_10 as $collection_data){
            $collection_data = get_collection($collection_data['collection_id']);
            $collection_owner = get_owner($collection_data['collection_id']);
            
            echo '<li><a href=".?action=collection&amp;collectionid=' . $collection_data['collection_id'] . '">' . $collection_data['collection_name'] .' by '. $collection_owner['user_name'] . '</a></li> ' ;           
        }
        
        ?>
        </ul>
        <a href="?action=collectionsearch">Search Collections</a>
        
    
</div>