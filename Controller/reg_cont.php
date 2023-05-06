<?php
    session_start();
    $userName   = $_SESSION["Username"];
    $password   = $_SESSION["Password"];
    $name       =  $_SESSION["Name"];
    $id         =  $_SESSION["ID"];
    $birthdate  =  $_SESSION["BirthDate"];
    $email      =  $_SESSION["Email"];
    require("../Model/User.php");

    $u = User::getUser($userName);
    if($u != null){
        header('Location: ../View/registration.php?msg=User already exists!');
    }
    else{
        $u = new User($userName, $password, $name, $id, $birthdate, $email);
        $result = User::addUser($u);
        if ($result > 0) {
            header('Location: ../View/authentication.php?msg=User successfully created!');
        }
    }
?>