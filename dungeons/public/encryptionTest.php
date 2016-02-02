<?php

$cleartext = 'newpassword12';
$salt = '$6$!@#$%^&*()_+_)(*';
//$hash = crypt($cleartext);

echo $cleartext . '<br>';
echo crypt($cleartext,$salt) . '<br>';