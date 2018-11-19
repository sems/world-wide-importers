<!--
    <div style="margin-top: 0; margin-left: 0; color: red; background-color: black; z-index: 9999;">
        Dit is een school project!
    </div>
-->

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">World Wide Importers</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <?php
                // Add new pages in array, "filename.php" => "Name",
                $pages = array(
                    "Kleren" => array(
                        "products.php?filter=Clothing" => "Kleren",
                        "products.php?filter=Furry Footwear" => "Pantoffels",
                        "products.php?filter=T-Shirts" => "T-Shirts",
                    ),
                    "Diverse" => array(
                        "products.php?filter=Novelty Items" => "Snufjes",
                        "products.php?filter=Airline Novelties" => "Vliegtuig artikelen",
                        "products.php?filter=Computing Novelties" => "Computer artikelen",
                        "products.php?filter=USB Novelties" => "USB's",
                    ),
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
            <form action="products.php" method="get" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" name="global_search" type="search" placeholder="Zoeken" aria-label="Zoeken">
                <div>
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Zoek</button>
                    <a class="btn btn-primary my-2 my-sm-0 basketBtn <?php print($title == "Winkelwagen" ? "basketActive":""); ?>" href="basket.php"><i class="fas fa-shopping-basket basket"></i></a>
                    <?php
                        // Checks if user is logged in or not.
                        if(!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] == false)) {
                            print("<a class='btn btn-primary my-2 my-sm-0 basketBtn".($title == 'Login' ? 'basketActive':'')."' href='login.php'><i class='fas fa-sign-in-alt basket'></i></a></li>");
                            //print("<a class='btn btn-primary my-2 my-sm-0 basketBtn".($title == 'Registreer' ? 'basketActive':'')."' href='register.php'><i class='fas fa-user basket'></i></a></li>");
                        } else {
                            print("<a class='btn btn-primary my-2 my-sm-0 basketBtn".($title == 'Profiel' ? 'basketActive':'')."' href='profile.php'><i class='fas fa-user basket'></i></a></li>");
                            print("<a class='btn btn-primary my-2 my-sm-0 basketBtn".($title == 'Uitloggen' ? 'basketActive':'')."' href='logout.php'><i class='fas fa-sign-out-alt basket'></i></a></li>");
                        };
                    ?>
                </div>
            </form>
        </div>
    </div>
</nav>
