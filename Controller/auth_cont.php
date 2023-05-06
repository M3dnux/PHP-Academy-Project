<?php
session_start();

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    $_SESSION['logged_in'] = false;
    session_start();
    session_unset();
    session_destroy();
    header('Location: ../View/authentication.php');
    exit;
}

if (!isset($_SESSION['Username']) || !isset($_SESSION['Password'])) {
    session_destroy();
    header('Location: ../View/authentication.php');
    exit;
}

$userName = $_SESSION["Username"];
$password = $_SESSION["Password"];

require_once "../Model/User.php";

$result = User::connect($userName, $password);

if ($result) {
    $_SESSION['logged_in'] = true;
    if ($userName === "admin") {
        $_SESSION['admin'] = true;
        header('Location: ../View/administration.php');
        exit;
    } else {
        header('Location: ../View/home.php');
        exit;
    }
} else {
    session_destroy();
    header('Location: ../View/authentication.php?err=There is no account<br>registered with that<br>username / password!');
    exit;
}
?>