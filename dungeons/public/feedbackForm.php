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
    <h1>Feedback</h1>
    <p>I would love to hear your suggestions as to how to make this site better! Submit below.</p>
    <p>Before you ask for specific things, I'll let you know that these are on my to-do list</p>
    <ul>
        <li>Make the dice emulator prettier(suggestions for how to accomplish this are still good)</li>
        <li>Add responsive CSS to the character sheet(I Know that right now it is kind of annoying,
            I just didn't have the time to do this on first draft)</li>
        <li>Add a character creation process that follows D&amp;D rules</li>
        <li>Add calculate buttons to the character sheet for figuring modifiers and other things automagically</li>
    </ul>

    <form method="post" action=".">
        <input type="hidden" name="action" value="feedbacksubmit">
        <input type="hidden" name="user_id" value="<?php echo $user_id?>">
        <textarea name="feedback" cols="50" rows="10"></textarea><br>
        <input type="submit" value="Submit Feedback">
    </form>

</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>
