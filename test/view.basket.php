if(isSet($_SESSION['basket_add'])){
            //Access your Session variables
            $temp = $_SESSION['basket_add'];
            echo '<div class="alert alert-success" role="alert">'.$temp."</div>";
            //Unset the useless session variable
            unset($_SESSION['basket_add']);
        }
        if(isSet($_SESSION['basket_changed'])){
            //Access your Session variables
            $temp = $_SESSION['basket_changed'];
            echo '<div class="alert alert-info" role="alert">'.$temp."</div>";
            //Unset the useless session variable
            unset($_SESSION['basket_changed']);
        }