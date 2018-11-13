<?php
    session_start();

    // Database credentials
    define('DBHOST','localhost:3307');
    define('DBNAME','wideworldimporters');
    define('DBUSER','root');
    define('DBPASS','');

    $db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define template location
    $template = "inc/template.php";
?>
