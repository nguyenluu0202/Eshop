<?php session_start();
include 'C:/xampp/htdocs/Project/database/connect.php';
    if(isset($_POST['id_dl'])){
        $id = $_POST['id_dl'];

        unset($_SESSION['cart'][$id]);
    }

?>