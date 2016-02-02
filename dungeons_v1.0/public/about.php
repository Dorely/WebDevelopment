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
    <h1>About</h1>
    <p>My name is Jonathan Harmon, I am a CIT student at BYU-Idaho.</p>
    <p>I designed, programmed, and built every part of this website from the database to the css.</p>
    <p>This website was built as project for a class I am taking for college. This is in fact my very first
    PHP web application, so I know things may be a bit messy, and the focus of the project was the PHP and so some 
    of the CSS may have been put on the back burner. I do still consider this a work in progress, and hope to add more
    features in the future.</p>
    <p>Thanks for using it!</p>
    

</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>
