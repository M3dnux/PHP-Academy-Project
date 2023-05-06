<?php
session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true){
    header('Location: administration.php');
    exit;
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: authentication.php');
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

require_once "../Model/Product.php";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $products = Product::getProductsByName($search);
} else if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
    $min_price = $_GET['min_price'];
    $max_price = $_GET['max_price'];
    $products = Product::getProductsByPriceRange($min_price, $max_price);
} else {
    $products = Product::getAllProducts();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/home_style.css">
    <title>Home</title>
</head>
<body>
<main>
    <header id="header">
        <nav id="nav-bar">
            <ul>
                <li><a id="homeLink" href="../View/home.php" class="nav-link">Home 🏠</a></li>
                <li><a href="../View/cart.php" class="nav-link">Cart 🛒</a></li>
                <li><a href="../Controller/auth_cont.php?logout=true" class="nav-link">Sign out ⌫</a></li>
            </ul>
        </nav>
    </header>

    <div id="space"></div>

    <form id="searchByName" method="GET" action="">
        <input type="text" name="search" placeholder="Search by name">
        <input type="submit" value="Search">
    </form>

    <br>

    <form id="searchByPrice"  method="GET" action="">
        <label for="min_price">Minimum price:</label>
        <input type="number" name="min_price" id="min_price" min="0" value="0" step="0.01" required>
        <label for="max_price">Maximum price:</label>
        <input type="number" name="max_price" id="max_price" min="0" step="0.01" required>
        <input type="submit" value="Filter by price">
    </form>

    <div id="Offers">
        <?php foreach ($products as $product): ?>
            <div class="item">
                <h2><a href="description.php?id=<?php echo $product->id; ?>"><?php echo $product->designation; ?></a></h2>
                <br>
                <img src="../image/products/<?php echo $product->id; ?>.jpg">
                <br>
                <h1 style='color:#CC5500;'><?php echo $product->price . "$"; ?></h1>
                <br>
                <a class="btnOrder" href="order.php?id=<?php echo $product->id; ?>"><button type="button">Order</button></a>
                <a class="btnAddToCart" href="../Controller/cart_cont.php?id=<?php echo $product->id; ?>"><button type="button">🛒</button></a>
            </div>
        <?php endforeach; ?>
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