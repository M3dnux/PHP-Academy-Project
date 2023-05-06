<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header('Location: authentication.php');
    exit;
}

else if (!isset($_SESSION['admin']) || $_SESSION['admin'] == false){
    header('Location: home.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style/admin_style.css">
        <title>Admin Dashboard</title>
    </head>
    <body>
        <main>
            <header id="header">
                <nav id="nav-bar">
                    <ul>
                        <li><a id="btnAdminDashboardLink" href="../View/home.php" class="nav-link">Admin Dashboard ⚙️</a></li>
                        <li><a href="../Controller/auth_cont.php?logout=true" class="nav-link">Sign out ⌫</a></li>
                    </ul>
                </nav>
            </header>

            <div id="space"></div>

            <div id="Offers">

            <?php
                require "../Model/Product.php";
                $products = Product::getAllProducts();
                echo "<div class=\"item\">";
                echo "<h2></h2>";
                echo "<h1><br><br><br><br><a href='../Controller/admin_cont.php?add=true'>+</a><br><br><br><br><br></h1>";
                echo "</div>";
                foreach ($products as $product) {
                    echo "<div class=\"item\">";
                    echo "<h2><a href=\"description.php?id=" . $product->id . "\">" . $product->designation . "</h2></a>";
                    echo "<br>";
                    echo "<img src=\"../image/products/" . $product->id . ".jpg\">";
                    echo "<br>";
                    echo "<a class='btnOrder' href=\"../Controller/admin_cont.php?id=1" . $product->id . "\"><button type=\"button\">Update</button></a>";
                    echo "<a class='btnOrder' href=\"../Controller/admin_cont.php?id=0" . $product->id . "\" onclick=\"return confirm('Are you sure you want to delete this product?');\"><button type=\"button\">Delete</button></a>";
                    echo "</div>";
                }
            ?>

            </div>

            <div class="navigate">
                <button id="back" onclick=""><</button>
                <p id="numberPage">1/1</p>
                <button id="next" onclick="">></button>
            </div>

            <br>

            <footer>
                <p>&copy; 2023 Mohamed Ali Walha<p>
            </footer>
        </main>
    </body>
</html>
