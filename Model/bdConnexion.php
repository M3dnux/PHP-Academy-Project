<?php
    try {
        $conn = new PDO('mysql:host=localhost;dbname=php_project_db', 'root', '');
    } 
    catch (PDOException $e) {
        die('Error : ' . $e->getMessage());
    }
?>