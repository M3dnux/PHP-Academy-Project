<?php
session_start();
require "../Model/Product.php";
require "../Model/Cart.php";
if(isset($_SESSION['cart'])) {

    if(isset($_GET['update']) && $_GET['update'] == 1 && isset($_GET['product_id']) && isset($_GET['quantity'])){
        $productId = $_GET['product_id'];
        if($_GET['quantity'] > 0){
            Cart::updateQuantity($_SESSION['Username'], $productId, $_GET['quantity']);
        }
        else{
            Cart::deleteFromCart($_SESSION['Username'], $productId);
            unset($_SESSION['cart'][$productId]);
        }
    }

    if (isset($_GET['id'])) {
        $productId = $_GET['id'];
    
            
        if (isset($_SESSION['cart'][$productId])) {
            
            $_SESSION['cart'][$productId]['quantityToBuy']++;
            Cart::updateQuantity($_SESSION['Username'], $productId, $_SESSION['cart'][$productId]['quantityToBuy']);
        }
        else{
            $_SESSION['cart'][$productId] = array(
                "id" => $product->id,
                "designation" => $product->designation,
                "price" => $product->price,
                "quantity" => $product->quantity,
                "quantityToBuy" => 1
            );
            Cart::addToCart($_SESSION['Username'],$productId,$_SESSION['cart'][$productId]['quantityToBuy']);
        }
        }
    
    
    }


header('Location: ../View/home.php');
exit();
?>