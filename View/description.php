<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: authentication.php');
    exit;
}


if(!isset($_GET['id'])){
    header('Location: home.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style/description_style.css">
        <title>Description</title>
    </head>
    <body>
        <main>
            <header id="header">
                <nav id="nav-bar">
                    <ul>
                        <li><a id="btnHome_adminD" href="<?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == true) echo '../View/administration.php'; else echo '../View/home.php'; ?>" class="nav-link"><?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == true) echo 'Admin Dashboard ⚙️'; else echo 'Home 🏠'; ?></a></li>
                        <?php if(!(isset($_SESSION['admin']) && $_SESSION['admin'] == true)) echo '<li><a href="../View/cart.php" class="nav-link">Cart 🛒</a></li>'; ?>
                        <li><a href="../Controller/auth_cont.php?logout=true" class="nav-link">Sign out ⌫</a></li>
                    </ul>
                </nav>
            </header>

            <div id="space"></div>

            <div id="Offer">

                <?php
                    require "../Model/Product.php";
                    $product = Product::getProduct($_GET['id']);
                    $price = $product->price;

                    echo "<div class=\"item\">";
                    echo "<h2>" . $product->designation . "</h2>";
                    echo "<br>";
                    echo "<img src=\"../image/products/" . $product->id . ".jpg\">";
                    echo "<br>";
                    echo "<p>" . $product->description . "</p>";
                    echo "<br>";
                    echo "<h1 style='color:#CC5500;'>Price : " . $product->price . "$</h1>";
                    echo "<br>";
                    echo "<h1>Stock : " . $product->quantity . "</h1>";
                    if(!(isset($_SESSION['admin']) && $_SESSION['admin'] == true)) echo "<center><a class='btnOrder' href=\"order.php?id=" . $product->id . "\"><button type=\"button\">Order</button></a></center>";
                    echo "</div>";
                ?>

            </div>

            <br>

            <footer>
                <p>Copyright &copy; 2023 Mohamed Ali Walha<p>
            </footer>
        </main>
        <script>
        function updatePrice() {
            let quantity = document.getElementById("quantity").value;
            let price = <?php echo $price; ?>;
            let totalPrice = quantity * price;
            document.getElementById("totalPrice").value = totalPrice;
            }
        </script>
    </body>
</html>