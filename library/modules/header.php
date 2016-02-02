<!DOCTYPE html>
<html >
    <head>
        <meta charset="utf-8">
        <title> Home | mtgathering </title>
        <meta name="description" content="Search for magic cards, add them to collections, share your collections with your friends">
        <meta name="author" content="Jonathan Harmon">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="/css/screen.css?v2" rel="stylesheet" type="text/css" media="screen">
        <link rel="shortcut icon" href="/mylogo-favicon.ico" >
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="/javascript/scripts.js"></script> 
    </head>
    <body>
        <div>
            <header role="banner">
                <div <?php
                if(isset($action)){
                if ($action != 'details') {
                    echo 'class="main"';
                }}
                ?>>
                    
                </div>
            </header>

