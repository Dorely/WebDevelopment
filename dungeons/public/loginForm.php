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
    <h1>Login</h1>
    <p>Welcome to Dungeon Companion! This is a free website that offers a saveable
        character sheet for Dungeons and Dragons version 5, as well as a virtual
    dice emulator. Log in or Sign up Today!</p>
    <form method="post" action=".">
        <input type="hidden" name="action" value="authenticate">
        <label>Email</label> <input class="infoform" type="email" name="email" size="40" required value="<?php
        if (ISSET($email)) {
            echo $email;
        }
        ?>"><br>
        <label>Password</label><input class="infoform" type="password" name="password" size="40" required><br>
        <label></label><input type="submit" value="Log-In"><br>
        <label></label><a href=".?action=signup" title="Signup">Or Sign Up!</a>
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