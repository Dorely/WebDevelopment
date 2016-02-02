<?php
session_start();
$name = $_SESSION['name'];
$user_id = $_SESSION['user_id'];
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
    <h1>Character Creation</h1>
    <form action="." method="post">
        <input type="hidden" name="action" value="addcharacter">
        <label>Character Name</label>
        <input type="text" name="character_name" required><br>

        <label>Character Class</label>
        <input type="text" name="character_class" required><br>

        <label>Character Race</label>
        <input type="text" name="character_race" required><br>

        <label>&nbsp;</label>
        <input type="submit" value="Create Character"><br>
    </form>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>

