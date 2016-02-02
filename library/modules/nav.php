<nav role="navigation">
    <div <?php
    if(isset($action)){
    if ($action != 'details') {
        echo 'class="main"';
    }}
    ?>>
        <ul>
            <li><a href="/" title="Go back to the main search page">Home</a></li>
            <li><a href=".?action=trade">Trade Calculator</a></li>
        </ul>

    </div>
</nav>

