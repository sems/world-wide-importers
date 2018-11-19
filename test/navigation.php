<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">World Wide Importers</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent"><ul class="navbar-nav mx-auto my-auto d-inline w-50">
            <form action="products.php" method="get" class="w-100">
                <div class="input-group">
                    <input name="search" type="text" class="form-control border border-right-0" placeholder="Zoeken...">
                    <span class="input-group-append">
                    <button class="btn btn-outline-light border border-left-0" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                </div>
            </form></ul>

            <ul class="navbar-nav ml-auto">
                <a class="btn btn-primary my-2 my-sm-0 basketBtn <?php print($title == "Winkelwagen" ? "basketActive":""); ?>" href="basket.php"><i class="fas fa-shopping-basket basket"></i></a>
                <?php
                    // Checks if user is logged in or not.
                    if(!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] == false)) {
                        echo "<a class='btn btn-primary my-2 my-sm-0 basketBtn".($title == 'Login' ? 'basketActive':'')."' href='login.php'><i class='fas fa-sign-in-alt basket'></i></a></li>";
                        //echo "<a class='btn btn-primary my-2 my-sm-0 basketBtn".($title == 'Registreer' ? 'basketActive':'')."' href='register.php'><i class='fas fa-user basket'></i></a></li>";
                    } else {
                        echo "<a class='btn btn-primary my-2 my-sm-0 basketBtn".($title == 'Profiel' ? 'basketActive':'')."' href='profile.php'><i class='fas fa-user basket'></i></a></li>";
                        echo "<a class='btn btn-primary my-2 my-sm-0 basketBtn".($title == 'Uitloggen' ? 'basketActive':'')."' href='logout.php'><i class='fas fa-sign-out-alt basket'></i></a></li>";
                    };
                ?>
            </ul>
        </div>

            <!--<ul class="navbar-nav ml-auto">-->
    </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-fill w-100">
                <?php
                    // Add new pages in array, "filename.php" => "Name",
                    $pages = array(
                        //"Kleren" => array(
                            "products.php?filter=Clothing" => "Kleren",
                            "products.php?filter=Furry Footwear" => "Pantoffels",
                            "products.php?filter=T-Shirts" => "T-Shirts",
                        //),
                        //"Diverse" => array(
                            "products.php?filter=Novelty Items" => "Snufjes",
                            "products.php?filter=Airline Novelties" => "Vliegtuig artikelen",
                            "products.php?filter=Computing Novelties" => "Computer artikelen",
                            "products.php?filter=USB Novelties" => "USB's",
                        //),
                        "products.php?filter=Toys" => "Speelgoed",
                        "products.php?filter=Mugs" => "Mokken",
                        "products.php?filter=Packaging Materials" => "Verpakking",
                    );

                    // For every page defined in $pages array, add to navigation
                    foreach ($pages as $key => $value) {
                        if (is_array($value)) {
                            print("<li class='nav-item dropdown'>
                                    <a class='nav-link dropdown-toggle".(in_array($title, $value) ? " active":"")."' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                        $key
                                    </a>
                                    <div class='dropdown-menu' aria-labelledby='navbarDropdown'>");
                            foreach ($value as $_key => $_value) {
                                print("<a class='dropdown-item".($title == $_value ? " active":"")."' href='$_key'>$_value</a>");
                            }
                            print("</div></li>");
                        } else {
                            print("<li class='nav-item ".($title == $value ? "active":"")."'>
                                    <a class='nav-link' href='$key'>$value</a>
                                </li>");
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>
