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

?>

<?php
    require "../Model/Product.php";
    require "../Model/Cart.php";
    if(isset($_POST["btnCheckOut"])){
        foreach($_SESSION['cart'] as $productId => $productData){
            
            Product::updateQuantity($_SESSION['cart'][$productId]['quantity'], $productId, $_SESSION['cart'][$productId]['quantityToBuy']);
        }
        $_SESSION['cart'] = array();
        Cart::deleteCart($_SESSION['Username']);
        header('Location: ../View/home.php');
        exit();
    }

    if(isset($_SESSION['cart'])){
        
        $cart = Cart::checkCartOfUser($_SESSION['Username']);
        if($cart != null){
            foreach($cart as $c){
                $p = Product::getProduct($c->product_id);
                $_SESSION['cart'][$p->id] = array(
                    "id" => $p->id,
                    "designation" => $p->designation,
                    "price" => $p->price,
                    "quantity" => $p->quantity,
                    "quantityToBuy" => $c->quantity
                );
            }
        }
        else{
            foreach($_SESSION['cart'] as $productId => $productData) {
                if(isset($_POST['quantity_'.$productId])) {
                    $quantity = $_POST['quantity_'.$productId];
                    if($quantity > 0) {
                        $_SESSION['cart'][$productId]['quantityToBuy'] = $quantity;
                    }
                    else {
                        unset($_SESSION['cart'][$productId]);
                        header('location: cart.php');
                    }
                }
            }
        }
        $total = 0;
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../style/cart_style.css">
                <title>Cart</title>
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

                        <div class="item">
                            <h2>Cart</h2>

                            <form method="post" action="">
                                <table border="1">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Image</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($_SESSION['cart'] as $productId => $productData) {
                                                $product = Product::getProduct($productId);
                                                echo "<tr>";
                                                echo "<td>" . $product->designation . "</td>";
                                                echo "<td><img src=\"../image/products/" . $product->id . ".jpg\">";
                                                echo "<td>" . $product->price . "$</td>";
                                                echo "<td><input type='number' max='" . $product->quantity . "' min='0' name='quantity_" . $productId . "' value='" . $productData['quantityToBuy'] . "'></td>";
                                                echo "<td><a class='btnUpdate' href='javascript:void(0);' onclick='updateCart(\"" . $productId . "\")'><button type='button'>Update</button></a></td>";
                                                echo "</tr>";
                                                $total += $product->price * $productData['quantityToBuy'];
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <input class="btnCheckOut" type="submit" name="btnCheckOut" value="Check Out">
                            </form>

                            <h3>Total: <?php echo $total; ?>$</h3>
                            
                        </div>
                    </div>                            
                    <br>

                    <footer>
                        <p>&copy; 2023 Mohamed Ali Walha<p>
                    </footer>
                </main>
            </body>
        </html>
        <?php
    }
?>

<script>
    function updateCart(productId) {
        var quantity = document.getElementsByName('quantity_' + productId)[0].value;
            window.location.href = '../Controller/cart_cont.php?update=1&product_id=' + productId + '&quantity=' + quantity;
    }
</script>
