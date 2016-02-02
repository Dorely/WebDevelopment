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
    <h1>User Home</h1>
    <h2>Characters</h2>
    <a href=".?action=createcharacter" title="Create a new character">Create a new character</a>

    <table>
        <?php foreach ($character_data as $character) : ?>
            <tr>
                <td><?php echo $character['character_name'] . ' level ' . $character['level'] . ' ' . $character['class']; ?></td>
                <td><form method="post" action=".">
                        <input type="hidden" name="action" value="editcharacter">
                        <input type="hidden" name="character_id" value="<?php echo $character['character_id'] ?>">
                        <input type="submit" value="Edit">
                    </form></td>
                <td><form method="post" action=".">
                        <input type="hidden" name="action" value="deletecharacter">
                        <input type="hidden" name="character_id" value="<?php echo $character['character_id'] ?>">
                        <input type="submit" value="Delete">
                    </form></td>
                
            </tr>
        <?php endforeach; ?>
    </table>

</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>
