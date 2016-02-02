<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/header.php'; ?>
<nav>
    <div>
        <ul>
            
        </ul>
    </div>
</nav>

<main role="main">
    <?php
    if (ISSET($message)) {
        echo $message;
    }
    ?>
    <h1>Sign Up</h1>
    <form method="post" action=".">
        <input type="hidden" name="action" value="adduser">
        <label>First name</label><input type="text" name="first_name" size="40" required value="<?php
        if (ISSET($first_name)) {
            echo $first_name;
        }
        ?>"><br>
        <label>Last name</label><input type="text" name="last_name" size="40" required value="<?php
        if (ISSET($last_name)) {
            echo $last_name;
        }
        ?>"><br>
        <label>Email</label> <input type="email" name="email" size="40" required value="<?php
        if (ISSET($email)) {
            echo $email;
        }
        ?>"><br>
        <label>Password</label><input type="password" name="password" size="40" required><br>
        <label>Confirm Password</label><input type="password" name="confirm_password" size="40" required><br>
        <input id="button" type="submit" name="submit" value="Sign-Up"><br>
        <label></label><a href=".?action=login">Or Login!</a>
    </form>

</main>
<footer role="contentinfo">
    <div>
        <ul>
            
        </ul>
    </div>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56125884-2', 'auto');
  ga('send', 'pageview');

</script>
</footer>
</div>
</body>
</html>