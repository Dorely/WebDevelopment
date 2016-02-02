<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/nav.php'; ?>
<main role="main">
    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>
    <h1>Signup</h1>
    <div class="signup">
        <form method="post" action=".">
            <input type="hidden" name="action" value="signup" required>
            <input type="text" name="firstname" placeholder="First Name" required <?php if(isset($first_name)) {echo 'value="'.$first_name.'"';}?>>
            <input type="text" name="lastname" placeholder="Last Name" required <?php if(isset($last_name)) {echo 'value="'.$last_name.'"';}?>>
            <input type="text" name="username" placeholder="User Name" required <?php if(isset($user_name)) {echo 'value="'.$user_name.'"';}?>>
            <input type="email" name="email" placeholder="Email" required <?php if(isset($email)) {echo 'value="'.$email.'"';}?>>
            <input type="password" name="password1" placeholder="Password" required>
            <input type="password" name="password2" placeholder="Repeat Password" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>     
