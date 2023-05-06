<?php
    session_start();
    $err = "";
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
        header('Location: home.php');
        exit;
    }
    if(isset($_GET["msg"])){
       $err = $_GET["msg"];
       $_GET["msg"] = "";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/reg_style.css">
    <title>Registration</title>
</head>
<body>

    <?php 
        $errU = $errP = $errRP = $errName = $errID = $errBdate = $errEmail = "";
        
        if(isset($_POST["btnCreateAccount"])){
            if(!empty($_POST["Username"]) && !empty($_POST["Password"]) && !empty($_POST["Name"]) && !empty($_POST["ID"]) && !empty($_POST["BirthDate"]) && !empty($_POST["Email"])){
                $_SESSION["Username"] = $_POST["Username"];
                $_SESSION["Password"] = $_POST["Password"];
                $_SESSION["Name"] = $_POST["Name"];
                $_SESSION["ID"] = $_POST["ID"];
                $_SESSION["BirthDate"] = $_POST["BirthDate"];
                $_SESSION["Email"] = $_POST["Email"];

                header('location: ../Controller/reg_cont.php');
                exit();
            }
            else{
                if (isset($_POST['Username'])){
                    if(empty($_POST['Username'])){
                        $errU = "Username cannot be empty!";
                    }
                }
        
                if (isset($_POST['Password'])){
                    if(empty($_POST['Password'])){
                        $errP = "Password cannot be empty!";
                    }
                }

                if (isset($_POST['Re-Password'])){
                    if(empty($_POST['Re-Password'])){
                        $errRP = "You need to re-enter password!";
                    }
                }

                if (isset($_POST['Name'])){
                    if(empty($_POST['Name'])){
                        $errName = "Name cannot be empty!";
                    }
                }

                if (isset($_POST['ID'])){
                    if(empty($_POST['ID'])){
                        $errID = "ID cannot be empty!";
                    }
                }

                if (isset($_POST['BirthDate'])){
                    if(empty($_POST['BirthDate'])){
                        $errBdate = "BirthDate cannot be empty!";
                    }
                }

                if (isset($_POST['Email'])){
                    if(empty($_POST['Email'])){
                        $errEmail = "Email cannot be empty!";
                    }
                }
            }
        }
    ?>

    <form action="" method="post">
        <div id="reg_container">
            <h1>SignUp</h1>
            <p style="color:red"><?php echo "$err" ?></p>
            <br>
            <label>Username <input type="text" name="Username" maxlength="15"></label>
            <p style="color:red"><?php echo "$errU" ?></p>
            <label>Password <input type="password" name="Password" maxlength="20"></label>
            <p style="color:red"><?php echo "$errP" ?></p>
            <label>Re-Password <input type="password" name="Re-Password" maxlength="20"></label>
            <p style="color:red"><?php echo "$errRP" ?></p>
            <label>Name <input type="text" name="Name" maxlength="30"></label>
            <p style="color:red"><?php echo "$errName" ?></p>
            <label>Id Card <input type="number" name="ID" maxlength="8"></label>
            <p style="color:red"><?php echo "$errID" ?></p>
            <label>Birth Date <input type="datetime-local" name="BirthDate"></label>
            <p style="color:red"><?php echo "$errBdate" ?></p>
            <label>E-mail <input type="email" name="Email" maxlength="40"></label>
            <p style="color:red"><?php echo "$errEmail" ?></p>
            <button type="submit" name="btnCreateAccount" id="btnCreateAccount" onclick="">Create Account</button>
            <button type="submit" id="btnCancel" name="btnCancel" onclick="">Cancel</button>
        </div>
    </form>
</body>
</html>

<?php 
    if(isset($_POST["btnCancel"]))
        header('location: authentication.php');
?>