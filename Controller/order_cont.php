<?php
if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['qt']) && !empty($_GET['qt']) && isset($_GET['qtToBuy']) && !empty($_GET['qtToBuy'])){
    require "../Model/Product.php";
    $nb = Product::updateQuantity($_GET['qt'], $_GET['id'], $_GET['qtToBuy']);
    if($nb > 0){
        header('location: ../View/home.php');
        exit;
    }
}
?>
