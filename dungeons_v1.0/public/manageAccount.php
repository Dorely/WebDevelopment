<?php
if (!isset($_SESSION)) {
    session_start();
}
$name = $_SESSION['name'];
$user_id = $_SESSION['user_id'];
$user_data = get_user_data($user_id);
$character_data = get_characters($user_id);
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/nav.php'; ?>

<main role="main">
    <?php
    if (ISSET($message)) {
        echo $message;
    }
    ?>
    <h1>Manage Account</h1>
    <h2>Account Info</h2>
    <div>
        <form method="post" action=".">
            <input type="hidden" name="action" value="updateaccount">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"> 
            <label>First Name</label><input type="text" name="first_name" value="<?php echo $user_data['first_name']; ?>"><br>
            <label>Last Name</label><input type="text" name="last_name" value="<?php echo $user_data['last_name']; ?>"><br>
            <label>Email</label><input type="email" name="email" value="<?php echo $user_data['email']; ?>"><br>
            <label></label>
            <input type="submit" value="Save Changes">
        </form>
    </div>
    <div>
        <h2>Change Password</h2>
        <form method="post" action=".">
            <input type="hidden" name="action" value="changepassword">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <label>Old Password</label><input type="password" name="old_password"><br><br>
            <label>New Password</label><input type="password" name="new_password"><br>
            <label>Confirm Password</label><input type="password" name="confirm_password"><br>
            <input type="submit" value="Change Password">
        </form>
    </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>