<?php

if(!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] == false)) {
    header('Location: login.php');
    exit();
} else {
    $loggedInMess = 'Welkom '.$_SESSION['user'].', wat leuk dat je er weer bent.';
    echo($loggedInMess);
}

?>