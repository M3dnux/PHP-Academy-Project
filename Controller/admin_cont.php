<?php 
    require "../Model/Product.php";
    $product = null;

    if(isset($_POST['btnAddP'])){
        $id = $_POST['id'];
        $designation = $_POST['designation'];
        $description = $_POST['description'];
        $brand = $_POST['brand'];
        $color = $_POST['color'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        if($id != "" && $designation != "" && $description != "" && $brand != "" && $color != "" && $quantity != "" && $price != "")
        {
        $product = new Product($id, $designation, $description, $brand, $color, $quantity, $price);
        
        $nb = Product::addProduct($product); 
            if($nb > 0){
                if(isset($_FILES['img_src']) && $_FILES['img_src']['error'] == 0) {
                    $uploaded_file = $_FILES['img_src']['tmp_name'];
                    $new_file_name = "{$product->id}.jpg";
                    $destination = "../image/products/{$new_file_name}";
                    move_uploaded_file($uploaded_file, $destination);
                }
                header('location: ../View/administration.php');
            }
            else {
                echo "<script>alert('Product alredy exists');</script>";
            }
        }
        else {   
            echo "<script>alert('All fields must not be empty');</script>";
        }
        
    }

        if(isset(($_GET['id']))) {
        $product = Product::getProduct(substr($_GET['id'], 1));
        }
        if($product != null) {
    }

    if(isset($_GET['add']) && $_GET['add'] == true){
        // html to add a product
        echo '<!DOCTYPE html>
                <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="stylesheet" href="../style/admin_cont_style.css">
                        <title></title>
                    </head>
                    <body>
                        <main>
                            <header id="header">
                                <nav id="nav-bar">
                                    <ul>
                                        <li><a id="btnAdminDashboardLink" href="../View/home.php" class="nav-link">Admin Dashboard ⚙️</a></li>
                                        <li><a href="../Controller/auth_cont.php?logout=true" class="nav-link">Sign out ⌫</a></li>
                                    </ul>
                                </nav>
                            </header>

                            <div id="space"></div>

                            <div id="Offer">

                                <div class="item">
                                    <h2>Adding a new product</h2>
                                    <form id="update-form" method="POST" enctype="multipart/form-data">
                                        <label>ID : <input type="text" name="id" maxlength="12"></label>
                                        <br>
                                        <label>Designation : <input type="text" name="designation" maxlength="30"></label>
                                        <br>
                                        <label style="display: inline-block; vertical-align: middle;">Description : </label><textarea name="description" maxlength="200" style="display: inline-block; vertical-align: middle; width: 40%; height: 60px;"></textarea>
                                        <br>
                                        <label>Brand : <input type="text" name="brand" maxlength="15"></label>
                                        <br>
                                        <label>Color : <input type="text" name="color" maxlength="15"></label>
                                        <br>
                                        <label>Quantity : <input type="number" min="1" name="quantity"></label>
                                        <br>
                                        <label>Price : <input type="number" name="price"></label>
                                        <br>
                                        <br>
                                        <label for="img_src">Add an Image : </label>
                                        <br>
                                        <input type="file" name="img_src" id="img_src" accept="image/*">
                                        <br>
                                        <input id="btnAddP" type="submit" name="btnAddP" value="Add">
                                        <input id="btnCancel" type="button" value="Cancel" onclick="window.location.href = \'../View/administration.php\';">
                                    </form>
                                </div>
                            </div>
            
                                <footer>
                                    <p>&copy; 2023 Mohamed Ali Walha<p>
                                </footer>
                            </main>
                        </body>
                    </html>';
    }
    else{

        if(isset($_POST['btnUpdate'])) {
            $id = substr($_GET['id'], 1);
            $designation = $_POST['designation'];
            $description = $_POST['description'];
            $brand = $_POST['brand'];
            $color = $_POST['color'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];

            $product = new Product($id, $designation, $description, $brand, $color, $quantity, $price);

            Product::updateProduct($product); 
            if(isset($_FILES['img_src']) && $_FILES['img_src']['error'] == 0) {
                if(file_exists("../image/products/{$product->id}.jpg")) {
                    unlink("../image/products/{$product->id}.jpg");
                }
                $uploaded_file = $_FILES['img_src']['tmp_name'];
                $new_file_name = "{$product->id}.jpg";
                $destination = "../image/products/{$new_file_name}";
                move_uploaded_file($uploaded_file, $destination);
            }
            header('location: ../View/administration.php');
        }


        $product = Product::getProduct(substr($_GET['id'], 1));
        if($product != null) {
            // html to update a product
            if($_GET["id"][0] == 1) {
                echo '<!DOCTYPE html>
                <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link rel="stylesheet" href="../style/admin_cont_style.css">
                        <title></title>
                    </head>
                    <body>
                        <main>
                            <header id="header">
                                <nav id="nav-bar">
                                    <ul>
                                        <li><a id="btnAdminDashboardLink" href="../View/home.php" class="nav-link">Admin Dashboard ⚙️</a></li>
                                        <li><a href="../Controller/auth_cont.php?logout=true" class="nav-link">Sign out ⌫</a></li>
                                    </ul>
                                </nav>
                            </header>

                            <div id="space"></div>

                            <div id="Offer">

                                <div class="item">
                                    <h2>' . $product->id . '</h2>
                                    <form id="update-form" method="POST" enctype="multipart/form-data">
                                        <label>Designation : <input type="text" name="designation" maxlength="30" value="' . $product->designation . '"></label>
                                        <br>
                                        <label style="display: inline-block; vertical-align: middle;">Description : </label><textarea name="description" maxlength="200" style="display: inline-block; vertical-align: middle; width: 40%; height: 60px;">' . $product->description . '</textarea>
                                        <br>
                                        <label>Brand : <input type="text" name="brand" maxlength="15" value="' . $product->brand . '"></label>
                                        <br>
                                        <label>Color : <input type="text" name="color" maxlength="15" value="' . $product->color .'"></label>
                                        <br>
                                        <label>Quantity : <input type="number" min="0" name="quantity" value="' . $product->quantity .'"></label>
                                        <br>
                                        <label>Price : <input type="number" name="price" value="' . $product->price . '"></label>
                                        <br>
                                        <br>
                                        <label>Current image : </label>
                                        <br>
                                        <br>
                                        <img src="../image/products/' . $product->id . '.jpg">
                                        <br>
                                        <label for="img_src">Change : </label>
                                        <br>
                                        <input type="file" name="img_src" id="img_src" accept="image/*">
                                        <br>
                                        <input id="btnUpdate" type="submit" name="btnUpdate" value="Update">
                                        <input id="btnCancel" type="button" value="Cancel" onclick="window.location.href = \'../View/administration.php\';">
                                    </form>
                                </div>
                            </div>
            
                                <footer>
                                    <p>&copy; 2023 Mohamed Ali Walha<p>
                                </footer>
                            </main>
                        </body>
                    </html>';
            }

            else if ($_GET["id"][0] == 0) {
                if(file_exists("../image/products/{$product->id}.jpg")) {
                    unlink("../image/products/{$product->id}.jpg");
                }
                Product::deleteProduct($product->id);
                header('location: ../View/administration.php');
            }
        }
    }
?>