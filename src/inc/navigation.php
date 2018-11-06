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
                    "index.php" => "Home",
                    "products.php" => "Producten",
                    "basket.php" => "Winkelwagen",
                    "products.php?filter=Clothing" => "Kleren",
                    "products.php?filter=Novelty Items" => "Snufjes",
                    "products.php?filter=Toys" => "Speelgoed",
                    "products.php?filter=Packaging Materials" => "Verpakking",
                );

                // For every page defined in $pages array, add to navigation
                foreach ($pages as $key => $value) {
                    print("<li class='nav-item ".($title == $value ? "active":"")."'>
                            <a class='nav-link' href='$key'>$value</a>
                        </li>");
                }
                // Checks if user is logged in or not.
                if(!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] == false)) {
                    echo "<li class='nav-item ".($title == "Login" ? "active":"")."'><a class='nav-link' href='login.php'>Login</a></li>";
                    echo "<li class='nav-item ".($title == "Registreer" ? "active":"")."'><a class='nav-link' href='register.php'>Registeer</a></li>";
                } else {
                    echo "<li class='nav-item ".($title == "Profiel" ? "active":"")."'><a class='nav-link' href='profile.php'>Profiel</a></li>";
                    echo "<li class='nav-item ".($title == "Uitloggen" ? "active":"")."'><a class='nav-link' href='logout.php'>Uitloggen</a></li>";
                };
            ?>
            </ul>
            <form action="products.php" method="get" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" name="search" type="search" placeholder="Zoeken" aria-label="Zoeken">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Zoek</button>
            </form>
        </div>
    </div>
</nav>
