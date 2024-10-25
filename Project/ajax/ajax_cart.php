<?php session_start();

 include 'C:/xampp/htdocs/Project/database/connect.php';
    if (isset($_POST['id'])) {
        $receivedID = $_POST['id'];
        // Trả về phản hồi cho AJAX
        echo "Received ID: " .($receivedID);
        $sql = "SELECT * FROM `product` where `id_product` = $receivedID;";
        $result = $con->query($sql);
        $data = [];
        if ($result == true) {
            $data = $result->fetch_assoc();
            
            // Nếu sản phẩm đã có trong giỏ hàng, tăng qty lên 1
            if (isset($_SESSION['cart'][$receivedID])) {
                $_SESSION['cart'][$receivedID]['qty'] += 1;
            } else {
                // Nếu sản phẩm chưa có trong giỏ hàng, khởi tạo qty là 1
                $data['qty'] = 1;
                $_SESSION['cart'][$receivedID] = $data;
            }
        
            echo "<pre>";
            var_dump($_SESSION['cart']);
        } else {
            echo "No data received.";
        }
    }
?>