<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/nav.php'; ?>

<div class="main">
<main role="main">
    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>
    <h1>Account Management</h1>
    <h2>Account Details</h2>
    <form method="post" action=".?action=editaccount">
        <input type="text" name="firstname" value="<?php echo $user['first_name']?>" placeholder="First Name" required><br>
        <input type="text" name="lastname" value="<?php echo $user['last_name']?>" placeholder="Last Name" required><br>
        <input type="text" name="email" value="<?php echo $user['email']?>" placeholder="Email" required><br>
        <input type="submit" value="Save Changes">
    </form>
    <h2>Change Password</h2>
    <form method="post" action=".?action=changepassword">
        <input type="password" name="oldpassword" placeholder="Old Password" required><br>
        <input type="password" name="newpassword" placeholder="New Password" required><br>
        <input type="password" name="repeatpassword" placeholder="Repeat Password" required><br>
        <input type="submit" value="Submit">
        
    </form>
</main>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/sidebar.php'; ?> 
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>     
