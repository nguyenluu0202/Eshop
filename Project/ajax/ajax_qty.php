<?php session_start();
if (isset($_POST['id']) && isset($_POST['qty'])) {
    $id = $_POST['id'];
    $qty = (int)$_POST['qty']; // Nếu không +1 thì bên cart hãy lấy giá trị qty sau khi tăng

    if ($qty > 0) {
        $_SESSION['cart'][$id]['qty'] = $qty;
        echo $_SESSION['cart'][$id]['qty'];
    } else {
        echo "Invalid quantity.";
    }
}

?>