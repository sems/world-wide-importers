<?php
    session_start();

    //database credentials
    define('DBHOST','localhost');
    define('DBNAME','wideworldimporters');
    define('DBUSER','root');
    define('DBPASS','');

    $db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Define template location
    $template = "template.php";
?>
