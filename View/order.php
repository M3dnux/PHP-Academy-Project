<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: authentication.php');
    exit;
}

if (isset($_SESSION['admin']) && $_SESSION['admin'] == true){
    header('Location: administration.php');
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
        <link rel="stylesheet" href="../style/order_style.css">
        <title>Order</title>
    </head>
    <body>
        <main>
            <header id="header">
                <nav id="nav-bar">
                    <ul>
                        <li><a id="homeLink" href="../View/home.php" class="nav-link">Home 🏠</a></li>
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
                echo "<form action='#>";
                echo "<div class='buy_form'>";
                echo "<label>Price : <input type=\"text\" id=\"price\" disabled=\"disabled\" value=\"$price\"></label>";
                echo "<label>Quantity : <input type=\"number\" id=\"quantity\" min='1' max=\"$product->quantity\" value=\"1\" onchange=\"updatePrice()\"></label>";
                echo "<label>Total Price : <input type=\"text\" id=\"totalPrice\" disabled=\"disabled\" value=\"$price\"></label>";
                echo "<a class='btnOrder' href=\"../Controller/order_cont.php?id=$product->id&qt=$product->quantity&qtToBuy=\" id=\"payCreditCard\"><button type=\"button\">Buy</button></a>";
                echo "</div>";
                echo "</from>";
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
<script>
        document.getElementById('payCreditCard').addEventListener('click', function() {
            let qtToBuy = document.getElementById('quantity').value;
            let href = this.getAttribute('href');
            href += qtToBuy;
            this.setAttribute('href', href);
        });
    </script>