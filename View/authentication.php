<?php
    $msg = $err = "";
    session_start();
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
        header('Location: home.php');
        exit;
    }
    if(isset($_GET["msg"])){
        $msg = $_GET["msg"];
    }
    if(isset($_GET["err"])){
        $err = $_GET["err"];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/auth_style.css">
    <title>Authentication</title>
</head>
<body>

    <?php
        $errU = $errP = "";
        
        if(isset($_POST["btnConnect"])){
            if(!empty($_POST["Username"]) && !empty($_POST["Password"])){
                $_SESSION["Username"] = $_POST["Username"];
                $_SESSION["Password"] = $_POST["Password"];

                header('location: ../Controller/auth_cont.php');
                exit();
            }
            else{
                if($err == ""){
                    if(empty($_POST["Username"]))
                        $errU = "Username cannot be empty!";
                    if(empty($_POST["Password"]))
                        $errP = "Password cannot be empty!";
                }  
            }
        }
    ?>

    <form action="" method="post">
        <div id="auth_container">
            <h1>LogIn</h1>
            <p style="color:red"><?php if($err != ""){ echo $err; $err = ""; } else { $err = "";}?></p>
            <p style="color:green"><?php echo $msg ?></p>
            <br>
            <label>Username <input type="text" name="Username" maxlength="15"></label>
            <p style="color:red"><?php echo $errU ?></p>
            <label>Password <input type="password" name="Password" maxlength="20"></label>
            <p style="color:red"><?php echo $errP ?></p>
            <label><input type="checkbox" name="RememberMe" value="1"> Remember me</label>
            <p>Don't have an account ?</p>
            <a href="registration.php">Click here</a>
            <button type="submit" id="btnConnect" name="btnConnect">Connect</button>
        </div>
    </form>
</body>
</html>