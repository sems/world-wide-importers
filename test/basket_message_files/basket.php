<?php
    require('inc/config.php');

    // Define title variable
    $title = "Winkelwagen";

    // Defining view location
    $view = "basket.php";
?>

<!-- Script used to parse session variables to Noty -->
<script type='text/javascript'>
  var notyType = "<?php
    // Check for session variable
    if(isSet($_SESSION['basket_add'])){
        echo 'success';
    }
    if(isSet($_SESSION['basket_changed'])){
        echo 'info';
    }
    if(isSet($_SESSION['basket_remove'])){
        echo 'error';
    }
  ?>";
  var notyMessage = "<?php
    // Check for session variable and echo value. After that cleanup
    if(isSet($_SESSION['basket_add'])){
        echo $_SESSION['basket_add'];
        unset($_SESSION['basket_add']);
    }
    if(isSet($_SESSION['basket_changed'])){
        echo $_SESSION['basket_changed'];
        unset($_SESSION['basket_changed']);
    }
    if(isSet($_SESSION['basket_remove'])){
        echo $_SESSION['basket_remove'];
        unset($_SESSION['basket_remove']);
    }
  ?>";
</script>

<?php
    // Include template
    include_once $template;
?>