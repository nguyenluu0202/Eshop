<?php
    include 'C:/xampp/htdocs/Project/database/connect.php';
    if(isset($_POST['id_delete'])){
        $id = $_POST['id_delete'];
        $sql = "DELETE FROM `product` where `id_product` = '$id'";
        $result = $con -> query($sql);
        exit();
    }
?>