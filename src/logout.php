<?php
    require('inc/config.php');

    /*
    * Start, Unset, Destroy session
    */
    session_start();
    session_unset();
    session_destroy();

    // Redirect to index
    header("location: index.php");
    exit();
?>
